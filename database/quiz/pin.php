<?php

require '../connection.php';
require '../ischool.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['user_id'],
  $_POST['pin_id'],
  $_POST['classroom_id'],
  $_POST['quiz_id'])
) {

  $userId = $_POST['user_id'];
  $pinId = $_POST['pin_id'];
  $classroomId = $_POST['classroom_id'];
  $quizId = $_POST['quiz_id'];
  $dateNow = date('Y-m-d H:i:s');
  $questions = [];

  $command = 'SELECT title, description, type_id, duration_id FROM quizzes WHERE id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param('i', $quizId);
  $statement->execute();
  $statement->bind_result(
    $title,
    $description,
    $typeId,
    $durationId
  );

  if ($statement->fetch()) {

    $statement->close();

    $command = 'INSERT INTO quizzes(classroom_id, title, description, type_id, duration_id, date_time_created) VALUES(?, ?, ?, ?, ?, ?)';
    $statement = $connection->prepare($command);
    $statement->bind_param(
      'issiis',
      $pinId,
      $title,
      $description,
      $typeId,
      $durationId,
      $dateNow
    );
    $statement->execute();

    $newQuizId = mysqli_insert_id($connection);

    $command = 'SELECT id, value FROM quiz_questions WHERE quiz_id = ?';
    $statement = $connection->prepare($command);
    $statement->bind_param('i', $quizId);
    $statement->execute();
    $statement->bind_result(
      $id,
      $value
    );

    while ($statement->fetch()) {

      $data['id'] = $id;
      $data['value'] = $value;

      $questions[] = $data;
    }

    for ($i = 0; $i < count($questions); $i++) {

      $questions[$i]['choices'] = [];

      $command = 'SELECT value, correct FROM quiz_question_choices WHERE quiz_question_id = ?';
      $statement = $connection->prepare($command);
      $statement->bind_param('i', $questions[$i]['id']);
      $statement->execute();
      $statement->bind_result(
        $value,
        $correct
      );

      while ($statement->fetch()) {

        $data['value'] = $value;
        $data['correct'] = $correct;

        $questions[$i]['choices'][] = $data;
      }

      $statement->close();
    }

    $qstnCommand = 'INSERT INTO quiz_questions(quiz_id, value) VALUES(?, ?)';
    $qstnStatement = $connection->prepare($qstnCommand);
    $qstnStatement->bind_param(
      'is',
      $newQuizId,
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

      $qValue = $qstn['value'];

      $qstnStatement->execute();

      $qstnId = mysqli_insert_id($connection);

      foreach ($qstn['choices'] as $chc) {

        $cValue = $chc['value'];
        $correct = $chc['correct'];

        $chcStatement->execute();
      }
    }

    $command = 'INSERT INTO quiz_submissions(quiz_id, student_id) SELECT ?, student_id FROM classroom_student_designation WHERE classroom_id = ? AND pending = 0';

    $statement = $connection->prepare($command);
    $statement->bind_param(
      'ii',
      $newQuizId,
      $pinId
    );
    $statement->execute();
  }

  Ischool::activityLog(
    $connection,
    $userId,
    $classroomId,
    'quiz_pin',
    $dateNow
  );

  $response = [
    'response' => $statement == false ? 'failed' : 'successful'
  ];
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
