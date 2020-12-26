<?php

require '../connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'GET'
  &&
  isset($_GET['user_type'],
  $_GET['user_id'],
  $_GET['search'])
) {

  $userType = $_GET['user_type'];
  $userId = $_GET['user_id'];
  $search = trim($_GET['search']);
  $searchFullText = '+' . str_replace(' ', ' +', $search) . '*';

  if ($userType === 'Student') {

    $command = 'SELECT classroom_id FROM classroom_student_designation WHERE student_id = ? AND pending = 0';

    $statement = $connection->prepare($command);
    $statement->bind_param('i', $userId);
    $statement->execute();
    $statement->store_result();
    $statement->bind_result($classroomId);

    if ($statement->num_rows > 0) {

      while ($statement->fetch()) {
        $classroomIdsArray[] = $classroomId;
      }

      $classroomIds = implode(', ', $classroomIdsArray);

      $statement->close();

      $command = "SELECT u.id, CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name), u.username, u.profile_picture FROM classroom_student_designation AS csd LEFT JOIN users AS u ON csd.student_id = u.id WHERE csd.classroom_id IN($classroomIds) AND MATCH(u.first_name, u.middle_name, u.last_name) AGAINST('$searchFullText' IN BOOLEAN MODE) AND csd.student_id != ? AND csd.pending = 0 UNION SELECT u.id, CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name), u.username, u.profile_picture FROM classrooms AS cr LEFT JOIN users AS u ON cr.teacher_id = u.id WHERE cr.id IN($classroomIds) AND MATCH(u.first_name, u.middle_name, u.last_name) AGAINST('$searchFullText' IN BOOLEAN MODE)";

      $statement = $connection->prepare($command);
      $statement->bind_param('i', $userId);
      $statement->execute();
      $statement->store_result();
      $statement->bind_result(
        $id,
        $name,
        $username,
        $profilePicture
      );

      if ($statement->num_rows > 0) {

        while ($statement->fetch()) {

          $data['id'] = $id;
          $data['name'] = $name;
          $data['username'] = $username;
          $data['image'] = $profilePicture;

          $recipients[] = $data;
        }

        $statement->close();

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
        'response' => 'nothing'
      ];
    }
  } else if ($userType === 'Teacher') {

    $command = "SELECT u.id, CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name), u.username, u.profile_picture FROM classrooms AS cr INNER JOIN classroom_student_designation as csd ON cr.id = csd.classroom_id LEFT JOIN users AS u ON csd.student_id = u.id WHERE cr.teacher_id = ? AND MATCH(u.first_name, u.middle_name, u.last_name) AGAINST('$searchFullText' IN BOOLEAN MODE) GROUP BY u.id";

    $statement = $connection->prepare($command);
    $statement->bind_param('i', $userId);
    $statement->execute();
    $statement->store_result();
    $statement->bind_result(
      $id,
      $name,
      $username,
      $profilePicture
    );

    if ($statement->num_rows > 0) {

      while ($statement->fetch()) {

        $data['id'] = $id;
        $data['name'] = $name;
        $data['username'] = $username;
        $data['image'] = $profilePicture;

        $recipients[] = $data;
      }

      $statement->close();

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
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
