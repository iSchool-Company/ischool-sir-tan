<?php

require '../../connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'GET'
  &&
  isset($_GET['user_id'],
  $_GET['last_id'])
) {

  $userId = $_GET['user_id'];
  $lastId = $_GET['last_id'];
  $ids = [];
  $messages = [];

  if (isset($_GET['req_id'])) {

    $reqId = $_GET['req_id'];

    $command = 'SELECT id FROM group_chat_messages WHERE id IN (SELECT MAX(id) FROM group_chat_messages WHERE owner_id = ? AND id < ? GROUP BY group_chat_id) ORDER BY id DESC LIMIT 2';
    $statement = $connection->prepare($command);
    $statement->bind_param(
      'ii',
      $userId,
      $reqId
    );
    $statement->execute();
    $statement->store_result();
    $statement->bind_result($id);

    if ($statement->num_rows > 0) {

      while ($statement->fetch()) {

        $ids[] = $id;
      }

      if (count($ids) !== 2) {

        $hasNext = false;
      } else {

        $statement->close();

        $command = 'SELECT id FROM group_chat_messages WHERE id IN (SELECT MAX(id) FROM group_chat_messages WHERE owner_id = ? AND id < ? GROUP BY group_chat_id) ORDER BY id DESC LIMIT 1';
        $statement = $connection->prepare($command);
        $statement->bind_param(
          'ii',
          $userId,
          $id
        );
        $statement->execute();
        $statement->store_result();

        if ($statement->num_rows > 0) {

          $hasNext = true;
        } else {

          $hasNext = false;
        }
      }

      $response = [
        'response' => 'found',
        'last_id' => $ids[count($ids) - 1],
        'has_next' => $hasNext
      ];
    } else {

      $response = [
        'response' => 'nothing'
      ];
    }

    die(json_encode($response));
  }

  $command = 'SELECT id FROM group_chat_messages WHERE id IN (SELECT MAX(id) FROM group_chat_messages WHERE owner_id = ? AND id >= ? GROUP BY group_chat_id) ORDER BY id DESC';
  $statement = $connection->prepare($command);
  $statement->bind_param(
    'ii',
    $userId,
    $lastId
  );
  $statement->execute();
  $statement->store_result();
  $statement->bind_result($id);

  while ($statement->fetch()) {

    $ids[] = $id;
  }

  $statement->close();

  foreach ($ids as $id) {

    $data = [
      'id' => '',
      'gc_id' => '',
      'gc_name' => '',
      'other_name' => '',
      'other_image' => '',
      'value' => '',
      'is_sender' => '',
      'date_time_sent' => '',
      'seen' => 0
    ];

    $command = 'SELECT group_chat_id, other_id, value, image, is_sender, date_time_sent, date_time_received FROM group_chat_messages WHERE id = ? ORDER BY date_time_sent DESC LIMIT 1';
    $statement = $connection->prepare($command);
    $statement->bind_param('i', $id);
    $statement->execute();
    $statement->store_result();
    $statement->bind_result(
      $gcId,
      $otherId,
      $value,
      $image,
      $isSender,
      $dateTimeSent,
      $dateTimeReceived
    );

    if ($statement->fetch()) {

      $data['id'] = $id;
      $data['gc_id'] = $gcId;
      $data['value'] = $value;
      $data['is_sender'] = $isSender;

      $dateDiff = strtotime(date('Y-m-d H:i:s')) - strtotime($dateTimeSent);

      if ($dateDiff > 86400) {
        $data['date_time_sent'] = date('M d, Y h:i A', strtotime($dateTimeSent));
      } else if ($dateDiff > 7200) {
        $data['date_time_sent'] = intval($dateDiff / 3600) . ' hours ago';
      } else if ($dateDiff > 3600) {
        $data['date_time_sent'] = intval($dateDiff / 3600) . ' hour ago';
      } else if ($dateDiff > 120) {
        $data['date_time_sent'] = intval($dateDiff / 60) . ' minutes ago';
      } else if ($dateDiff > 60) {
        $data['date_time_sent'] = intval($dateDiff / 60) . ' minute ago';
      } else {
        $data['date_time_sent'] = 'Just Now!';
      }

      if ($dateTimeReceived == null) {
        $data['seen'] = 0;
      } else {
        $data['seen'] = 1;
      }
    }

    $statement->close();

    $command = 'SELECT name FROM group_chats WHERE id = ?';
    $statement = $connection->prepare($command);
    $statement->bind_param('i', $gcId);
    $statement->execute();
    $statement->store_result();
    $statement->bind_result($gcName);

    if ($statement->fetch()) {

      $data['gc_name'] = $gcName;
    }

    $statement->close();

    $command = 'SELECT first_name, profile_picture FROM users WHERE id = ?';
    $statement = $connection->prepare($command);
    $statement->bind_param('i', $otherId);
    $statement->execute();
    $statement->store_result();
    $statement->bind_result(
      $otherName,
      $otherImage
    );

    if ($statement->fetch()) {

      $data['other_name'] = $otherName;
      $data['other_image'] = $otherImage;
    }

    $messages[] = $data;
  }

  $response = [
    'response' => $messages == null ? 'nothing' : 'found',
    'messages' => $messages
  ];
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
