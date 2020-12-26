<?php

require 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['page_number'])) {

  $logInHistory = [];
  $pageNumber = ($_GET['page_number'] - 1) * 10;

  $command = 'SELECT lih.id, lih.date_time_log_in, lih.date_time_log_out, u.username, u.type FROM log_in_history AS lih LEFT JOIN users AS u ON lih.person_id = u.id ORDER BY lih.id DESC LIMIT ?, 10 ';

  $statement = $connection->prepare($command);
  $statement->bind_param('i', $pageNumber);
  $statement->execute();
  $statement->store_result();
  $statement->bind_result(
    $id,
    $logIn,
    $logOut,
    $username,
    $type
  );

  while ($statement->fetch()) {
    $data['id'] = $id;
    $data['log_in'] = $logIn;
    $data['log_out'] = $logOut;
    $data['username'] = $username;
    $data['type'] = $type;

    $logInHistory[] = $data;
  }

  $response = [
    'response' => $logInHistory === null ? 'nothing' : 'found',
    'log_in_history' => $logInHistory
  ];

  echo json_encode($response);
} else {

  $response = [
    'response' => 'unauthorized'
  ];

  echo json_encode($response);
}
