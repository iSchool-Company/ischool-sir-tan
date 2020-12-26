<?php

require '../../connection.php';
require '../../ischool.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['user_id'],
  $_POST['classroom_id'],
  $_POST['quiz_id'],
  $_POST['questions'])
) {

  $userId = $_POST['user_id'];
  $classroomId = $_POST['classroom_id'];
  $quizId = $_POST['quiz_id'];
  $questions = json_decode($_POST['questions'], true);
  $dateNow = date('Y-m-d h:i:s');

  $questions = json_decode($_POST['questions'], true);

  $qstnCommand = 'INSERT INTO quiz_questions(quiz_id, value) VALUES(?, ?)';
  $qstnStatement = $connection->prepare($qstnCommand);
  $qstnStatement->bind_param(
    'is',
    $quizId,
    $qValue
  );

  $chcCommand = 'INSERT INTO quiz_question_choices(quiz_question_id, value, correct) VALUES(?, ?, ?)';
  $chcStatement = $connection->prepare($chcCommand);
  $chcStatement->bind_param(
    'isi',
    $qstnId,
    $cValue,
    $correct
  );

  foreach ($questions as $qstn) {

    $qValue = $qstn['question'];

    $qstnStatement->execute();

    $qstnId = mysqli_insert_id($connection);

    foreach ($qstn['choices'] as $chc) {

      $cValue = $chc['value'];
      $correct = $chc['correct'];

      $chcStatement->execute();
    }
  }

  $response = [
    'response' => $chcStatement === false ? 'failed' : 'successful'
  ];
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
