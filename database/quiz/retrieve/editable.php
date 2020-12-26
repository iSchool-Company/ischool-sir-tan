<?php

require '../../connection.php';
require '../../utilities.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'GET'
  &&
  isset($_GET['quiz_id'])
) {

  $quizId = $_GET['quiz_id'];
  $data = [];

  $command = 'SELECT title, description, type_id, duration_id FROM quizzes WHERE id = ?';

  $statement = $connection->prepare($command);
  $statement->bind_param('i', $quizId);
  $statement->execute();

  $statement->bind_result(
    $title,
    $description,
    $type,
    $duration
  );

  if ($statement->fetch()) {

    $data['title'] = $title;
    $data['description'] = $description;
    $data['type'] = $type;
    $data['duration'] = $duration;
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
