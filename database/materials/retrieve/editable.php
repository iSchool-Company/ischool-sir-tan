<?php

require '../../connection.php';
require '../../utilities.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'GET'
  &&
  isset($_GET['materials_id'])
) {

  $materialsId = $_GET['materials_id'];
  $data = [];

  $command = 'SELECT file_name FROM materials WHERE id = ?';

  $statement = $connection->prepare($command);
  $statement->bind_param('i', $materialsId);
  $statement->execute();
  $statement->bind_result(
    $fileName
  );

  if ($statement->fetch()) {

    $data['topic'] = pathinfo($fileName, PATHINFO_FILENAME);
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
