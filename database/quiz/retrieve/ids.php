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

    $command = 'SELECT q.id FROM quiz_submissions AS qsub LEFT JOIN quizzes AS q ON qsub.quiz_id = q.id WHERE q.classroom_id = ? AND qsub.student_id = ? AND qsub.date_time_assigned IS NOT NULL AND q.deleted = 0 ORDER BY qsub.date_time_assigned ASC';

    $statement = $connection->prepare($command);
    $statement->bind_param(
      'ii',
      $classroomId,
      $userId
    );
  } else {

    $command = 'SELECT id FROM quizzes WHERE classroom_id = ? AND deleted = 0 ORDER BY id ASC';

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
    'quizzes'
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
