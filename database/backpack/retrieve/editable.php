<?php

require '../../connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'GET'
  &&
  isset($_GET['backpack_id'])
) {

  $backpackId = $_GET['backpack_id'];
  $data = [];

  $command = 'SELECT file_name FROM backpack WHERE id = ?';

  $statement = $connection->prepare($command);
  $statement->bind_param('i', $backpackId);
  $statement->execute();
  $statement->bind_result($fileName);

  if ($statement->fetch()) {

    $data['file'] = pathinfo($fileName, PATHINFO_FILENAME);
    $data['file_name'] = $fileName;
  }

  $response = [
    'response' => $data === [] ? 'nothing' : 'found',
    'info' => $data
  ];
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
