<?php

require '../connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['user_id'],
  $_POST['quiz_id'])
) {

  $userId = $_POST['user_id'];
  $quizId = $_POST['quiz_id'];
  $dateNow = date('Y-m-d H:i:s');

  $command = 'UPDATE quiz_submissions SET date_time_done = ? WHERE quiz_id = ? AND student_id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param(
    'sii',
    $dateNow,
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
