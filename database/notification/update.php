<?php

require '../connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['user_id'],
  $_POST['last_id'])
) {

  $userId = $_POST['user_id'];
  $lastId = $_POST['last_id'];

  $command = 'UPDATE notifications SET received = 1 WHERE user_id = ? AND id <= ? AND received = 0';
  $statement = $connection->prepare($command);
  $statement->bind_param(
    'ii',
    $userId,
    $lastId
  );
  $statement->execute();

  $response = [
    'response' => $statement == false ? 'failed' : 'successful'
  ];
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
