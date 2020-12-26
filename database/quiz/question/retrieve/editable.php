<?php

require '../../../connection.php';
require '../../../utilities.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'GET'
  &&
  isset($_GET['question_id'])
) {

  $questionId = $_GET['question_id'];
  $question = [];

  $command = 'SELECT value FROM quiz_questions WHERE id = ?';

  $statement = $connection->prepare($command);
  $statement->bind_param('i', $questionId);
  $statement->execute();
  $statement->bind_result($qValue);

  if ($statement->fetch()) {

    $question['value'] = $qValue;
    $question['answers'] = [];
  }

  $statement->close();

  $command = 'SELECT id, value, correct FROM quiz_question_choices WHERE quiz_question_id = ?';

  $statement = $connection->prepare($command);
  $statement->bind_param('i', $questionId);
  $statement->execute();
  $statement->bind_result(
    $id,
    $aValue,
    $correct
  );

  while ($statement->fetch()) {

    $answer['id'] = $id;
    $answer['value'] = $aValue;
    $answer['correct'] = $correct;

    $question['answers'][] = $answer;
  }

  $response = [
    'response' => $question === [] ? 'nothing' : 'found',
    'info' => $question
  ];
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
