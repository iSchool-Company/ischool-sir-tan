<?php

require '../connection.php';
require '../ischool.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['user_id'],
  $_POST['pin_id'],
  $_POST['classroom_id'],
  $_POST['materials_id'])
) {

  $userId = $_POST['user_id'];
  $pinId = $_POST['pin_id'];
  $classroomId = $_POST['classroom_id'];
  $materialsId = $_POST['materials_id'];
  $dateNow = date('Y-m-d H:i:s');

  $command = 'SELECT file, file_name FROM materials WHERE id = ?';

  $statement = $connection->prepare($command);
  $statement->bind_param('i', $materialsId);
  $statement->execute();
  $statement->bind_result(
    $file,
    $fileName
  );

  if ($statement->fetch()) {

    $statement->close();

    $command = 'SELECT * FROM materials WHERE file_name = ? AND classroom_id = ?';
    $statement = $connection->prepare($command);
    $statement->bind_param(
      'si',
      $fileName,
      $pinId
    );
    $statement->execute();

    if ($statement->fetch()) {

      $response = [
        'response' => 'existing'
      ];

      die(json_encode($response));
    }

    $statement->close();

    if ($file !== null) {

      $pinFile = 'files/materials/' . $pinId . '_' . str_replace(' ', '_', $fileName);
      $copySuccess = copy('../../' . $file, '../../' . $pinFile);
    }

    $command = 'INSERT INTO materials(classroom_id, file, file_name, date_time_added) VALUES(?, ?, ?, ?)';
    $statement = $connection->prepare($command);
    $statement->bind_param(
      'isss',
      $pinId,
      $pinFile,
      $fileName,
      $dateNow
    );
    $statement->execute();
    $statement->close();

    $matId = mysqli_insert_id($connection);
  }

  Ischool::activityLog(
    $connection,
    $userId,
    $pinId,
    'mat_pin',
    $dateNow
  );

  Ischool::notifStudents(
    $connection,
    $userId,
    $pinId,
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
