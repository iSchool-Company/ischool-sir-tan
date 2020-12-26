<?php

require '../connection.php';
require '../ischool.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['classroom_id'],
  $_POST['user_id'],
  $_POST['quiz_id'])
) {

  $classroomId = $_POST['classroom_id'];
  $userId = $_POST['user_id'];
  $quizId = $_POST['quiz_id'];
  $dateNow = date('Y-m-d H:i:s');

  Ischool::smoothDelete(
    $connection,
    'quizzes',
    $quizId
  );

  $command = 'DELETE FROM quiz_submissions WHERE quiz_id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param('i', $quizId);
  $statement->execute();
  $statement->close();

  Ischool::activityLog(
    $connection,
    $userId,
    $classroomId,
    'quiz_delete',
    $dateNow
  );

  $command = 'SELECT date_time_published FROM quizzes WHERE id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param('i', $quizId);
  $statement->execute();
  $statement->bind_result($dateTimePublished);
  $statement->fetch();

  if ($dateTimePublished !== null) {

    $statement->close();

    Ischool::notifStudents(
      $connection,
      $userId,
      $classroomId,
      'delete_quiz',
      $quizId,
      $dateNow
    );
  }

  $statement->close();

  $response = [
    'response' => $statement === false ? 'failed' : 'successful'
  ];
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
