<?php

require '../connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['user_id'],
  $_POST['group_chat_id'])
) {

  $userId = $_POST['user_id'];
  $gcId = $_POST['group_chat_id'];

  $command = 'DELETE FROM group_chat_members WHERE group_chat_id = ? AND user_id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param(
    'ii',
    $gcId,
    $userId
  );
  $statement->execute();

  $command = 'DELETE FROM group_chat_messages WHERE group_chat_id = ? AND owner_id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param(
    'ii',
    $gcId,
    $userId
  );
  $statement->execute();

  if ($statement) {

    $response = [
      'response' => 'successful'
    ];
  } else {

    $response = [
      'response' => 'failed'
    ];
  }
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
