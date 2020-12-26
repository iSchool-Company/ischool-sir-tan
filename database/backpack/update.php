<?php

require '../connection.php';
require '../ischool.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['user_id'],
  $_POST['backpack_id'],
  $_POST['file_name'],
  $_POST['changed'])
) {

  $userId = $_POST['user_id'];
  $backpackId = $_POST['backpack_id'];
  $fileName = $_POST['file_name'];
  $changed = $_POST['changed'];
  $dateNow = date('Y-m-d H:i:s');

  $command = 'SELECT file, file_name FROM backpack WHERE id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param('i', $backpackId);
  $statement->execute();
  $statement->bind_result(
    $oldFile,
    $oldFileName
  );

  if ($statement->fetch()) {

    $statement->close();

    $newFile = 'files/backpack/' . $userId . '_' . str_replace(' ', '_', $fileName) . '.' . pathinfo($oldFile, PATHINFO_EXTENSION);
    $newFileName = str_replace(' ', '_', $fileName) . '.' . pathinfo($oldFile, PATHINFO_EXTENSION);

    if ($changed === 'true') {

      $tempFileName = str_replace(' ', '_', $fileName) . '.' . pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
    } else {

      $tempFileName = $newFileName;
    }

    $command = 'SELECT * FROM backpack WHERE file_name = ? AND id != ? AND user_id = ?';
    $statement = $connection->prepare($command);
    $statement->bind_param(
      'sii',
      $tempFileName,
      $backpackId,
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

    rename('../../' . $oldFile, '../../' . $newFile);
  }

  $command = 'UPDATE backpack SET file = ?, file_name = ? WHERE id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param(
    'ssi',
    $newFile,
    $newFileName,
    $backpackId
  );
  $statement->execute();

  if ($changed === 'true') {

    unlink('../../' . $newFile);
  }

  if (isset($_FILES['file'])) {

    $file = $_FILES['file'];
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $target = 'files/backpack/';
    $target .= $userId . '_' . str_replace(' ', '_', $fileName) . '.' . $extension;
    $fileName = str_replace(' ', '_', $fileName) . '.' . $extension;

    move_uploaded_file($file["tmp_name"], '../../' . $target);

    $command = 'UPDATE backpack SET file = ?, file_name = ? WHERE id = ?';
    $statement = $connection->prepare($command);
    $statement->bind_param(
      'ssi',
      $target,
      $fileName,
      $backpackId
    );
    $statement->execute();
    $statement->close();
  }

  Ischool::activityLog(
    $connection,
    $userId,
    0,
    'back_edit',
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
