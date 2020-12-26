<?php

require '../../connection.php';
require '../../utilities.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'GET'
  &&
  isset($_GET['backpack_id'],
  $_GET['version'])
) {

  $backpackId = $_GET['backpack_id'];
  $version = $_GET['version'];
  $data = [];

  $command = 'SELECT file, file_name, date_time_added FROM backpack WHERE id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param('i', $backpackId);
  $statement->execute();
  $statement->bind_result(
    $file,
    $fileName,
    $dateTimeAdded
  );

  if ($statement->fetch()) {

    $data['file'] = $file;
    $data['file_name'] = $fileName;
    $data['date_time_added'] = date('M d, Y h:i a', strtotime($dateTimeAdded));
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
