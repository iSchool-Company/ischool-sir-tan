<?php

require '../connection.php';
require '../ischool.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['user_id'],
  $_POST['pin_id'],
  $_POST['classroom_id'],
  $_POST['assignment_id'])
) {

  $userId = $_POST['user_id'];
  $pinId = $_POST['pin_id'];
  $classroomId = $_POST['classroom_id'];
  $assignmentId = $_POST['assignment_id'];
  $dateNow = date('Y-m-d H:i:s');

  $command = 'SELECT file, file_name, title, description FROM assignments WHERE id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param('i', $assignmentId);
  $statement->execute();
  $statement->bind_result(
    $file,
    $fileName,
    $title,
    $description
  );

  if ($statement->fetch()) {

    if ($file !== null) {

      $pinFile = 'files/assignments_post/' . $pinId . '_' . $title . '.' . pathinfo($fileName, PATHINFO_EXTENSION);
      $copySuccess = copy('../../' . $file, '../../' . $pinFile);
    }

    $statement->close();

    $command = 'INSERT INTO assignments(classroom_id, file, file_name, title, description, date_time_created) VALUES(?, ?, ?, ?, ?, ?)';
    $statement = $connection->prepare($command);
    $statement->bind_param(
      'isssss',
      $pinId,
      $pinFile,
      $fileName,
      $title,
      $description,
      $dateNow
    );
    $statement->execute();

    $assId = $connection->insert_id;

    $command = 'INSERT INTO assignment_submissions(assignment_id, student_id) SELECT ?, student_id FROM classroom_student_designation WHERE classroom_id = ? AND pending = 0';

    $statement = $connection->prepare($command);
    $statement->bind_param(
      'ii',
      $assId,
      $pinId
    );
    $statement->execute();
    $statement->close();
  }

  Ischool::activityLog(
    $connection,
    $userId,
    $classroomId,
    'ass_pin',
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
