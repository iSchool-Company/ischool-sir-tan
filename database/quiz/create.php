<?php

require '../connection.php';
require '../ischool.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['user_id'],
  $_POST['classroom_id'],
  $_POST['title'],
  $_POST['description'],
  $_POST['type'],
  $_POST['duration'],
  $_POST['publish_now'],
  $_POST['quiz_all'])
) {

  $userId = $_POST['user_id'];
  $classroomId = $_POST['classroom_id'];
  $title = $_POST['title'];
  $description = $_POST['description'];
  $type = $_POST['type'];
  $duration = $_POST['duration'];
  $publishNow = $_POST['publish_now'];
  $quizAll = $_POST['quiz_all'] === 'true' ? true : false;
  $dateNow = date('Y-m-d h:i:s');

  if ($publishNow === 'true') {

    $dueDate = $_POST['due_date'];
    $dueTime = $_POST['due_time'];
    $dateTimePublished = $dateNow;
  } else {

    $dueDate = null;
    $dueTime = null;
    $dateTimePublished = null;
  }

  $command = 'INSERT INTO quizzes(classroom_id, title, description, type_id, duration_id, date_time_created, due_date, due_time, date_time_published, quiz_all) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
  $statement = $connection->prepare($command);
  $statement->bind_param(
    'issiissssi',
    $classroomId,
    $title,
    $description,
    $type,
    $duration,
    $dateNow,
    $dueDate,
    $dueTime,
    $dateTimePublished,
    $quizAll
  );
  $statement->execute();
  $statement->close();

  $quizId = mysqli_insert_id($connection);

  if (isset($_POST['questions'])) {

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

    $qstnStatement->close();
    $chcStatement->close();
  }

  if ($publishNow === 'true') {

    if ($quizAll) {

      $command = 'INSERT INTO quiz_submissions(quiz_id, student_id, due_date, due_time, date_time_assigned) SELECT ?, student_id, ?, ?, ? FROM classroom_student_designation WHERE classroom_id = ? AND pending = 0';
      $statement = $connection->prepare($command);
      $statement->bind_param(
        'isssi',
        $quizId,
        $dueDate,
        $dueTime,
        $dateTimePublished,
        $classroomId
      );
      $statement->execute();
      $statement->close();

      Ischool::notifStudents(
        $connection,
        $userId,
        $classroomId,
        'new_quiz',
        $quizId,
        $dateNow
      );
    } else {

      $students = json_decode($_POST['students']);

      foreach ($students as $student) {

        $command = 'INSERT INTO quiz_submissions(quiz_id, student_id, due_date, due_time, date_time_assigned) VALUES(?, ?, ?, ?, ?)';
        $statement = $connection->prepare($command);
        $statement->bind_param(
          'iisss',
          $quizId,
          $student,
          $dueDate,
          $dueTime,
          $dateTimePublished
        );
        $statement->execute();
        $statement->close();

        Ischool::notifStudent(
          $connection,
          $userId,
          $student,
          $classroomId,
          'new_quiz',
          $quizId,
          $dateNow
        );
      }
    }

    Ischool::activityLog(
      $connection,
      $userId,
      $classroomId,
      'quiz_publish',
      $dateNow
    );
  } else {

    if ($quizAll) {

      $command = 'INSERT INTO quiz_submissions(quiz_id, student_id) SELECT ?, student_id FROM classroom_student_designation WHERE classroom_id = ? AND pending = 0';
      $statement = $connection->prepare($command);
      $statement->bind_param(
        'ii',
        $quizId,
        $classroomId
      );
      $statement->execute();
      $statement->close();
    } else {

      $students = json_decode($_POST['students']);

      foreach ($students as $student) {

        $command = 'INSERT INTO quiz_submissions(quiz_id, student_id) VALUES(?, ?)';
        $statement = $connection->prepare($command);
        $statement->bind_param(
          'ii',
          $quizId,
          $student
        );
        $statement->execute();
        $statement->close();
      }
    }

    Ischool::activityLog(
      $connection,
      $userId,
      $classroomId,
      'quiz_create',
      $dateNow
    );
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
