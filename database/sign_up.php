<?php

session_start();

require 'connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['type'],
  $_POST['first_name'],
  $_POST['middle_name'],
  $_POST['last_name'],
  $_POST['gender'],
  $_POST['username'],
  $_POST['password'])
) {

  $type = $_POST['type'];
  $firstName = $_POST['first_name'];
  $middleName = $_POST['middle_name'];
  $lastName = $_POST['last_name'];
  $gender = $_POST['gender'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $profilePicture = 'pictures/profile_pictures/default.png';
  $dateNow = date('Y-m-d H:i:s');

  $command = 'SELECT * FROM users WHERE username = ?';

  $statement = $connection->prepare($command);
  $statement->bind_param('s', $username);
  $statement->execute();
  $statement->store_result();

  if ($statement->fetch()) {

    $response = [
      'response' => 'existing'
    ];
  } else {

    $command = 'INSERT INTO users(type, first_name, middle_name, last_name, gender, username, password, profile_picture, last_date_time_online) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)';

    $statement = $connection->prepare($command);
    $statement->bind_param(
      'sssssssss',
      $type,
      $firstName,
      $middleName,
      $lastName,
      $gender,
      $username,
      md5($password),
      $profilePicture,
      $dateNow
    );
    $statement->execute();

    $id = mysqli_insert_id($connection);

    $command = 'SELECT type, first_name, middle_name, last_name, username, profile_picture FROM users WHERE id = ?';

    $statement = $connection->prepare($command);
    $statement->bind_param('i', $id);
    $statement->execute();
    $statement->store_result();
    $statement->bind_result(
      $type,
      $firstName,
      $middleName,
      $lastName,
      $username,
      $profilePicture
    );

    if ($statement->fetch()) {

      $command = 'INSERT INTO log_in_history(person_id, date_time_log_in, date_time_log_out) VALUES(?, ?, ?)';

      $statement = $connection->prepare($command);
      $statement->bind_param(
        'iss',
        $id,
        $dateNow,
        $dateNow
      );
      $statement->execute();

      $logInId = mysqli_insert_id($connection);

      $_SESSION['status'] = 'online';
      $_SESSION['id'] = $info['id'] = $id;
      $_SESSION['type'] = $info['type'] = $type;
      $_SESSION['first_name'] = $info['first_name'] = $firstName;
      $_SESSION['middle_name'] = $info['middle_name'] = $middleName;
      $_SESSION['last_name'] = $info['last_name'] = $lastName;
      $_SESSION['username'] = $info['username'] = $username;
      $_SESSION['image'] = $info['image'] = $profilePicture;
      $_SESSION['log_in_id'] = $info['log_in_id'] = $logInId;

      $response = [
        'response' => 'successful',
        'info' => $info
      ];
    } else {

      $response = [
        'response' => 'failed'
      ];
    }
  }
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
