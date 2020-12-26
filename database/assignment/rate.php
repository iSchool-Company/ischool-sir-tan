<?php

require '../connection.php';
require '../ischool.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['user_id'],
  $_POST['classroom_id'],
  $_POST['submission_id'],
  $_POST['grade'])
) {

  $userId = $_POST['user_id'];
  $classroomId = $_POST['classroom_id'];
  $submissionId = $_POST['submission_id'];
  $grade = $_POST['grade'];
  $dateNow = date('Y-m-d H:i:s');

  $command = 'UPDATE assignment_submissions SET grade = ? WHERE id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param(
    'ii',
    $grade,
    $submissionId
  );
  $statement->execute();
  $statement->close();

  $command = 'SELECT assignment_id, student_id FROM assignment_submissions WHERE id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param('i', $submissionId);
  $statement->execute();
  $statement->bind_result(
    $assignmentId,
    $stdId
  );
  $statement->fetch();
  $statement->close();

  Ischool::activityLog(
    $connection,
    $userId,
    $classroomId,
    'ass_rate',
    $dateNow
  );

  Ischool::notifStudent(
    $connection,
    $userId,
    $stdId,
    $classroomId,
    'rate_assignment',
    $assignmentId,
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
