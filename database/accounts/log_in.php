<?php

session_start();

require '../connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['username'],
  $_POST['password'])
) {

  $username = $_POST['username'];
  $password = $_POST['password'];
  $dateNow = date('Y-m-d H:i:s');

  $command = 'SELECT id, type, first_name, middle_name, last_name, username, password, profile_picture FROM users WHERE username = ? AND type IN("Teacher", "Student")';

  $statement = $connection->prepare($command);
  $statement->bind_param('s', $username);
  $statement->execute();
  $statement->store_result();
  $statement->bind_result(
    $id,
    $type,
    $firstName,
    $middleName,
    $lastName,
    $username,
    $passwordOriginal,
    $profilePicture
  );

  if ($statement->fetch()) {

    if ($passwordOriginal != md5($password)) {

      $response = [
        'response' => 'wrong password'
      ];
    } else {

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
    }
  } else {

    $response = [
      'response' => 'failed'
    ];
  }
} else {

  $response = [

    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
