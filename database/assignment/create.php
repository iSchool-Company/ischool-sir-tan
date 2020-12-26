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
  $_POST['publish_now'])
) {

  $userId = $_POST['user_id'];
  $classroomId = $_POST['classroom_id'];
  $title = $_POST['title'];
  $description = $_POST['description'];
  $publishNow = $_POST['publish_now'];
  $dateNow = date('Y-m-d H:i:s');

  if ($publishNow === 'true') {

    $dueDate = $_POST['due_date'];
    $dueTime = $_POST['due_time'];
    $dateTimePublished = $dateNow;
  } else {

    $dueDate = null;
    $dueTime = null;
    $dateTimePublished = null;
  }

  if (isset($_FILES['file'])) {

    $file = $_FILES['file'];
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $target = 'files/assignments_post/';
    $target .= $classroomId . '_' . str_replace(' ', '_', $title) . '.' . $extension;
    $fileName = str_replace(' ', '_', basename($file['name']));

    move_uploaded_file($file["tmp_name"], '../../' . $target);
  } else {

    $target = null;
    $fileName = null;
  }

  $command = 'INSERT INTO assignments(classroom_id, file, file_name, title, description, due_date, due_time, date_time_created, date_time_published) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)';
  $statement = $connection->prepare($command);
  $statement->bind_param(
    'issssssss',
    $classroomId,
    $target,
    $fileName,
    $title,
    $description,
    $dueDate,
    $dueTime,
    $dateNow,
    $dateTimePublished
  );
  $statement->execute();
  $statement->close();

  $assignmentId = mysqli_insert_id($connection);

  $command = 'INSERT INTO assignment_submissions(assignment_id, student_id, due_date, due_time, date_time_assigned) SELECT ?, student_id, ?, ?, ? FROM classroom_student_designation WHERE classroom_id = ? AND pending = 0';
  $statement = $connection->prepare($command);
  $statement->bind_param(
    'isssi',
    $assignmentId,
    $dueDate,
    $dueTime,
    $dateTimePublished,
    $classroomId
  );
  $statement->execute();
  $statement->close();

  if ($publishNow === 'true') {

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
      'ass_create',
      $dateNow
    );
  }

  $response = [
    'response' => $statement == false ? 'failed' : 'successful'
  ];
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
