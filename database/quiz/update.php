<?php

require '../connection.php';
require '../ischool.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['user_id'],
  $_POST['classroom_id'],
  $_POST['quiz_id'],
  $_POST['title'],
  $_POST['description'],
  $_POST['type'],
  $_POST['duration'],
  $_POST['changed'])
) {

  $userId = $_POST['user_id'];
  $classroomId = $_POST['classroom_id'];
  $quizId = $_POST['quiz_id'];
  $title = $_POST['title'];
  $description = $_POST['description'];
  $type = $_POST['type'];
  $duration = $_POST['duration'];
  $changed = $_POST['changed'];
  $dateNow = date('Y-m-d H:i:s');
  $questions = [];

  $command = 'UPDATE quizzes SET title = ?, description = ?, type_id = ?, duration_id = ?, version = version + 1 WHERE id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param(
    'ssssi',
    $title,
    $description,
    $type,
    $duration,
    $quizId
  );
  $statement->execute();
  $statement->close();

  if ($changed === 'true') {

    $command = 'SELECT id FROM quiz_questions WHERE quiz_id = ?';
    $statement = $connection->prepare($command);
    $statement->bind_param('i', $quizId);
    $statement->execute();
    $statement->bind_result($id);

    while ($statement->fetch()) {
      $questions[] = $id;
    }

    $statement->close();

    $command = 'DELETE FROM quiz_questions WHERE quiz_id = ?';
    $statement = $connection->prepare($command);
    $statement->bind_param('i', $quizId);
    $statement->execute();
    $statement->close();

    $command = 'DELETE FROM quiz_question_choices WHERE quiz_question_id = ?';
    $statement = $connection->prepare($command);
    $statement->bind_param('i', $qstn);

    foreach ($questions as $qstn) {

      $statement->execute();
    }

    $statement->close();
  }

  Ischool::activityLog(
    $connection,
    $userId,
    $classroomId,
    'quiz_edit',
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
