<?php

require '../../connection.php';
require '../../ischool.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'GET'
  &&
  isset($_GET['type'],
  $_GET['classroom_id'],
  $_GET['user_id'])
) {

  $type = $_GET['type'];
  $classroomId = $_GET['classroom_id'];
  $userId = $_GET['user_id'];
  $ids = [];

  if ($type === 'Student') {

    $command = 'SELECT a.id FROM assignment_submissions AS asub LEFT JOIN assignments AS a ON asub.assignment_id = a.id WHERE a.classroom_id = ? AND asub.student_id = ? AND asub.date_time_assigned IS NOT NULL AND a.deleted = 0 ORDER BY asub.date_time_assigned ASC';

    $statement = $connection->prepare($command);
    $statement->bind_param(
      'ii',
      $classroomId,
      $userId
    );
  } else {

    $command = 'SELECT id FROM assignments WHERE classroom_id = ? AND deleted = 0 ORDER BY id ASC';

    $statement = $connection->prepare($command);
    $statement->bind_param('i', $classroomId);
  }

  $statement->execute();
  $statement->bind_result($id);

  while ($statement->fetch()) {

    $ids[] = $id;
  }

  Ischool::updateNotifSeen(
    $connection,
    $userId,
    $classroomId,
    'assignments'
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
