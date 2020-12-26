<?php

require '../connection.php';
require '../ischool.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['user_id'],
  $_POST['file_name'],
  $_FILES['file'])
) {

  $userId = $_POST['user_id'];
  $fileName = str_replace(' ', '_', $_POST['file_name']);
  $dateNow = date('Y-m-d H:i:s');

  if (isset($_FILES['file'])) {

    $file = $_FILES['file'];
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $target = 'files/backpack/';
    $target .= $userId . '_' . str_replace(' ', '_', $_POST['file_name']) . '.' . $extension;
    $fileName .= '.' . $extension;

    $command = 'SELECT * FROM backpack WHERE file_name = ? AND user_id = ?';
    $statement = $connection->prepare($command);
    $statement->bind_param(
      'si',
      $fileName,
      $userId
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

  $command = 'INSERT INTO backpack(user_id, file, file_name, date_time_added) VALUES(?, ?, ?, ?)';
  $statement = $connection->prepare($command);
  $statement->bind_param(
    'isss',
    $userId,
    $target,
    $fileName,
    $dateNow
  );
  $statement->execute();
  $statement->close();

  Ischool::activityLog(
    $connection,
    $userId,
    0,
    'back_add',
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
