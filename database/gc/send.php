<?php

require '../connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['user_id'],
  $_POST['group_chat_id'],
  $_POST['value'])
) {

  $userId = $_POST['user_id'];
  $groupChatId = $_POST['group_chat_id'];
  $value = $_POST['value'];
  $dateNow = date('Y-m-d h:i:s');

  $command = 'SELECT admin_id FROM group_chats WHERE id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param('i', $groupChatId);
  $statement->execute();
  $statement->store_result();
  $statement->bind_result($adminId);
  $statement->execute();

  $statement->fetch();
  $statement->close();

  $isSender = $userId == $adminId ? 1 : 0;
  $dateReceived = $userId == $adminId ? $dateNow : null;

  $command = 'INSERT INTO group_chat_messages(group_chat_id, owner_id, other_id, is_sender, value, date_time_sent, date_time_received) VALUES(?, ?, ?, ?, ?, ?, ?)';
  $statement = $connection->prepare($command);
  $statement->bind_param(
    'iiiisss',
    $groupChatId,
    $adminId,
    $userId,
    $isSender,
    $value,
    $dateNow,
    $dateReceived
  );
  $statement->execute();
  $statement->close();

  if ($userId != $adminId) {

    $isSender = 1;

    $command = 'INSERT INTO group_chat_messages(group_chat_id, owner_id, other_id, is_sender, value, date_time_sent, date_time_received) VALUES(?, ?, ?, ?, ?, ?, ?)';
    $statement = $connection->prepare($command);
    $statement->bind_param(
      'iiiisss',
      $groupChatId,
      $userId,
      $userId,
      $isSender,
      $value,
      $dateNow,
      $dateNow
    );
    $statement->execute();
    $statement->close();
  }

  $isSender = 0;

  $command = 'INSERT INTO group_chat_messages(group_chat_id, owner_id, other_id, is_sender, value, date_time_sent) SELECT group_chat_id, user_id, ?, ?, ?, ? FROM group_chat_members WHERE group_chat_id = ? AND user_id != ?';
  $statement = $connection->prepare($command);
  $statement->bind_param(
    'iissii',
    $userId,
    $isSender,
    $value,
    $dateNow,
    $groupChatId,
    $userId
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
