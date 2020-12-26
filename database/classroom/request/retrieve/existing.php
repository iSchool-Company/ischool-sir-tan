<?php

require '../../../connection.php';

if ($_SERVER['REQUEST_METHOD'] = 'GET'
  &&
  isset($_GET['user_id'],
  $_GET['first_id'],
  $_GET['last_id'])
) {

  $userId = $_GET['user_id'];
  $firstId = $_GET['first_id'];
  $lastId = $_GET['last_id'];
  $existing = [];

  $command = "SELECT csd.id FROM classrooms AS cr INNER JOIN classroom_student_designation AS csd ON cr.id = csd.classroom_id LEFT JOIN users AS u ON csd.student_id = u.id WHERE cr.teacher_id = ? AND csd.pending = 1 AND cr.is_deleted = 0 AND csd.id BETWEEN ? AND ? ORDER BY csd.id ASC";

  $statement = $connection->prepare($command);
  $statement->bind_param(
    'iii',
    $userId,
    $firstId,
    $lastId
  );
  $statement->execute();

  $statement->store_result();
  $statement->bind_result($csdId);

  while ($statement->fetch()) {
    $existing[] = $csdId;
  }

  $statement->close();

  $response = [
    'response' => $existing === [] ? 'nothing' : 'found',
    'existing' => $existing
  ];
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
