<?php

require '../connection.php';
require '../ischool.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['user_id'],
  $_POST['classroom_id'],
  $_POST['assignment_id'],
  $_POST['title'],
  $_POST['description'],
  $_POST['changed'])
) {

  $userId = $_POST['user_id'];
  $classroomId = $_POST['classroom_id'];
  $assignmentId = $_POST['assignment_id'];
  $title = $_POST['title'];
  $description = $_POST['description'];
  $changed = $_POST['changed'];
  $dateNow = date('Y-m-d H:i:s');

  $command = 'UPDATE assignments SET title = ?, description = ?, version = version + 1 WHERE id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param(
    'ssi',
    $title,
    $description,
    $assignmentId
  );
  $statement->execute();

  if ($changed === 'true') {

    $command = 'SELECT file FROM assignments WHERE id = ?';
    $statement = $connection->prepare($command);
    $statement->bind_param('i', $assignmentId);
    $statement->execute();
    $statement->bind_result($file);

    if ($statement->fetch() && $file != null) {

      unlink('../../' . $file);
    }

    $statement->close();

    $target = null;
    $fileName = null;

    $command = 'UPDATE assignments SET file = ?, file_name = ?, version = version + 1 WHERE id = ?';
    $statement = $connection->prepare($command);
    $statement->bind_param(
      'ssi',
      $target,
      $fileName,
      $assignmentId
    );
    $statement->execute();
    $statement->close();
  }

  if (isset($_FILES['file'])) {

    $file = $_FILES['file'];
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $target = 'files/assignments_post/';
    $target .= $classroomId . '_' . str_replace(' ', '_', $title) . '.' . $extension;
    $fileName = str_replace(' ', '_', basename($file['name']));

    move_uploaded_file($file["tmp_name"], '../../' . $target);

    $command = 'UPDATE assignments SET file = ?, file_name = ?, version = version + 1 WHERE id = ?';
    $statement = $connection->prepare($command);
    $statement->bind_param(
      'ssi',
      $target,
      $fileName,
      $assignmentId
    );
    $statement->execute();
    $statement->close();
  }

  Ischool::activityLog(
    $connection,
    $userId,
    $classroomId,
    'ass_edit',
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
