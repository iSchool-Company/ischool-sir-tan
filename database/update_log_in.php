<?php

require 'connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['user_id'],
  $_POST['log_in_id'])
) {

  $userId = $_POST['user_id'];
  $logInId = $_POST['log_in_id'];
  $dateNow = date('Y-m-d H:i:s');

  $command = 'UPDATE users SET last_date_time_online = ? WHERE id = ?';

  $statement = $connection->prepare($command);
  $statement->bind_param(
    'si',
    $dateNow,
    $userId
  );
  $statement->execute();

  $command = 'UPDATE log_in_history SET date_time_log_out = ? WHERE id = ?';

  $statement = $connection->prepare($command);
  $statement->bind_param(
    'si',
    $dateNow,
    $logInId
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
