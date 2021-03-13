<?php

require '../connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['username'])
) {

  $username = $_POST['username'];

  $command = 'SELECT * FROM users WHERE username = ?';

  $statement = $connection->prepare($command);
  $statement->bind_param('s', $username);
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
