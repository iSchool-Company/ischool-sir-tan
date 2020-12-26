<?php

require '../connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['user_id'],
  $_POST['quiz_id'],
  $_POST['score'])
) {

  $userId = $_POST['user_id'];
  $quizId = $_POST['quiz_id'];
  $score = $_POST['score'];

  $command = 'UPDATE quiz_submissions SET score = ? WHERE quiz_id = ? AND student_id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param(
    'iii',
    $score,
    $quizId,
    $userId
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
