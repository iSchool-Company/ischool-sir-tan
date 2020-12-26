<?php

require '../../connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'GET'
  &&
  isset($_GET['user_id'],
  $_GET['last_offset'])
) {

  $userId = $_GET['user_id'];
  $lastOffset = $_GET['last_offset'];
  $otherIds = [];
  $messages = [];

  $command = 'SELECT other_id FROM messages WHERE id IN (SELECT MAX(id) FROM messages WHERE owner_id = ? GROUP BY other_id) ORDER BY id DESC LIMIT ?';
  $statement = $connection->prepare($command);
  $statement->bind_param('ii', $userId, $lastOffset);
  $statement->execute();
  $statement->store_result();
  $statement->bind_result($otherId);

  while ($statement->fetch()) {

    $otherIds[] = $otherId;
  }

  $statement->close();

  foreach ($otherIds as $otherId) {

    $data = [];

    $command = 'SELECT id, value, image, is_sender, date_time_sent, date_time_received FROM messages WHERE owner_id = ? AND other_id = ? ORDER BY date_time_sent DESC LIMIT 1';
    $statement = $connection->prepare($command);
    $statement->bind_param(
      'ii',
      $userId,
      $otherId
    );
    $statement->execute();
    $statement->store_result();
    $statement->bind_result(
      $id,
      $value,
      $image,
      $isSender,
      $dateTimeSent,
      $dateTimeReceived
    );

    if ($statement->fetch()) {

      $data['id'] = $id;
      $data['value'] = $value;
      $data['image'] = $image;

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

    $command = 'SELECT CONCAT(first_name, " ", middle_name, " ", last_name), gender, username, profile_picture FROM users WHERE id = ?';
    $statement = $connection->prepare($command);
    $statement->bind_param('i', $otherId);
    $statement->execute();
    $statement->store_result();
    $statement->bind_result(
      $name,
      $gender,
      $username,
      $profilePicture
    );

    if ($statement->fetch()) {

      if ($isSender) {
        $data['who'] = 'You';
      } else if ($gender == 'Male') {
        $data['who'] = 'Him';
      } else if ($gender == 'Female') {
        $data['who'] = 'Her';
      }

      $data['other_id'] = $otherId;
      $data['other_name'] = $name;
      $data['other_username'] = $username;
      $data['other_image'] = $profilePicture;
    }

    $statement->close();

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
