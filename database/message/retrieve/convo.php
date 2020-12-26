<?php

require '../../connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'GET'
  &&
  isset($_GET['method'],
  $_GET['user_id'],
  $_GET['other_id'])
) {

  $method = $_GET['method'];
  $userId = $_GET['user_id'];
  $otherId = $_GET['other_id'];
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
      $command = 'SELECT id, value, is_sender, image, date_time_sent FROM messages WHERE owner_id = ? AND other_id = ? AND id > ? ORDER BY id ASC';

      $statement = $connection->prepare($command);
      $statement->bind_param(
        'iii',
        $userId,
        $otherId,
        $refId
      );
      $statement->execute();

      break;

    case 'fresh':

      $command = 'SELECT * FROM (SELECT id, value, is_sender, image, date_time_sent FROM messages WHERE owner_id = ? AND other_id = ? ORDER BY id DESC LIMIT 5) temp ORDER BY temp.id ASC';

      $statement = $connection->prepare($command);
      $statement->bind_param(
        'ii',
        $userId,
        $otherId
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
      $command = 'SELECT id, value, is_sender, image, date_time_sent FROM messages WHERE owner_id = ? AND other_id = ? AND id < ? ORDER BY id DESC LIMIT 5';

      $statement = $connection->prepare($command);
      $statement->bind_param(
        'iii',
        $userId,
        $otherId,
        $refId
      );
      $statement->execute();

      break;
  }

  $statement->store_result();
  $statement->bind_result(
    $id,
    $value,
    $isSender,
    $image,
    $dateTimeSent
  );

  while ($statement->fetch()) {

    $data['id'] = $id;
    $data['value'] = $value;
    $data['is_sender'] = $isSender;
    $data['image'] = $image;
    $data['date_time_sent'] = date('M d, Y h:i A', strtotime($dateTimeSent));

    $convo[] = $data;
  }

  $statement->close();

  $command = 'UPDATE messages SET date_time_received = ? WHERE owner_id = ? AND other_id = ? AND date_time_received IS NULL';

  $statement = $connection->prepare($command);
  $statement->bind_param(
    'sii',
    $dateNow,
    $userId,
    $otherId
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
