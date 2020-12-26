<?php

require '../connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['group_chat_id'])
) {

  $gcId = $_POST['group_chat_id'];

  $command = 'DELETE FROM group_chat_messages WHERE group_chat_id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param('i', $gcId);
  $statement->execute();
  $statement->close();

  $command = 'DELETE FROM group_chat_members WHERE group_chat_id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param('i', $gcId);
  $statement->execute();
  $statement->close();

  $command = 'DELETE FROM group_chats WHERE id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param('i', $gcId);
  $statement->execute();
  $statement->close();

  $response = [
    'response' => $statement == false ? 'failed' : 'successful'
  ];
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
