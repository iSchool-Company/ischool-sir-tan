<?php

require '../connection.php';
require '../ischool.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['user_id'],
  $_FILES['image'])
) {

  $userId = $_POST['user_id'];
  $dateNow = date('Y-m-d H:i:s');

  if (isset($_FILES['image'])) {

    $file = $_FILES['image'];
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $target = 'pictures/profile_pictures/';
    $target .= $userId . date('YmdHis', strtotime($dateNow)) . '.' . $extension;

    move_uploaded_file($file["tmp_name"], '../../' . $target);
  } else {

    $target = null;
    $fileName = null;
  }

  $command = 'SELECT profile_picture FROM users WHERE id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param('i', $userId);
  $statement->execute();
  $statement->bind_result($profilePicture);
  $statement->fetch();

  if ($profilePicture != 'pictures/profile_pictures/default.png') {
    unlink('../../' . $profilePicture);
  }

  $statement->close();

  $command = 'UPDATE users SET profile_picture = ? WHERE id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param(
    'si',
    $target,
    $userId
  );
  $statement->execute();
  $statement->close();

  $response = [
    'response' => $statement == false ? 'failed' : 'successful'
  ];
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
