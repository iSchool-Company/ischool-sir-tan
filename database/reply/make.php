<?php

require '../connection.php';
require '../ischool.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['user_id'],
  $_POST['classroom_id'],
  $_POST['comment_id'],
  $_POST['content'])
) {

  $userId = $_POST['user_id'];
  $classroomId = $_POST['classroom_id'];
  $commentId = $_POST['comment_id'];
  $content = $_POST['content'];
  $dateNow = date('Y-m-d H:i:s');

  $command = 'INSERT INTO announcement_replies(announcement_comment_id, user_id, content, date_time_replied) VALUES(?, ?, ?, ?)';
  $statement = $connection->prepare($command);
  $statement->bind_param(
    'iiss',
    $commentId,
    $userId,
    $content,
    $dateNow
  );
  $statement->execute();
  $statement->close();

  $repId = $connection->insert_id;

  Ischool::activityLog(
    $connection,
    $userId,
    $classroomId,
    'ann_reply',
    $dateNow
  );

  Ischool::notifOthers(
    $connection,
    $userId,
    $classroomId,
    'new_reply',
    $commentId,
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
