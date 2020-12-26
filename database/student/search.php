<?php

require '../connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'GET'
  &&
  isset($_GET['classroom_id'],
  $_GET['search'])
) {

  $classroomId = $_GET['classroom_id'];
  $search = trim($_GET['search']);
  $searchFullText = '+' . str_replace(' ', ' +', $search) . '*';
  $username = trim($_GET['search']) . '%';
  $students = [];

  $command = "SELECT u.id, CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name), u.username, u.profile_picture FROM users AS u LEFT JOIN classroom_student_designation AS csd ON u.id = csd.student_id AND csd.classroom_id = ? WHERE csd.id IS NULL AND u.type = 'Student' AND (MATCH(u.first_name, u.middle_name, u.last_name) AGAINST('$searchFullText' IN BOOLEAN MODE) OR username LIKE ?) ORDER BY u.first_name,u.middle_name,u.last_name LIMIT 5";

  $statement = $connection->prepare($command);
  $statement->bind_param('is', $classroomId, $username);
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
    $data['image'] = $profilePicture;

    $students[] = $data;
  }

  $response = [
    'response' => $students == null ? 'nothing' : 'found',
    'students' => $students
  ];
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
