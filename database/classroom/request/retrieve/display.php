<?php

require '../../../connection.php';
require '../../../ischool.php';

if ($_SERVER['REQUEST_METHOD'] = 'GET'
  &&
  isset($_GET['method'],
  $_GET['user_id'])
) {

  $method = $_GET['method'];
  $userId = $_GET['user_id'];
  $requests = [];

  switch ($method) {

    case 'newer':

      if (!isset($_GET['ref_id'])) {

        $response = [
          'response' => 'unauthorized'
        ];

        die(json_encode($response));
      }

      $refId = $_GET['ref_id'];
      $command = "SELECT csd.id, cr.id, u.id, CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name), u.profile_picture, u.username, cr.class, cr.subject FROM classrooms AS cr INNER JOIN classroom_student_designation AS csd ON cr.id = csd.classroom_id LEFT JOIN users AS u ON csd.student_id = u.id WHERE cr.teacher_id = ? AND csd.pending = 1 AND cr.is_deleted = 0 AND csd.id > ? ORDER BY csd.id ASC";

      $statement = $connection->prepare($command);
      $statement->bind_param(
        'ii',
        $userId,
        $refId
      );
      $statement->execute();

      break;

    case 'fresh':

      $command = "SELECT csd.id, cr.id, u.id, CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name), u.profile_picture, u.username, cr.class, cr.subject FROM classrooms AS cr INNER JOIN classroom_student_designation AS csd ON cr.id = csd.classroom_id LEFT JOIN users AS u ON csd.student_id = u.id WHERE cr.teacher_id = ? AND csd.pending = 1 AND cr.is_deleted = 0 ORDER BY csd.id DESC LIMIT 5";

      $statement = $connection->prepare($command);
      $statement->bind_param('i', $userId);
      $statement->execute();

      break;

    case 'later':

      if (!isset($_GET['ref_id'])) {

        $response = [
          'response' => 'unauthorized'
        ];

        die(json_encode($response));
      }

      $refId = $_GET['ref_id'];
      $command = "SELECT csd.id, cr.id, u.id, CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name), u.profile_picture, u.username, cr.class, cr.subject FROM classrooms AS cr INNER JOIN classroom_student_designation AS csd ON cr.id = csd.classroom_id LEFT JOIN users AS u ON csd.student_id = u.id WHERE cr.teacher_id = ? AND csd.pending = 1 AND cr.is_deleted = 0 AND csd.id < ? ORDER BY csd.id DESC LIMIT 3";

      $statement = $connection->prepare($command);
      $statement->bind_param(
        'ii',
        $userId,
        $refId
      );
      $statement->execute();

      break;
  }

  $statement->store_result();
  $statement->bind_result(
    $csdId,
    $classroomId,
    $studentId,
    $studentName,
    $studentImage,
    $studentUsername,
    $className,
    $subjectName
  );

  while ($statement->fetch()) {

    $data['csd_id'] = $csdId;
    $data['classroom_id'] = $classroomId;
    $data['student_id'] = $studentId;
    $data['student_name'] = $studentName;
    $data['student_image'] = $studentImage;
    $data['student_username'] = $studentUsername;
    $data['class_name'] = $className;
    $data['subject_name'] = $subjectName;

    $requests[] = $data;
  }

  $statement->close();

  Ischool::updateNotifSeen2(
    $connection,
    $userId,
    'requests'
  );

  $response = [
    'response' => $requests === [] ? 'nothing' : 'found',
    'requests' => $requests
  ];
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
