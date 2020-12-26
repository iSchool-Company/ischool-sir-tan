<?php

require '../../connection.php';
require '../../ischool.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['action'],
  $_POST['user_id'],
  $_POST['classroom_id'],
  $_POST['teacher_id'])
) {

  $action = $_POST['action'];
  $userId = $_POST['user_id'];
  $teacherId = $_POST['teacher_id'];
  $classroomId = $_POST['classroom_id'];
  $dateNow = date('Y-m-d H:i:s');

  if ($action === 'positive') {

    Ischool::notifStudents(
      $connection,
      $teacherId,
      $classroomId,
      'new_student',
      $classroomId,
      $dateNow
    );

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
  $statement->close();

  $command = 'DELETE FROM notifications WHERE classroom_id = ? AND doer_id = ? AND type = "new_request"';
  $statement = $connection->prepare($command);
  $statement->bind_param(
    'ii',
    $classroomId,
    $userId
  );
  $statement->execute();
  $statement->close();

  if ($action === 'positive') {

    $command = 'INSERT INTO assignment_submissions(assignment_id, student_id, due_date, due_time, date_time_assigned) SELECT id, ?, due_date, due_time, date_time_published FROM assignments WHERE classroom_id = ? AND date_time_published IS NOT NULL';
    $statement = $connection->prepare($command);
    $statement->bind_param(
      'ii',
      $userId,
      $classroomId
    );
    $statement->execute();
    $statement->close();

    $command = 'INSERT INTO quiz_submissions(quiz_id, student_id, due_date, due_time, date_time_assigned) SELECT id, ?, due_date, due_time, date_time_published FROM quizzes WHERE classroom_id = ? AND date_time_published IS NOT NULL';
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
      'tea_accept',
      $dateNow
    );

    Ischool::notifStudent(
      $connection,
      $teacherId,
      $userId,
      $classroomId,
      'accept_request',
      $classroomId,
      $dateNow
    );
  } else {

    Ischool::activityLog(
      $connection,
      $userId,
      $classroomId,
      'tea_decline',
      $dateNow
    );

    Ischool::notifStudent(
      $connection,
      $teacherId,
      $userId,
      $classroomId,
      'decline_request',
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
