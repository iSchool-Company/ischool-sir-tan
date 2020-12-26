<?php

require '../../connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'GET'
  &&
  isset($_GET['assignment_id'],
  $_GET['sort_by'])
) {

  $assignmentId = $_GET['assignment_id'];
  $sortBy = $_GET['sort_by'];
  $ids = [];

  switch ($sortBy) {

    case 'Date Submitted':
      $command = 'SELECT asub.id FROM assignment_submissions AS asub LEFT JOIN users AS u ON asub.student_id = u.id WHERE asub.assignment_id = ? ORDER BY asub.date_time_submitted ASC, asub.grade DESC, u.last_name DESC';
      break;

    case 'Name':
      $command = 'SELECT asub.id FROM assignment_submissions AS asub LEFT JOIN users AS u ON asub.student_id = u.id WHERE asub.assignment_id = ? ORDER BY u.last_name DESC, asub.date_time_submitted ASC, asub.grade DESC';
      break;

    case 'Grade':
      $command = 'SELECT asub.id FROM assignment_submissions AS asub LEFT JOIN users AS u ON asub.student_id = u.id WHERE asub.assignment_id = ? ORDER BY asub.grade ASC, u.last_name DESC, asub.date_time_submitted ASC';
      break;
  }

  $statement = $connection->prepare($command);
  $statement->bind_param('i', $assignmentId);

  $statement->execute();

  $statement->bind_result($id);

  while ($statement->fetch()) {
    $ids[] = $id;
  }

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
