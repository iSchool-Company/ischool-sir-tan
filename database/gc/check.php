<?php

require '../connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'GET'
  &&
  isset($_GET['user_id'],
  $_GET['name'])
) {

  $userId = $_GET['user_id'];
  $name = $_GET['name'];

  $command = 'SELECT * FROM group_chats WHERE admin_id = ? AND name = ?';

  $statement = $connection->prepare($command);
  $statement->bind_param(
    'is',
    $userId,
    $name
  );
  $statement->execute();

  if ($statement->fetch()) {

    $response = [
      'response' => 'existing'
    ];
  } else {

    $response = [
      'response' => 'nothing'
    ];
  }
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
