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

  $command = 'INSERT INTO group_chat_members(group_chat_id, user_id) VALUES(?, ?)';
  $statement = $connection->prepare($command);
  $statement->bind_param(
    'ii',
    $gcId,
    $userId
  );
  $statement->execute();

  $command = 'INSERT INTO group_chat_messages(group_chat_id, owner_id, other_id, value, date_time_sent) SELECT ?, ?, other_id, value, date_time_sent FROM group_chat_messages WHERE is_sender = 1 AND group_chat_id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param(
    'iii',
    $gcId,
    $userId,
    $gcId
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
