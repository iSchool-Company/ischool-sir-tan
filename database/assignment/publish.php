<?php

require '../connection.php';
require '../ischool.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['user_id'],
  $_POST['classroom_id'],
  $_POST['assignment_id'],
  $_POST['publish_now'])
) {

  $userId = $_POST['user_id'];
  $classroomId = $_POST['classroom_id'];
  $assignmentId = $_POST['assignment_id'];
  $publish = $_POST['publish_now'];
  $default = null;
  $dateNow = date('Y-m-d H:i:s');

  if ($publish === 'true') {

    $dueDate = $_POST['due_date'];
    $dueTime = $_POST['due_time'];
    $dateTimePublished = $dateNow;
  } else {

    $dueDate = null;
    $dueTime = null;
    $dateTimePublished = null;
  }

  $command = 'UPDATE assignments SET due_date = ?, due_time = ?, date_time_published = ?, version = version + 1 WHERE id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param(
    'sssi',
    $dueDate,
    $dueTime,
    $dateTimePublished,
    $assignmentId
  );
  $statement->execute();
  $statement->close();

  $command = 'UPDATE assignment_submissions SET due_date = ?, due_time = ?, date_time_assigned = ?, file = ?, grade = ?, date_time_submitted = ? WHERE assignment_id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param(
    'sssisss',
    $dueDate,
    $dueTime,
    $dateTimePublished,
    $default,
    $default,
    $default,
    $assignmentId
  );
  $statement->execute();
  $statement->close();

  if ($publish === 'true') {

    Ischool::activityLog(
      $connection,
      $userId,
      $classroomId,
      'ass_publish',
      $dateNow
    );

    Ischool::notifStudents(
      $connection,
      $userId,
      $classroomId,
      'new_assignment',
      $assignmentId,
      $dateNow
    );
  } else {

    Ischool::activityLog(
      $connection,
      $userId,
      $classroomId,
      'ass_unpublish',
      $dateNow
    );

    Ischool::notifStudents(
      $connection,
      $userId,
      $classroomId,
      'cancel_assignment',
      $assignmentId,
      $dateNow
    );

    Ischool::deleteNotif2(
      $connection,
      'submit_assignment',
      $assignmentId
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
