<?php

require '../connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'GET'
  &&
  isset($_GET['user_id'],
  $_GET['gc_id'],
  $_GET['search'])
) {

  $userId = $_GET['user_id'];
  $gcId = $_GET['gc_id'];
  $search = trim($_GET['search']);
  $searchFullText = '+' . str_replace(' ', ' +', $search) . '*';

  $command = "SELECT u.id, CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name), u.username, u.profile_picture FROM classrooms AS cr INNER JOIN classroom_student_designation as csd ON cr.id = csd.classroom_id LEFT JOIN users AS u ON csd.student_id = u.id WHERE cr.teacher_id = ? AND u.id NOT IN(SELECT gcm.user_id FROM group_chat_members AS gcm WHERE gcm.group_chat_id = ?) AND MATCH(u.first_name, u.middle_name, u.last_name) AGAINST('$searchFullText' IN BOOLEAN MODE) GROUP BY u.id";

  $statement = $connection->prepare($command);
  $statement->bind_param(
    'ii',
    $userId,
    $gcId
  );
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

echo json_encode($response);
