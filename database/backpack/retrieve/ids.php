<?php

require '../../connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'GET'
  &&
  isset($_GET['user_id'])
) {

  $userId = $_GET['user_id'];
  $ids = [];

  $command = 'SELECT id FROM backpack WHERE user_id = ? ORDER BY id ASC';
  $statement = $connection->prepare($command);
  $statement->bind_param('i', $userId);
  $statement->execute();
  $statement->bind_result($id);

  while ($statement->fetch()) {
    $ids[] = $id;
  }

  $statement->close();

  $response = [
    'response' => $ids === [] ? 'nothing' : 'found',
    'ids' => $ids
  ];
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
