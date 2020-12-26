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

  $command = 'SELECT id FROM announcement_reply_likes WHERE announcement_reply_id = ? AND user_id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param(
    'ii',
    $replyId,
    $userId
  );
  $statement->execute();

  if ($statement->fetch()) {

    $statement->close();

    $command = 'DELETE FROM announcement_reply_likes WHERE announcement_reply_id = ? AND user_id = ?';
    $statement = $connection->prepare($command);
    $statement->bind_param(
      'ii',
      $replyId,
      $userId
    );
    $statement->execute();
    $statement->close();

    Ischool::activityLog(
      $connection,
      $userId,
      $classroomId,
      'ann_rep_dislike',
      $dateNow
    );

    Ischool::deleteNotif(
      $connection,
      $userId,
      'new_rep_like',
      $replyId
    );
  } else {

    $statement->close();

    $command = 'INSERT INTO announcement_reply_likes(announcement_reply_id, user_id) VALUES(?, ?)';
    $statement = $connection->prepare($command);
    $statement->bind_param(
      'ii',
      $replyId,
      $userId
    );
    $statement->execute();
    $statement->close();

    Ischool::activityLog(
      $connection,
      $userId,
      $classroomId,
      'ann_rep_like',
      $dateNow
    );

    Ischool::notifOthers(
      $connection,
      $userId,
      $classroomId,
      'new_rep_like',
      $replyId,
      $dateNow
    );
  }

  $response = [
    'response' => $statement == false ? 'failed' : 'successful'
  ];
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
