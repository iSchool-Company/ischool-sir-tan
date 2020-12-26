<?php

require '../connection.php';
require '../ischool.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['user_id'],
  $_POST['classroom_id'])
) {

  $userId = $_POST['user_id'];
  $classroomId = $_POST['classroom_id'];
  $dateNow = date('Y-m-d H:i:s');

  $command = 'INSERT INTO classroom_student_designation(classroom_id, student_id, pending) VALUES(?, ?, 1)';

  $statement = $connection->prepare($command);
  $statement->bind_param(
    'ii',
    $classroomId,
    $userId
  );
  $statement->execute();
  $statement->close();

  Ischool::activityLog(
    $connection,
    $userId,
    $classroomId,
    'stud_join',
    $dateNow
  );

  Ischool::notifTeacher(
    $connection,
    $userId,
    $classroomId,
    'new_request',
    $userId,
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
