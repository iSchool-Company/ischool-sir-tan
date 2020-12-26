<?php

require '../../connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'GET'
  &&
  isset($_GET['user_id'],
  $_GET['classroom_id'])
) {

  $userId = $_GET['user_id'];
  $classroomId = $_GET['classroom_id'];
  $classrooms = [];

  $command = 'SELECT id, class, subject FROM classrooms WHERE teacher_id = ? AND is_deleted = 0 AND date_end > now() AND id != ?';
  $statement = $connection->prepare($command);
  $statement->bind_param(
    'ii',
    $userId,
    $classroomId
  );
  $statement->execute();
  $statement->store_result();
  $statement->bind_result(
    $id,
    $class,
    $subject
  );

  while ($statement->fetch()) {

    $data['id'] = $id;
    $data['name'] = $class . ' - ' . $subject;

    $classrooms[] = $data;
  }

  $response = [
    'response' => $classrooms === [] ? 'nothing' : 'found',
    'classrooms' => $classrooms
  ];
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
