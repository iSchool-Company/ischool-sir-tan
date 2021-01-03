<?php

require '../../connection.php';
require '../../ischool.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'GET'
  &&
  isset($_GET['user_id'],
  $_GET['classroom_id'])
) {

  $userId = $_GET['user_id'];
  $classroomId = $_GET['classroom_id'];

  $command = "SELECT CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name), u.profile_picture, u.username, cr.class, cr.subject, cr.date_end, cr.description, (SELECT 1 FROM classrooms_reviews WHERE classroom_id = ? AND student_id = ?) AS has_review FROM classrooms AS cr LEFT JOIN users AS u ON cr.teacher_id = u.id WHERE cr.id = ?";

  $statement = $connection->prepare($command);
  $statement->bind_param(
    'iii',
    $classroomId,
    $userId,
    $classroomId
  );
  $statement->execute();
  $statement->store_result();
  $statement->bind_result(
    $teacherName,
    $teacherImage,
    $teacherUsername,
    $className,
    $subjectName,
    $dateEnd,
    $description,
    $hasReview
  );

  if ($statement->fetch()) {

    $data['teacher_name'] = $teacherName;
    $data['teacher_image'] = $teacherImage;
    $data['teacher_username'] = $teacherUsername;
    $data['class_name'] = $className;
    $data['subject_name'] = $subjectName;
    $data['date_end'] = date('M d, Y', strtotime($dateEnd));
    $data['date_end_modal'] = date('m/d/Y', strtotime($dateEnd));
    $data['description'] = $description;
    $data['has_review'] = $hasReview;

    $response = [
      'response' => 'found',
      'info' => $data
    ];
  } else {

    $response = [
      'response' => 'nothing'
    ];
  }

  Ischool::updateNotifSeen(
    $connection,
    $userId,
    $classroomId,
    'overview'
  );
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
