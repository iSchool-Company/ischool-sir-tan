<?php

require 'connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'GET'
  && isset($_GET['classroom_id'],
  $_GET['user_id'])
) {

  $classroomId = $_GET['classroom_id'];
  $userId = $_GET['user_id'];
  $students = [];

  $command = 'SELECT source_id FROM notifications WHERE user_id = ? AND classroom_id = ? AND type = "new_student" AND seen = 0';

  $statement = $connection->prepare($command);
  $statement->bind_param('ii', $userId, $classroomId);
  $statement->execute();
  $statement->store_result();
  $statement->bind_result($id);

  while ($statement->fetch()) {

    $students[] = $id;
  }

  $command = 'UPDATE notifications SET seen = 1 WHERE user_id = ? AND classroom_id = ? AND type = "new_student" AND seen = 0';

  $statement = $connection->prepare($command);
  $statement->bind_param('ii', $userId, $classroomId);
  $statement->execute();

  $response = [
    'response' => $students === null ? 'nothing' : 'found',
    'students' => $students
  ];
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
