<?php

require '../connection.php';
require '../ischool.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['user_id'],
  $_POST['quiz_id'],
  $_POST['publish_now'])
) {

  $classroomId = $_POST['classroom_id'];
  $userId = $_POST['user_id'];
  $quizId = $_POST['quiz_id'];
  $publish = $_POST['publish_now'];
  $default = null;
  $dateNow = date('Y-m-d H:i:s');

  if ($publish === 'true') {

    $dueDate = $_POST['due_date'];
    $dueTime = $_POST['due_time'];
    $dateTimePublished = $dateNow;
  } else {

    $dueDate = null;
    $dueTime = null;
    $dateTimePublished = null;
  }

  $command = 'UPDATE quizzes SET due_date = ?, due_time = ?, date_time_published = ?, version = version + 1 WHERE id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param(
    'sssi',
    $dueDate,
    $dueTime,
    $dateTimePublished,
    $quizId
  );
  $statement->execute();
  $statement->close();

  $command = 'UPDATE quiz_submissions SET due_date = ?, due_time = ?, date_time_assigned = ?, score = ?, date_time_took = ?, date_time_done = ? WHERE quiz_id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param(
    'sssisss',
    $dueDate,
    $dueTime,
    $dateTimePublished,
    $default,
    $default,
    $default,
    $quizId
  );
  $statement->execute();
  $statement->close();

  if ($publish === 'true') {

    Ischool::activityLog(
      $connection,
      $userId,
      $classroomId,
      'quiz_publish',
      $dateNow
    );

    Ischool::notifStudents(
      $connection,
      $userId,
      $classroomId,
      'new_quiz',
      $quizId,
      $dateNow
    );
  } else {

    Ischool::activityLog(
      $connection,
      $userId,
      $classroomId,
      'quiz_unpublish',
      $dateNow
    );

    Ischool::notifStudents(
      $connection,
      $userId,
      $classroomId,
      'cancel_quiz',
      $quizId,
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
