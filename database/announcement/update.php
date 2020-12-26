<?php

require '../connection.php';
require '../ischool.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['user_id'],
  $_POST['classroom_id'],
  $_POST['announcement_id'],
  $_POST['content'])
) {

  $userId = $_POST['user_id'];
  $classroomId = $_POST['classroom_id'];
  $announcementId = $_POST['announcement_id'];
  $content = $_POST['content'];
  $dateNow = date('Y-m-d H:i:s');

  $command = 'UPDATE announcements SET content = ?, version = version + 1 WHERE id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param(
    'si',
    $content,
    $announcementId
  );
  $statement->execute();
  $statement->close();

  Ischool::activityLog(
    $connection,
    $userId,
    $classroomId,
    'ann_edit',
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
