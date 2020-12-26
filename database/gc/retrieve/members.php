<?php

require '../../connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'GET'
  &&
  isset($_GET['gc_id'])
) {

  $gcId = $_GET['gc_id'];
  $members = [];

  $command = "SELECT u.id, CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name), u.profile_picture FROM group_chat_members AS gcm LEFT JOIN users AS u ON gcm.user_id = u.id WHERE group_chat_id = ? ORDER BY u.first_name,u.last_name";
  $statement = $connection->prepare($command);
  $statement->bind_param('i', $gcId);
  $statement->execute();
  $statement->bind_result(
    $id,
    $name,
    $image
  );

  while ($statement->fetch()) {

    $data['id'] = $id;
    $data['name'] = $name;
    $data['image'] = $image;

    $members[] = $data;
  }

  $response = [
    'response' => $members === [] ? 'nothing' : 'found',
    'members' => $members
  ];
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
