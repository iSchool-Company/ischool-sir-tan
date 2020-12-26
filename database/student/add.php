<?php

require '../connection.php';
require '../ischool.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['classroom_id'],
  $_POST['teacher_id'],
  $_POST['user_id'])
) {

  $classroomId = $_POST['classroom_id'];
  $teacherId = $_POST['teacher_id'];
  $userId = $_POST['user_id'];
  $dateNow = date('Y-m-d H:i:s');

  Ischool::notifStudents(
    $connection,
    $teacherId,
    $classroomId,
    'new_student',
    $userId,
    $dateNow
  );

  $command = 'INSERT INTO classroom_student_designation(classroom_id, student_id, pending) VALUES(?, ?, 0)';
  $statement = $connection->prepare($command);
  $statement->bind_param(
    'ii',
    $classroomId,
    $userId
  );
  $statement->execute();
  $statement->close();

  $command = 'INSERT INTO assignment_submissions(assignment_id, student_id, due_date, due_time, date_time_assigned) SELECT id, ?, due_date, due_time, date_time_published FROM assignments WHERE classroom_id = ? AND date_format(CONCAT(due_date, " ", due_time), "%Y-%m-%d %H:%i:%s") > now()';
  $statement = $connection->prepare($command);
  $statement->bind_param(
    'ii',
    $userId,
    $classroomId
  );
  $statement->execute();
  $statement->close();

  $command = 'INSERT INTO quiz_submissions(quiz_id, student_id, due_date, due_time, date_time_assigned) SELECT id, ?, due_date, due_time, date_time_published FROM quizzes WHERE classroom_id = ? AND date_format(CONCAT(due_date, " ", due_time), "%Y-%m-%d %H:%i:%s") > now() AND quiz_all = 1';
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
    $teacherId,
    $classroomId,
    'stud_add',
    $dateNow
  );

  Ischool::notifStudent(
    $connection,
    $teacherId,
    $userId,
    $classroomId,
    'added_student',
    0,
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
