<?php

require '../connection.php';
require '../ischool.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['user_id'],
  $_POST['classroom_id'],
  $_POST['comment_id'])
) {

  $userId = $_POST['user_id'];
  $classroomId = $_POST['classroom_id'];
  $commentId = $_POST['comment_id'];
  $dateNow = date('Y-m-d H:i:s');

  $command = 'SELECT id FROM announcement_comment_likes WHERE announcement_comment_id = ? AND user_id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param(
    'ii',
    $commentId,
    $userId
  );
  $statement->execute();

  if ($statement->fetch()) {

    $statement->close();

    $command = 'DELETE FROM announcement_comment_likes WHERE announcement_comment_id = ? AND user_id = ?';
    $statement = $connection->prepare($command);
    $statement->bind_param(
      'ii',
      $commentId,
      $userId
    );
    $statement->execute();
    $statement->close();

    Ischool::activityLog(
      $connection,
      $userId,
      $classroomId,
      'ann_com_dislike',
      $dateNow
    );

    Ischool::deleteNotif(
      $connection,
      $userId,
      'new_com_like',
      $commentId
    );
  } else {

    $statement->close();

    $command = 'INSERT INTO announcement_comment_likes(announcement_comment_id, user_id) VALUES(?, ?)';
    $statement = $connection->prepare($command);
    $statement->bind_param(
      'ii',
      $commentId,
      $userId
    );
    $statement->execute();
    $statement->close();

    Ischool::activityLog(
      $connection,
      $userId,
      $classroomId,
      'ann_com_like',
      $dateNow
    );

    Ischool::notifOthers(
      $connection,
      $userId,
      $classroomId,
      'new_com_like',
      $commentId,
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
