<?php

require '../connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'GET'
  &&
  isset($_GET['user_id'],
  $_GET['search'],
  $_GET['member_classrooms'],
  $_GET['member_students'])
) {

  $userId = $_GET['user_id'];
  $search = trim($_GET['search']);
  $searchFullText = '+' . str_replace(' ', ' +', $search) . '*';
  $memberClassrooms = $_GET['member_classrooms'];
  $memberStudents = $_GET['member_students'];

  $command = "SELECT 'cr', id, CONCAT(class, ' - ', subject), '', '' FROM classrooms WHERE teacher_id = ? AND MATCH(class, subject) AGAINST('$searchFullText' IN BOOLEAN MODE) AND id NOT IN($memberClassrooms) UNION SELECT 'std', u.id, CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name), u.username, u.profile_picture FROM classrooms AS cr INNER JOIN classroom_student_designation as csd ON cr.id = csd.classroom_id LEFT JOIN users AS u ON csd.student_id = u.id WHERE cr.teacher_id = ? AND MATCH(u.first_name, u.middle_name, u.last_name) AGAINST('$searchFullText' IN BOOLEAN MODE) AND u.id NOT IN($memberStudents) GROUP BY u.id";

  $statement = $connection->prepare($command);
  $statement->bind_param(
    'ii',
    $userId,
    $userId
  );
  $statement->execute();
  $statement->store_result();
  $statement->bind_result(
    $type,
    $id,
    $name,
    $username,
    $profilePicture
  );

  if ($statement->num_rows > 0) {

    while ($statement->fetch()) {

      $data['type'] = $type;
      $data['id'] = $id;
      $data['name'] = $name;

      if ($type === 'std') {
        $data['username'] = $username;
        $data['image'] = $profilePicture;
      }

      $recipients[] = $data;
    }

    $statement->close();

    for ($i = 0; $i < count($recipients); $i++) {

      if ($recipients[$i]['type'] === 'cr') {

        $recipients[$i]['students'] = [];

        $command = "SELECT u.id, CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name), u.profile_picture FROM classrooms AS cr INNER JOIN classroom_student_designation as csd ON cr.id = csd.classroom_id LEFT JOIN users AS u ON csd.student_id = u.id WHERE cr.id = ? ORDER BY u.first_name ASC";
        $statement = $connection->prepare($command);
        $statement->bind_param('i', $recipients[$i]['id']);
        $statement->execute();
        $statement->bind_result(
          $id,
          $name,
          $profilePicture
        );

        while ($statement->fetch()) {

          $data = [];

          $data['id'] = $id;
          $data['name'] = $name;
          $data['image'] = $profilePicture;

          $recipients[$i]['students'][] = $data;
        }
      }
    }

    $response = [
      'response' => 'found',
      'recipients' => $recipients
    ];
  } else {

    $response = [
      'response' => 'nothing'
    ];
  }
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
