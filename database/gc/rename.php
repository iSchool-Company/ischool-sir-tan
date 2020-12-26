<?php

require '../connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['group_chat_id'],
  $_POST['group_name'])
) {

  $gcId = $_POST['group_chat_id'];
  $gcName = $_POST['group_name'];

  $command = 'UPDATE group_chats SET name = ? WHERE id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param(
    'si',
    $gcName,
    $gcId
  );
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
