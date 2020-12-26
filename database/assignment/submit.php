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

  if (isset($_FILES['file'])) {

    $file = $_FILES['file'];
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $target = 'files/assignments_submit/';
    $target .= $classroomId . '_' . $assignmentId . '_' . $userId . '.' . $extension;
    $fileName = str_replace(' ', '_', basename($file['name']));

    move_uploaded_file($file["tmp_name"], '../../' . $target);

    $command = 'UPDATE assignment_submissions SET file = ?, file_name = ?, date_time_submitted = ? WHERE assignment_id = ? AND student_id = ?';
    $statement = $connection->prepare($command);
    $statement->bind_param(
      'sssii',
      $target,
      $fileName,
      $dateNow,
      $assignmentId,
      $userId
    );
    $statement->execute();
    $statement->close();
  }

  Ischool::activityLog(
    $connection,
    $userId,
    $classroomId,
    'ass_submit',
    $dateNow
  );

  Ischool::notifTeacher(
    $connection,
    $userId,
    $classroomId,
    'submit_assignment',
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
