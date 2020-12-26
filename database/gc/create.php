<?php

require '../connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['user_id'],
  $_POST['name'],
  $_POST['members'])
) {

  $userId = $_POST['user_id'];
  $name = $_POST['name'];
  $members = $_POST['members'];
  $value = $_POST['value'];
  $dateNow = date('Y-m-d H:i:s');
  $isSender = 0;

  $command = 'INSERT INTO group_chats(admin_id, name, date_time_created) VALUES(?, ?, ?)';

  $statement = $connection->prepare($command);
  $statement->bind_param(
    'iss',
    $userId,
    $name,
    $dateNow
  );
  $statement->execute();

  $gcId = mysqli_insert_id($connection);

  $statement->close();

  $commandMember = 'INSERT INTO group_chat_members(group_chat_id, user_id) VALUES(?, ?)';
  $commandValue = 'INSERT INTO group_chat_messages(group_chat_id, owner_id, other_id, is_sender, value, date_time_sent, date_time_received) VALUES(?, ?, ?, ?, ?, ?, ?)';

  $statementMember = $connection->prepare($commandMember);
  $statementMember->bind_param('ii', $gcId, $memberId);
  $statementValue = $connection->prepare($commandValue);
  $statementValue->bind_param(
    'iiiisss',
    $gcId,
    $memberId,
    $userId,
    $isSender,
    $value,
    $dateNow,
    $dateReceived
  );

  foreach ($members as $member) {

    $memberId = $member;
    $dateReceived = null;

    $statementMember->execute();
    $statementValue->execute();
  }

  $memberId = $userId;
  $isSender = 1;
  $dateReceived = $dateNow;
  $statementValue->execute();

  $statementMember->close();
  $statementValue->close();

  $response = [
    'response' => $statement == false ? 'failed' : 'successful'
  ];
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
