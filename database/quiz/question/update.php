<?php

require '../../connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['user_id'],
  $_POST['question_id'],
  $_POST['question'])
) {

  $userId = $_POST['user_id'];
  $questionId = $_POST['question_id'];
  $question = json_decode($_POST['question'], true);
  $choices = $question['choices'];
  $dateNow = date('Y-m-d h:i:s');

  $command = 'UPDATE quiz_questions SET value = ? WHERE id = ?';

  $statement = $connection->prepare($command);
  $statement->bind_param(
    'si',
    $question['question'],
    $questionId
  );
  $statement->execute();

  $command = 'DELETE FROM quiz_question_choices WHERE quiz_question_id = ?';

  $statement = $connection->prepare($command);
  $statement->bind_param('i', $questionId);
  $statement->execute();

  $chcCommand = 'INSERT INTO quiz_question_choices(quiz_question_id, value, correct) VALUES(?, ?, ?)';
  $chcStatement = $connection->prepare($chcCommand);
  $chcStatement->bind_param(
    'isi',
    $questionId,
    $cValue,
    $correct
  );

  foreach ($choices as $chc) {

    $cValue = $chc['value'];
    $correct = $chc['correct'];

    $chcStatement->execute();
  }

  $response = [
    'response' => $statement === false ? 'failed' : 'successful'
  ];
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
