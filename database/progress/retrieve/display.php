<?php

require '../../connection.php';
require '../../utilities.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'GET'
  &&
  isset($_GET['user_id'],
  $_GET['classroom_id'])
) {

  $userId = $_GET['user_id'];
  $classroomId = $_GET['classroom_id'];
  $records = [];

  $command = 'SELECT "ass", ass.title, asub.date_time_submitted, asub.grade, 0 FROM assignments AS ass INNER JOIN assignment_submissions AS asub ON ass.id = asub.assignment_id WHERE asub.student_id = ? AND ass.classroom_id = ? AND asub.grade IS NOT NULL UNION SELECT "qz", qz.title, qsub.date_time_assigned, qsub.score, (SELECT COUNT(*) FROM quiz_questions AS qq WHERE qq.quiz_id = qz.id) FROM quizzes AS qz INNER JOIN quiz_submissions AS qsub ON qz.id = qsub.quiz_id WHERE qsub.student_id = ? AND qz.classroom_id = ? AND qsub.score IS NOT NULL';
  $statement = $connection->prepare($command);
  $statement->bind_param(
    'iiii',
    $userId,
    $classroomId,
    $userId,
    $classroomId
  );
  $statement->execute();
  $statement->bind_result(
    $type,
    $title,
    $dateTime,
    $grade,
    $overall
  );

  if ($statement->fetch()) {

    if ($type === 'ass') {

      $data['type'] = $type;
      $data['title'] = $title;
      $data['date_time'] = $dateTime;
      $data['grade'] = $grade . '%';

      if ($grade >= 75) {
        $data['remarks'] = 'Passed';
      } else {
        $data['remarks'] = 'Failed';
      }
    } else {

      $data['type'] = $type;
      $data['title'] = $title;
      $data['date_time'] = $dateTime;
      $data['grade'] = $grade . '/' . $overall;

      if ($grade / $overall >= .75) {
        $data['remarks'] = 'Passed';
      } else {
        $data['remarks'] = 'Failed';
      }
    }

    $records[] = $data;
  }

  $response = [
    'response' => $records === [] ? 'nothing' : 'found',
    'records' => $records
  ];
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
