<?php

require '../connection.php';
require '../ischool.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['user_id'],
  $_POST['classroom_id'],
  $_POST['reply_id'])
) {

  $userId = $_POST['user_id'];
  $classroomId = $_POST['classroom_id'];
  $replyId = $_POST['reply_id'];
  $dateNow = date('Y-m-d H:i:s');

  $command = 'SELECT announcement_id FROM announcement_replies WHERE id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param('i', $replyId);
  $statement->execute();
  $statement->bind_result($commentId);
  $statement->fetch();
  $statement->close();

  $command = 'DELETE FROM announcement_replies WHERE id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param('i', $replyId);
  $statement->execute();
  $statement->close();

  Ischool::activityLog(
    $connection,
    $userId,
    $classroomId,
    'ann_rep_del',
    $dateNow
  );

  Ischool::deleteNotif(
    $connection,
    $userId,
    'new_reply',
    $commentId
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
