<?php

require '../../../connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'GET'
  &&
  isset($_GET['quiz_id'],
  $_GET['sort_by'])
) {

  $quizId = $_GET['quiz_id'];
  $sortBy = $_GET['sort_by'];
  $results = [];

  switch ($sortBy) {

    case 'Date Taken':
      $command = 'SELECT qs.id FROM quiz_submissions AS qs LEFT JOIN users AS u ON qs.student_id = u.id WHERE qs.quiz_id = ? ORDER BY qs.date_time_took DESC, qs.score ASC, u.last_name ASC';
      break;

    case 'Name':
      $command = 'SELECT qs.id FROM quiz_submissions AS qs LEFT JOIN users AS u ON qs.student_id = u.id WHERE qs.quiz_id = ? ORDER BY u.last_name ASC, qs.date_time_took DESC, qs.score ASC';
      break;

    case 'Score':
      $command = 'SELECT qs.id FROM quiz_submissions AS qs LEFT JOIN users AS u ON qs.student_id = u.id WHERE qs.quiz_id = ? ORDER BY qs.score DESC, u.last_name ASC, qs.date_time_took DESC';
      break;
  }

  $statement = $connection->prepare($command);
  $statement->bind_param('i', $quizId);

  $statement->execute();

  $statement->bind_result($id);

  while ($statement->fetch()) {
    $results[] = $id;
  }

  $response = [
    'response' => $results === [] ? 'nothing' : 'found',
    'results' => $results
  ];
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
