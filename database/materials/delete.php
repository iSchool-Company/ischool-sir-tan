<?php

require '../connection.php';
require '../ischool.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['user_id'],
  $_POST['classroom_id'],
  $_POST['materials_id'])
) {

  $userId = $_POST['user_id'];
  $classroomId = $_POST['classroom_id'];
  $materialsId = $_POST['materials_id'];
  $dateNow = date('Y-m-d H:i:s');

  $command = 'SELECT file FROM materials WHERE id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param('i', $materialsId);
  $statement->execute();
  $statement->bind_result($file);

  if ($statement->fetch()) {
    unlink('../../' . $file);
  }

  $statement->close();

  $ok = Ischool::hardDelete(
    $connection,
    'materials',
    $materialsId
  );

  Ischool::activityLog(
    $connection,
    $userId,
    $classroomId,
    'mat_delete',
    $dateNow
  );

  $response = [
    'response' => $ok === false ? 'failed' : 'successful'
  ];
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
