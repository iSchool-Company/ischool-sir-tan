<?php

require '../connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['user_id'],
  $_POST['title'],
  $_POST['content'],
  $_FILES['file'])
) {

  $userId = $_POST['user_id'];
  $title = $_POST['title'];
  $content = $_POST['content'];
  $dateNow = date('Y-m-d H:i:s');

  if (isset($_FILES['file'])) {

    $file = $_FILES['file'];
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $target = 'pictures/news/';
    $target .= date('YmdHis', strtotime($dateNow)) . '.' . $extension;

    move_uploaded_file($file["tmp_name"], '../../../' . $target);
  } else {

    $target = null;
    $fileName = null;
  }

  $command = 'INSERT INTO news(admin_id, image, title, caption, date_time_posted) VALUES(?, ?, ?, ?, ?)';
  $statement = $connection->prepare($command);
  $statement->bind_param(
    'issss',
    $userId,
    $target,
    $title,
    $content,
    $dateNow
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
