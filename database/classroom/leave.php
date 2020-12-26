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

  $command = 'SELECT pending FROM classroom_student_designation WHERE classroom_id = ? AND student_id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param(
    'ii',
    $classroomId,
    $userId
  );
  $statement->execute();
  $statement->bind_result($pending);
  $statement->fetch();
  $statement->close();

  $command = 'DELETE FROM classroom_student_designation WHERE classroom_id = ? AND student_id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param(
    'ii',
    $classroomId,
    $userId
  );
  $statement->execute();
  $statement->close();

  if ($pending) {

    Ischool::activityLog(
      $connection,
      $userId,
      $classroomId,
      'stud_cancel',
      $dateNow
    );

    $command = 'DELETE FROM notifications WHERE classroom_id = ? AND doer_id = ? AND type = "new_request"';
    $statement = $connection->prepare($command);
    $statement->bind_param(
      'ii',
      $classroomId,
      $userId
    );
    $statement->execute();
    $statement->close();
  } else {

    $command = 'DELETE FROM assignment_submissions WHERE student_id = ? AND assignment_id IN(SELECT id FROM assignments WHERE classroom_id = ?)';
    $statement = $connection->prepare($command);
    $statement->bind_param(
      'ii',
      $userId,
      $classroomId
    );
    $statement->execute();
    $statement->close();

    $command = 'DELETE FROM quiz_submissions WHERE student_id = ? AND quiz_id IN(SELECT id FROM quizzes WHERE classroom_id = ?)';
    $statement = $connection->prepare($command);
    $statement->bind_param(
      'ii',
      $userId,
      $classroomId
    );
    $statement->execute();
    $statement->close();

    Ischool::activityLog(
      $connection,
      $userId,
      $classroomId,
      'stud_leave',
      $dateNow
    );

    Ischool::notifTeacher(
      $connection,
      $userId,
      $classroomId,
      'left_student',
      $classroomId,
      $dateNow
    );

    Ischool::notifClassmates(
      $connection,
      $userId,
      $userId,
      $classroomId,
      'left_student',
      $classroomId,
      $dateNow
    );
  }

  $response = [
    'response' => $statement === false ? 'failed' : 'successful'
  ];
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
