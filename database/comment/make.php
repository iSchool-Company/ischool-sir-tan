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

  $command = 'INSERT INTO announcement_comments(announcement_id, user_id, content, date_time_commented) VALUES(?, ?, ?, ?)';
  $statement = $connection->prepare($command);
  $statement->bind_param(
    'iiss',
    $announcementId,
    $userId,
    $content,
    $dateNow
  );
  $statement->execute();
  $statement->close();

  $comId = $connection->insert_id;

  Ischool::activityLog(
    $connection,
    $userId,
    $classroomId,
    'ann_comment',
    $dateNow
  );

  Ischool::notifOthers(
    $connection,
    $userId,
    $classroomId,
    'new_comment',
    $announcementId,
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
