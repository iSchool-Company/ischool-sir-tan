<?php

require '../connection.php';
require '../ischool.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['user_id'],
  $_POST['classroom_id'],
  $_POST['submission_id'],
  $_POST['due_date'],
  $_POST['due_time'])
) {

  $userId = $_POST['user_id'];
  $classroomId = $_POST['classroom_id'];
  $submissionId = $_POST['submission_id'];
  $default = null;
  $dateNow = date('Y-m-d H:i:s');
  $dueDate = $_POST['due_date'];
  $dueTime = $_POST['due_time'];
  $dateTimePublished = $dateNow;

  $command = 'UPDATE quiz_submissions SET due_date = ?, due_time = ?, date_time_assigned = ?, score = ?, date_time_took = ?, date_time_done = ? WHERE id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param(
    'sssissi',
    $dueDate,
    $dueTime,
    $dateTimePublished,
    $default,
    $default,
    $default,
    $submissionId
  );
  $statement->execute();
  $statement->close();

  $command = 'SELECT quiz_id, student_id FROM quiz_submissions WHERE id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param('i', $submissionId);
  $statement->execute();
  $statement->bind_result(
    $quizId,
    $stdId
  );
  $statement->fetch();
  $statement->close();

  Ischool::activityLog(
    $connection,
    $userId,
    $classroomId,
    'quiz_retake',
    $dateNow
  );

  Ischool::notifStudent(
    $connection,
    $userId,
    $stdId,
    $classroomId,
    'retake_quiz',
    $quizId,
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
