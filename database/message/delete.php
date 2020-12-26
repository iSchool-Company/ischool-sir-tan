<?php

require '../connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['user_id'],
  $_POST['other_id'])
) {

  $userId = $_POST['user_id'];
  $otherId = $_POST['other_id'];

  $command = 'DELETE FROM messages WHERE owner_id = ? AND other_id = ?';

  $statement = $connection->prepare($command);
  $statement->bind_param(
    'ii',
    $userId,
    $otherId
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
