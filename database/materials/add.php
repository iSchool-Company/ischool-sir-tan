<?php

require '../connection.php';
require '../ischool.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['user_id'],
  $_POST['classroom_id'],
  $_POST['file_name'],
  $_FILES['file'])
) {

  $userId = $_POST['user_id'];
  $classroomId = $_POST['classroom_id'];
  $dateNow = date('Y-m-d H:i:s');

  if (isset($_FILES['file'])) {

    $file = $_FILES['file'];
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $target = 'files/materials/';
    $target .= $classroomId . '_' . str_replace(' ', '_', $_POST['file_name']) . '.' . $extension;
    $fileName = $_POST['file_name'] . '.' . $extension;

    $command = 'SELECT * FROM materials WHERE file_name = ? AND classroom_id = ?';
    $statement = $connection->prepare($command);
    $statement->bind_param(
      'si',
      $fileName,
      $classroomId
    );
    $statement->execute();

    if ($statement->fetch()) {

      $response = [
        'response' => 'existing'
      ];

      die(json_encode($response));
    }

    $statement->close();

    move_uploaded_file($file["tmp_name"], '../../' . $target);
  } else {
    $target = null;
    $fileName = null;
  }

  $command = 'INSERT INTO materials(classroom_id, file, file_name, date_time_added) VALUES(?, ?, ?, ?)';
  $statement = $connection->prepare($command);
  $statement->bind_param(
    'isss',
    $classroomId,
    $target,
    $fileName,
    $dateNow
  );
  $statement->execute();
  $statement->close();

  $matId = mysqli_insert_id($connection);

  Ischool::activityLog(
    $connection,
    $userId,
    $classroomId,
    'mat_add',
    $dateNow
  );

  Ischool::notifStudents(
    $connection,
    $userId,
    $classroomId,
    'new_material',
    $matId,
    $dateNow
  );

  $response = [
    'response' => $statement == false ? 'failed' : 'successful'
  ];
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
