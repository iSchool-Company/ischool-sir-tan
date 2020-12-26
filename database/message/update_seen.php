<?php

require '../connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['user_id'],
  $_POST['other_id'])
) {

  $userId = $_POST['user_id'];
  $otherId = $_POST['other_id'];
  $dateNow = date('Y-m-d H:i:s');

  $command = 'UPDATE messages SET date_time_received = ? WHERE owner_id = ? AND other_id = ? AND date_time_received IS NULL';

  $statement = $connection->prepare($command);
  $statement->bind_param(
    'sii',
    $dateNow,
    $userId,
    $otherId
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
