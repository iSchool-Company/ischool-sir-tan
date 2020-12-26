<?php

require '../../connection.php';
require '../../ischool.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'GET'
  &&
  isset($_GET['user_id'],
  $_GET['classroom_id'])
) {

  $userId = $_GET['user_id'];
  $classroomId = $_GET['classroom_id'];
  $ids = [];

  $command = 'SELECT id FROM materials WHERE classroom_id = ? ORDER BY id ASC';

  $statement = $connection->prepare($command);
  $statement->bind_param('i', $classroomId);

  $statement->execute();

  $statement->bind_result($id);

  while ($statement->fetch()) {
    $ids[] = $id;
  }

  $statement->close();

  Ischool::updateNotifSeen(
    $connection,
    $userId,
    $classroomId,
    'materials'
  );

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
