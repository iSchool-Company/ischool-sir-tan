<?php

session_start();

require '../connection.php';
require '../ischool.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['user_id'],
  $_POST['class_name'],
  $_POST['subject_name'],
  $_POST['description'],
  $_POST['date_end'])
) {

  $userId = $_POST['user_id'];
  $class = strtoupper($_POST['class_name']);
  $subject = strtoupper($_POST['subject_name']);
  $description = $_POST['description'];
  $dateEnd = date('Y-m-d', strtotime($_POST['date_end']));
  $dateNow = date('Y-m-d H:i:s');

  $command = 'INSERT INTO classrooms(teacher_id, class, subject, description, date_time_created, date_end) VALUES(?, ?, ?, ?, ?, ?)';

  $statement = $connection->prepare($command);
  $statement->bind_param(
    'isssss',
    $userId,
    $class,
    $subject,
    $description,
    $dateNow,
    $dateEnd
  );
  $statement->execute();
  $statement->close();

  $classroomId = mysqli_insert_id($connection);

  Ischool::activityLog(
    $connection,
    $userId,
    $classroomId,
    'cr_add',
    $dateNow
  );

  $_SESSION['classroom_id'] = $classroomId;

  $response = [
    'response' => $statement == false ? 'failed' : 'successful'
  ];
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
