<?php

require '../connection.php';
require '../ischool.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['user_id'],
  $_POST['classroom_id'],
  $_POST['announcement_id'])
) {

  $userId = $_POST['user_id'];
  $classroomId = $_POST['classroom_id'];
  $announcementId = $_POST['announcement_id'];
  $dateNow = date('Y-m-d H:i:s');

  $command = 'SELECT * FROM announcement_likes WHERE announcement_id = ? AND user_id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param(
    'ii',
    $announcementId,
    $userId
  );
  $statement->execute();

  if ($statement->fetch()) {

    $statement->close();

    $command = 'DELETE FROM announcement_likes WHERE announcement_id = ? AND user_id = ?';
    $statement = $connection->prepare($command);
    $statement->bind_param(
      'ii',
      $announcementId,
      $userId
    );
    $statement->execute();
    $statement->close();

    Ischool::activityLog(
      $connection,
      $userId,
      $classroomId,
      'ann_dislike',
      $dateNow
    );

    Ischool::deleteNotif(
      $connection,
      $userId,
      'new_ann_like',
      $announcementId
    );
  } else {

    $statement->close();

    $command = 'INSERT INTO announcement_likes(announcement_id, user_id) VALUES(?, ?)';
    $statement = $connection->prepare($command);
    $statement->bind_param(
      'ii',
      $announcementId,
      $userId
    );
    $statement->execute();
    $statement->close();

    Ischool::activityLog(
      $connection,
      $userId,
      $classroomId,
      'ann_like',
      $dateNow
    );

    Ischool::notifOthers(
      $connection,
      $userId,
      $classroomId,
      'new_ann_like',
      $announcementId,
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
