<?php

require '../../connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'GET'
  &&
  isset($_GET['classroom_id'],
  $_GET['user_id'])
) {

  $classroomId = $_GET['classroom_id'];
  $userId = $_GET['user_id'];
  $data = [];

  $command = "SELECT type, COUNT(*) FROM notifications WHERE classroom_id = ? AND user_id = ? AND seen = 0 GROUP BY type";

  $statement = $connection->prepare($command);
  $statement->bind_param(
    'ii',
    $classroomId,
    $userId
  );
  $statement->execute();
  $statement->store_result();
  $statement->bind_result(
    $type,
    $count
  );

  while ($statement->fetch()) {

    $data[$type] = $count;
  }

  $response = [
    'response' => 'found',
    'info' => $data
  ];
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
