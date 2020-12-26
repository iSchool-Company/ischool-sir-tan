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

  $command = 'UPDATE classrooms SET is_deleted = 1 WHERE id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param('i', $classroomId);
  $statement->execute();
  $statement->close();

  $command = 'DELETE FROM classroom_student_designation WHERE classroom_id = ? AND pending = 1';
  $statement = $connection->prepare($command);
  $statement->bind_param('i', $classroomId);
  $statement->execute();
  $statement->close();

  Ischool::activityLog(
    $connection,
    $userId,
    $classroomId,
    'cr_delete',
    $dateNow
  );

  Ischool::notifStudents(
    $connection,
    $userId,
    $classroomId,
    'cr_delete',
    $classroomId,
    $dateNow
  );

  $response = [
    'response' => $statement === false ? 'failed' : 'successful'
  ];
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
