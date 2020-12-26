<?php

require '../connection.php';
require '../ischool.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['user_id'],
  $_POST['classroom_id'],
  $_POST['content'])
) {

  $userId = $_POST['user_id'];
  $classroomId = $_POST['classroom_id'];
  $content = $_POST['content'];
  $dateNow = date('Y-m-d H:i:s');

  $command = 'INSERT INTO announcements(classroom_id, content, image, date_time_posted) VALUES(?, ?, "", ?)';

  $statement = $connection->prepare($command);
  $statement->bind_param(
    'iss',
    $classroomId,
    $content,
    $dateNow
  );
  $statement->execute();
  $statement->close();

  $annId = $connection->insert_id;

  Ischool::activityLog(
    $connection,
    $userId,
    $classroomId,
    'ann_post',
    $dateNow
  );

  Ischool::notifStudents(
    $connection,
    $userId,
    $classroomId,
    'new_announcement',
    $annId,
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
