<?php

require '../../connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'GET'
  &&
  isset($_GET['classroom_id'])
) {

  $classroomId = $_GET['classroom_id'];
  $materials = [];

  $command = 'SELECT id, file_name FROM materials WHERE classroom_id = ? ORDER BY id ASC';

  $statement = $connection->prepare($command);
  $statement->bind_param('i', $classroomId);

  $statement->execute();

  $statement->bind_result(
    $id,
    $fileName
  );

  while ($statement->fetch()) {
    $materials[] = [
      'id' => $id,
      'fileName' => $fileName
    ];
  }

  $statement->close();

  $response = [
    'response' => $materials === [] ? 'nothing' : 'found',
    'materials' => $materials
  ];
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
