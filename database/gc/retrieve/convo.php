<?php

require '../../connection.php';

if ($_SERVER['REQUEST_METHOD'] = 'GET'
  &&
  isset($_GET['method'],
  $_GET['group_chat_id'],
  $_GET['user_id'])
) {

  $method = $_GET['method'];
  $gcId = $_GET['group_chat_id'];
  $userId = $_GET['user_id'];
  $dateNow = date('Y-m-d H:i:s');
  $convo = [];

  switch ($method) {

    case 'newer':

      if (!isset($_GET['ref_id'])) {

        $response = [
          'response' => 'unauthorized'
        ];

        die(json_encode($response));
      }

      $refId = $_GET['ref_id'];
      $command = 'SELECT gcm.id, u.first_name, u.profile_picture, gcm.is_sender, gcm.value, gcm.date_time_sent FROM group_chat_messages AS gcm LEFT JOIN users AS u ON gcm.other_id = u.id WHERE gcm.group_chat_id = ? AND gcm.owner_id = ? AND gcm.id > ? ORDER BY gcm.id ASC';

      $statement = $connection->prepare($command);
      $statement->bind_param(
        'iii',
        $gcId,
        $userId,
        $refId
      );
      $statement->execute();

      break;

    case 'fresh':

      $command = 'SELECT * FROM(SELECT gcm.id, u.first_name, u.profile_picture, gcm.is_sender, gcm.value, gcm.date_time_sent FROM group_chat_messages AS gcm LEFT JOIN users AS u ON gcm.other_id = u.id WHERE gcm.group_chat_id = ? AND gcm.owner_id = ? ORDER BY gcm.id DESC LIMIT 5) AS x ORDER by x.id ASC';

      $statement = $connection->prepare($command);
      $statement->bind_param(
        'ii',
        $gcId,
        $userId
      );
      $statement->execute();

      break;

    case 'later':

      if (!isset($_GET['ref_id'])) {

        $response = [
          'response' => 'unauthorized'
        ];

        die(json_encode($response));
      }

      $refId = $_GET['ref_id'];
      $command = 'SELECT gcm.id, u.first_name, u.profile_picture, gcm.is_sender, gcm.value, gcm.date_time_sent FROM group_chat_messages AS gcm LEFT JOIN users AS u ON gcm.other_id = u.id WHERE gcm.group_chat_id = ? AND gcm.owner_id = ? AND gcm.id < ? ORDER BY gcm.id DESC LIMIT 5';

      $statement = $connection->prepare($command);
      $statement->bind_param(
        'iii',
        $gcId,
        $userId,
        $refId
      );
      $statement->execute();

      break;
  }

  $statement->store_result();
  $statement->bind_result(
    $id,
    $firstName,
    $image,
    $isSender,
    $value,
    $dateTimeSent
  );

  while ($statement->fetch()) {

    $data['id'] = $id;
    $data['first_name'] = $firstName;
    $data['image'] = $image;
    $data['is_sender'] = $isSender;
    $data['value'] = $value;
    $data['date_time_sent'] = date('M d, Y H:i A', strtotime($dateTimeSent));

    $convo[] = $data;
  }

  $statement->close();

  $command = 'UPDATE group_chat_messages SET date_time_received = ? WHERE owner_id = ? AND group_chat_id = ? AND date_time_received IS NULL';

  $statement = $connection->prepare($command);
  $statement->bind_param(
    'sii',
    $dateNow,
    $userId,
    $gcId
  );
  $statement->execute();
  $statement->close();

  $response = [
    'response' => $convo == null ? 'nothing' : 'found',
    'convo' => $convo
  ];
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
