<?php

require '../connection.php';
require '../ischool.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['user_id'],
  $_POST['classroom_id'],
  $_POST['assignment_id'])
) {

  $userId = $_POST['user_id'];
  $classroomId = $_POST['classroom_id'];
  $assignmentId = $_POST['assignment_id'];
  $dateNow = date('Y-m-d H:i:s');

  $command = 'SELECT file, date_time_published FROM assignments WHERE id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param('i', $assignmentId);
  $statement->execute();
  $statement->bind_result(
    $file,
    $dateTimePublished
  );

  if ($statement->fetch()) {

    if ($file !== null) {

      unlink('../../' . $file);
    }
  }

  $statement->close();

  Ischool::smoothDelete(
    $connection,
    'assignments',
    $assignmentId
  );

  $command = 'DELETE FROM assignment_submissions WHERE assignment_id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param('i', $assignmentId);
  $statement->execute();
  $statement->close();

  Ischool::activityLog(
    $connection,
    $userId,
    $classroomId,
    'ass_delete',
    $dateNow
  );

  if ($dateTimePublished !== null) {

    Ischool::notifStudents(
      $connection,
      $userId,
      $classroomId,
      'delete_assignment',
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
