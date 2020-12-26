<?php

require '../connection.php';
require '../ischool.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['user_id'],
  $_POST['classroom_id'],
  $_POST['materials_id'],
  $_POST['topic'],
  $_POST['changed'])
) {

  $userId = $_POST['user_id'];
  $classroomId = $_POST['classroom_id'];
  $materialsId = $_POST['materials_id'];
  $topic = $_POST['topic'];
  $changed = $_POST['changed'];
  $dateNow = date('Y-m-d H:i:s');

  $command = 'SELECT file, file_name FROM materials WHERE id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param('i', $materialsId);
  $statement->execute();
  $statement->bind_result(
    $oldFile,
    $oldFileName
  );

  if ($statement->fetch()) {

    $statement->close();

    $newFile = 'files/materials/' . $classroomId . '_' . str_replace(' ', '_', $topic) . '.' . pathinfo($oldFile, PATHINFO_EXTENSION);
    $newFileName = $topic . '.' . pathinfo($oldFile, PATHINFO_EXTENSION);

    if ($changed === 'true') {

      $tempFileName = str_replace(' ', '_', $topic) . '.' . pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
    } else {

      $tempFileName = $newFileName;
    }

    $command = 'SELECT * FROM materials WHERE file_name = ? AND id != ? AND classroom_id = ?';
    $statement = $connection->prepare($command);
    $statement->bind_param(
      'sii',
      $tempFileName,
      $materialsId,
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

    rename('../../' . $oldFile, '../../' . $newFile);
  }

  $command = 'UPDATE materials SET file = ?, file_name = ? WHERE id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param(
    'ssi',
    $newFile,
    $newFileName,
    $materialsId
  );
  $statement->execute();

  if ($changed === 'true') {

    unlink('../../' . $newFile);
  }

  if (isset($_FILES['file'])) {

    $file = $_FILES['file'];
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $target = 'files/materials/';
    $target .= $classroomId . '_' . str_replace(' ', '_', $topic) . '.' . $extension;
    $fileName = $topic . '.' . $extension;

    move_uploaded_file($file["tmp_name"], '../../' . $target);

    $command = 'UPDATE materials SET file = ?, file_name = ? WHERE id = ?';
    $statement = $connection->prepare($command);
    $statement->bind_param(
      'ssi',
      $target,
      $fileName,
      $materialsId
    );
    $statement->execute();
    $statement->close();
  }

  Ischool::activityLog(
    $connection,
    $userId,
    $classroomId,
    'mat_edit',
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
