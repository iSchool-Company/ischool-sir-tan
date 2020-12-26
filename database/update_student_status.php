<?php

require 'connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['action'],
  $_POST['user_id'],
  $_POST['classroom_id'],
  $_POST['activity_code'])
) {

  $action = $_POST['action'];
  $userId = $_POST['user_id'];
  $classroomId = $_POST['classroom_id'];
  $activityCode = $_POST['activity_code'];
  $dateNow = date('Y-m-d H:i:s');

  if ($action === 'positive') {
    $command = 'UPDATE classroom_student_designation SET pending = 0 WHERE classroom_id = ? AND student_id = ?';
  } else {
    $command = 'DELETE FROM classroom_student_designation WHERE classroom_id = ? AND student_id = ?';
  }

  $statement = $connection->prepare($command);
  $statement->bind_param(
    'ii',
    $classroomId,
    $userId
  );
  $statement->execute();

  switch ($activityCode) {

    case 'tea_accept':

      $command = 'INSERT INTO notifications(user_id, classroom_id, type, source_id) VALUES(?, ?, "accept_request", 0)';

      $statement = $connection->prepare($command);
      $statement->bind_param(
        'ii',
        $userId,
        $classroomId
      );
      $statement->execute();

      $command = 'INSERT INTO notifications(user_id, classroom_id, type, source_id) SELECT student_id, ?, "new_student", ? FROM classroom_student_designation WHERE classroom_id = ? AND pending = 0';

      $statement = $connection->prepare($command);
      $statement->bind_param(
        'iii',
        $classroomId,
        $userId,
        $classroomId
      );
      $statement->execute();

      $userId = $_POST['teacher_id'];

      break;

    case 'cro_remove':

      $command = 'INSERT INTO notifications(user_id, classroom_id, type, source_id) VALUES(?, ?, "remove_student", 0)';

      $statement = $connection->prepare($command);
      $statement->bind_param(
        'ii',
        $userId,
        $classroomId
      );
      $statement->execute();

      $command = 'INSERT INTO notifications(user_id, classroom_id, type, source_id) SELECT student_id, ?, "remove_student", ? FROM classroom_student_designation WHERE classroom_id = ? AND pending = 0';

      $statement = $connection->prepare($command);
      $statement->bind_param(
        'iii',
        $classroomId,
        $userId,
        $classroomId
      );
      $statement->execute();

      $userId = $_POST['teacher_id'];

      break;

    case 'stud_leave':

      $command = 'INSERT INTO notifications(user_id, classroom_id, type, source_id) VALUES(?, ?, "left_student", 0)';

      $statement = $connection->prepare($command);
      $statement->bind_param(
        'ii',
        $userId,
        $classroomId
      );
      $statement->execute();

      $command = 'INSERT INTO notifications(user_id, classroom_id, type, source_id) SELECT student_id, ?, "left_student", ? FROM classroom_student_designation WHERE classroom_id = ? AND pending = 0';

      $statement = $connection->prepare($command);
      $statement->bind_param(
        'iii',
        $classroomId,
        $userId,
        $classroomId
      );
      $statement->execute();

      break;

    default:

      $userId = $_POST['teacher_id'];
  }

  $command = 'INSERT INTO activity_log(person_id, action, source_id, date_time_did) VALUES(?, ?, ?, ?)';
  $statement = $connection->prepare($command);
  $statement->bind_param(
    'isis',
    $userId,
    $activityCode,
    $classroomId,
    $dateNow
  );
  $statement->execute();

  $response = [
    'response' => $statement === false ? 'failed' : 'successful'
  ];
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
