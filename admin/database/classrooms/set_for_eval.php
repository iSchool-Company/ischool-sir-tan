<?php

require '../connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['classroomId'],
  $_POST['isSet'])
) {

  $classroomId = $_POST['classroomId'];
  $isSet = $_POST['isSet'];

  $command = 'UPDATE classrooms SET is_review_open = ? WHERE id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param(
    'ii',
    $isSet,
    $classroomId
  );
  $statement->execute();
  $statement->close();

  $response = [
    'response' => $statement == false ? 'failed' : 'successful'
  ];
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
