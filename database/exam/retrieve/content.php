<?php

require '../../connection.php';
require '../../ischool.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['classroom_id'],
  $_POST['user_id'],
  $_POST['quiz_id'])
) {

  $classroomId = $_POST['classroom_id'];
  $userId = $_POST['user_id'];
  $quizId = $_POST['quiz_id'];
  $dateNow = date('Y-m-d H:i:s');
  $info = [];
  $questions = [];

  $command = 'SELECT q.title, qt.value, qd.seconds FROM quizzes AS q LEFT JOIN quiz_types AS qt ON q.type_id = qt.id LEFT JOIN quiz_durations AS qd ON q.duration_id = qd.id WHERE q.id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param('i', $quizId);
  $statement->bind_result(
    $title,
    $type,
    $duration
  );

  $statement->execute();
  $statement->fetch();
  $statement->close();

  $info['id'] = $quizId;
  $info['title'] = $title;
  $info['type'] = $type;
  $info['duration'] = $duration;

  $qstnCommand = 'SELECT id, value FROM quiz_questions WHERE quiz_id = ? ORDER BY RAND()';
  $qstnStatement = $connection->prepare($qstnCommand);
  $qstnStatement->bind_param('i', $quizId);
  $qstnStatement->bind_result(
    $qstnId,
    $qstnValue
  );

  $chcCommand = 'SELECT value, correct FROM quiz_question_choices WHERE quiz_question_id = ? ORDER BY RAND()';
  $chcStatement = $connection->prepare($chcCommand);
  $chcStatement->bind_param('i', $qstnId);
  $chcStatement->bind_result(
    $chcValue,
    $correct
  );

  $qstnStatement->execute();

  while ($qstnStatement->fetch()) {

    $questions[] = [
      'id' => $qstnId,
      'value' => $qstnValue,
      'answer' => []
    ];
  }

  for ($i = 0; $i < count($questions); $i++) {

    $qstnId = $questions[$i]['id'];

    $chcStatement->execute();

    while ($chcStatement->fetch()) {

      $data['value'] = $chcValue;
      $data['correct'] = $correct;

      $questions[$i]['answer'][] = $data;
    }
  }

  $info['questions'] = $questions;

  $command = 'UPDATE quiz_submissions SET score = 0, date_time_took = ?, date_time_done = ? WHERE quiz_id = ? AND student_id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param(
    'ssii',
    $dateNow,
    $dateNow,
    $quizId,
    $userId
  );
  $statement->execute();
  $statement->close();

  Ischool::activityLog(
    $connection,
    $userId,
    $classroomId,
    'quiz_take',
    $dateNow
  );

  Ischool::notifTeacher(
    $connection,
    $userId,
    $classroomId,
    'take_quiz',
    $quizId,
    $dateNow
  );

  $response = [
    'response' => $info === [] ? 'nothing' : 'found',
    'info' => $info
  ];
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
