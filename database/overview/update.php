<?php

require '../connection.php';
require '../ischool.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['user_id'],
  $_POST['classroom_id'],
  $_POST['part'],
  $_POST['value'])
) {

  $userId = $_POST['user_id'];
  $classroomId = $_POST['classroom_id'];
  $part = $_POST['part'];

  $dateNow = date('Y-m-d H:i:s');

  switch ($part) {

    case 'class':

      $class = strtoupper($_POST['value']);

      $command = 'UPDATE classrooms SET class = ? WHERE id = ?';
      $statement = $connection->prepare($command);
      $statement->bind_param(
        'si',
        $class,
        $classroomId
      );
      $statement->execute();
      $statement->close();

      Ischool::activityLog(
        $connection,
        $userId,
        $classroomId,
        'cr_edit_name',
        $dateNow
      );

      Ischool::notifStudents(
        $connection,
        $userId,
        $classroomId,
        'cr_change_name',
        0,
        $dateNow
      );

      break;

    case 'subject':

      $subject = strtoupper($_POST['value']);

      $command = 'UPDATE classrooms SET subject = ? WHERE id = ?';
      $statement = $connection->prepare($command);
      $statement->bind_param(
        'si',
        $subject,
        $classroomId
      );
      $statement->execute();
      $statement->close();

      Ischool::activityLog(
        $connection,
        $userId,
        $classroomId,
        'cr_edit_name',
        $dateNow
      );

      Ischool::notifStudents(
        $connection,
        $userId,
        $classroomId,
        'cr_change_name',
        0,
        $dateNow
      );

      break;

    case 'end_date':

      $endDate = date('Y-m-d H:i:s', strtotime($_POST['value']));

      $command = 'UPDATE classrooms SET date_end = ? WHERE id = ?';
      $statement = $connection->prepare($command);
      $statement->bind_param(
        'si',
        $endDate,
        $classroomId
      );
      $statement->execute();
      $statement->close();

      Ischool::activityLog(
        $connection,
        $userId,
        $classroomId,
        'cr_edit_date',
        $dateNow
      );

      Ischool::notifStudents(
        $connection,
        $userId,
        $classroomId,
        'cr_change_date',
        0,
        $dateNow
      );

      break;

    case 'description':

      $description = $_POST['value'];

      $command = 'UPDATE classrooms SET description = ? WHERE id = ?';
      $statement = $connection->prepare($command);
      $statement->bind_param(
        'si',
        $description,
        $classroomId
      );
      $statement->execute();
      $statement->close();

      Ischool::activityLog(
        $connection,
        $userId,
        $classroomId,
        'cr_edit_desc',
        $dateNow
      );

      Ischool::notifStudents(
        $connection,
        $userId,
        $classroomId,
        'cr_change_desc',
        0,
        $dateNow
      );

      break;
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
