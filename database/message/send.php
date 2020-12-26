<?php

require '../connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['user_id'],
  $_POST['other_id'],
  $_POST['value'])
) {

  $userId = $_POST['user_id'];
  $otherId = $_POST['other_id'];
  $value = $_POST['value'];
  $dateNow = date('Y-m-d H:i:s');

  if (isset($_FILES['image'])) {
    $file = $_FILES['image'];
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $target = 'pictures/messages/';

    $target .= $userId . '_' . date('YmdHis', strtotime($dateNow)) . '.' . $extension;

    move_uploaded_file($file["tmp_name"], '../../' . $target);
  }

  $command = 'INSERT INTO messages(owner_id, other_id, is_sender, value, image, date_time_sent, date_time_received) VALUES(?, ?, 1, ?, ?, ?, ?), (?, ?, 0, ?, ?, ?, NULL)';

  $statement = $connection->prepare($command);
  $statement->bind_param(
    'iissssiisss',
    $userId,
    $otherId,
    $value,
    $target,
    $dateNow,
    $dateNow,
    $otherId,
    $userId,
    $value,
    $target,
    $dateNow
  );
  $statement->execute();

  $response = [
    'response' => $statement == false ? 'failed' : 'successful'
  ];
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
