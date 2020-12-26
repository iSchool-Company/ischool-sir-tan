<?php

require '../connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'GET'
  &&
  isset($_GET['user_id'],
  $_GET['search'])
) {

  $userId = $_GET['user_id'];
  $search = trim($_GET['search']);
  $searchFullText = '+' . str_replace(' ', ' +', $search) . '*';
  $classrooms = [];

  $command = "SELECT cr.id, CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name), u.profile_picture, cr.class, cr.subject FROM classrooms AS cr LEFT JOIN users AS u ON cr.teacher_id = u.id LEFT JOIN classroom_student_designation AS csd ON cr.id = csd.classroom_id AND csd.student_id = ? WHERE csd.id IS NULL AND cr.is_deleted = 0 AND cr.date_end + 1 > now() AND (MATCH(u.first_name, u.middle_name, u.last_name) AGAINST('$searchFullText' IN BOOLEAN MODE) OR MATCH(cr.class, cr.subject) AGAINST('$searchFullText' IN BOOLEAN MODE)) LIMIT 5";

  $statement = $connection->prepare($command);
  $statement->bind_param('i', $userId);
  $statement->execute();
  $statement->store_result();
  $statement->bind_result(
    $classroomId,
    $teacherName,
    $teacherImage,
    $className,
    $subjectName
  );

  while ($statement->fetch()) {

    $data['classroom_id'] = $classroomId;
    $data['teacher_name'] = $teacherName;
    $data['teacher_image'] = $teacherImage;
    $data['class_name'] = $className;
    $data['subject_name'] = $subjectName;

    $classrooms[] = $data;
  }

  $response = [
    'response' => $classrooms == null ? 'nothing' : 'found',
    'classrooms' => $classrooms
  ];
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
