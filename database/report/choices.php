<?php

require '../connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'GET'
  &&
  isset($_GET['classroom_id'],
  $_GET['user_id'],
  $_GET['type'])
) {

  $classroomId = $_GET['classroom_id'];
  $userId = $_GET['user_id'];
  $type = $_GET['type'];
  $choices = [];

  if ($type === 'Assignment') {

    $command = 'SELECT id, title FROM assignments WHERE classroom_id = ? AND deleted = 0';
  } else {

    $command = 'SELECT id, title FROM quizzes WHERE classroom_id = ? AND deleted = 0';
  }

  $statement = $connection->prepare($command);
  $statement->bind_param('i', $classroomId);
  $statement->execute();
  $statement->bind_result(
    $id,
    $title
  );

  while ($statement->fetch()) {

    $data['id'] = $id;
    $data['title'] = $title;

    $choices[] = $data;
  }

  $response = [
    'response' => $choices === [] ? 'nothing' : 'found',
    'choices' => $choices
  ];
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
