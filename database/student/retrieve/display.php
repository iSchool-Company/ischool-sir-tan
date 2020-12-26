<?php

require '../../connection.php';
require '../../ischool.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'GET'
  && isset($_GET['classroom_id'],
  $_GET['user_id'],
  $_GET['search'])
) {

  $classroomId = $_GET['classroom_id'];
  $userId = $_GET['user_id'];
  $search = trim($_GET['search']);
  $searchFullText = '+' . str_replace(' ', ' +', $search) . '*';
  $username = trim($_GET['search']) . '%';
  $students = [];

  $command = "SELECT u.id, CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name), u.username, u.profile_picture FROM classroom_student_designation AS csd LEFT JOIN users AS u ON csd.student_id = u.id WHERE csd.classroom_id = ? AND csd.pending = 0 AND u.id != ?" . ($search === '' ? '' : " AND (MATCH(u.first_name, u.middle_name, u.last_name) AGAINST('" . $searchFullText . "' IN BOOLEAN MODE) OR u.username LIKE ?)") . " ORDER BY u.last_name ASC";

  $statement = $connection->prepare($command);

  if ($search === '') {
    $statement->bind_param('ii', $classroomId, $userId);
  } else {
    $statement->bind_param('iis', $classroomId, $userId, $username);
  }

  $statement->execute();
  $statement->store_result();
  $statement->bind_result(
    $id,
    $name,
    $username,
    $profilePicture
  );

  while ($statement->fetch()) {

    $data['id'] = $id;
    $data['name'] = $name;
    $data['username'] = $username;
    $data['profile_picture'] = $profilePicture;

    $students[] = $data;
  }

  Ischool::updateNotifSeen(
    $connection,
    $userId,
    $classroomId,
    'students'
  );

  $response = [
    'response' => $students === [] ? 'nothing' : 'found',
    'students' => $students
  ];
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
