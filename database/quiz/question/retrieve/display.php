<?php

require '../../../connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'GET'
  &&
  isset($_GET['quiz_id'])
) {

  $quizId = $_GET['quiz_id'];
  $questions = [];

  $qstnCommand = 'SELECT id, value FROM quiz_questions WHERE quiz_id = ?';
  $qstnStatement = $connection->prepare($qstnCommand);
  $qstnStatement->bind_param('i', $quizId);
  $qstnStatement->bind_result($qstnId, $qstnValue);

  $chcCommand = 'SELECT value, correct FROM quiz_question_choices WHERE quiz_question_id = ?';
  $chcStatement = $connection->prepare($chcCommand);
  $chcStatement->bind_param('i', $qstnId);
  $chcStatement->bind_result($chcValue, $correct);

  $qstnStatement->execute();

  while ($qstnStatement->fetch()) {

    $questions[] = [
      'id' => $qstnId,
      'value' => htmlspecialchars($qstnValue),
      'answer' => ''
    ];
  }

  for ($i = 0; $i < count($questions); $i++) {

    $qstnId = $questions[$i]['id'];

    $chcStatement->execute();

    while ($chcStatement->fetch()) {

      $questions[$i]['answer'] .= '<br> - ' . htmlspecialchars($chcValue);

      if ($correct) {
        $questions[$i]['answer'] .= ' <span class="fa fa-check text-main-green"></span>';
      }
    }
  }

  $response = [
    'response' => $questions === [] ? 'nothing' : 'found',
    'questions' => $questions
  ];
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
