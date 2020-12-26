<?php

require '../../connection.php';
require '../../utilities.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'GET'
  &&
  isset($_GET['assignment_id'])
) {

  $assId = $_GET['assignment_id'];
  $data = [];

  $command = 'SELECT title, description, file, file_name FROM assignments WHERE id = ?';

  $statement = $connection->prepare($command);
  $statement->bind_param('i', $assId);
  $statement->execute();

  $statement->bind_result(
    $title,
    $description,
    $file,
    $fileName
  );

  if ($statement->fetch()) {

    $data['title'] = $title;
    $data['description'] = $description;
    $data['file'] = $file;
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
