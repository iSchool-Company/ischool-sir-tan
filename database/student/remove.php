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

  $command = 'DELETE FROM classroom_student_designation WHERE classroom_id = ? AND student_id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param(
    'ii',
    $classroomId,
    $userId
  );
  $statement->execute();
  $statement->close();

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
    $teacherId,
    $classroomId,
    'stud_remove',
    $dateNow
  );

  Ischool::notifStudent(
    $connection,
    $teacherId,
    $userId,
    $classroomId,
    'removed_student',
    0,
    $dateNow
  );

  Ischool::notifStudents(
    $connection,
    $teacherId,
    $classroomId,
    'remove_student',
    $userId,
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
