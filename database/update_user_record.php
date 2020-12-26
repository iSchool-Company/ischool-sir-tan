<?php

require 'connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['user_id'],
  $_POST['part'],
  $_POST['password'])
) {

  $userId = $_POST['user_id'];
  $part = $_POST['part'];
  $password = $_POST['password'];
  $dateNow = date('Y-m-d H:i:s');

  $command = 'SELECT * FROM users WHERE id = ? AND password = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param('is', $userId, md5($password));
  $statement->execute();
  $statement->store_result();

  if (!$statement->fetch()) {

    $response = [
      'response' => 'wrong password'
    ];

    die(json_encode($response));
  }

  switch ($part) {

    case 'name':

      $firstName = $_POST['first_name'];
      $middleName = $_POST['middle_name'];
      $lastName = $_POST['last_name'];

      $command = 'UPDATE users SET first_name = ?, middle_name = ?, last_name = ? WHERE id = ? ';
      $statement = $connection->prepare($command);
      $statement->bind_param(
        'sssi',
        $firstName,
        $middleName,
        $lastName,
        $userId
      );
      $statement->execute();

      $action = 'name_edit';

      break;

    case 'gender':

      $gender = $_POST['gender'];

      $command = 'UPDATE users SET gender = ? WHERE id = ? ';
      $statement = $connection->prepare($command);
      $statement->bind_param(
        'si',
        $gender,
        $userId
      );
      $statement->execute();

      $action = 'gender_edit';

      break;

    case 'birthday':

      $birthday = date('Y-m-d', strtotime($_POST['birthday']));

      $command = 'UPDATE users SET birthday = ? WHERE id = ? ';
      $statement = $connection->prepare($command);
      $statement->bind_param(
        'si',
        $birthday,
        $userId
      );
      $statement->execute();

      $action = 'birthday_edit';

      break;

    case 'contact_number':

      $contactNumber = $_POST['contact_number'];

      $command = 'UPDATE users SET mobile_number = ? WHERE id = ? ';
      $statement = $connection->prepare($command);
      $statement->bind_param(
        'si',
        $contactNumber,
        $userId
      );
      $statement->execute();

      $action = 'contact_edit';

      break;

    case 'username':

      $username = $_POST['username'];

      $command = 'UPDATE users SET username = ? WHERE id = ? ';
      $statement = $connection->prepare($command);
      $statement->bind_param(
        'si',
        $username,
        $userId
      );
      $statement->execute();

      $action = 'username_edit';

      break;

    case 'email':

      $email = $_POST['email'];
      $emailExtension = $_POST['email_extension'];

      $command = 'UPDATE users SET email = ?, email_extension = ? WHERE id = ? ';
      $statement = $connection->prepare($command);
      $statement->bind_param(
        'ssi',
        $email,
        $emailExtension,
        $userId
      );
      $statement->execute();

      $action = 'email_edit';

      break;

    case 'password':

      $newPassword = $_POST['new_password'];

      $command = 'UPDATE users SET password = ? WHERE id = ?';
      $statement = $connection->prepare($command);
      $statement->bind_param(
        'si',
        md5($newPassword),
        $userId
      );
      $statement->execute();

      $action = 'password_edit';

      break;
  }

  $command = 'INSERT INTO activity_log(person_id, action, source_id, date_time_did) VALUES(?, ?, 0, ?)';
  $statement = $connection->prepare($command);
  $statement->bind_param(
    'iss',
    $userId,
    $action,
    $dateNow
  );
  $statement->execute();

  if ($statement) {

    $response = [
      'response' => 'successful'
    ];
  } else {

    $response = [
      'response' => 'failed'
    ];
  }

  echo json_encode($response);
} else {

  $response = [
    'response' => 'unauthorized'
  ];

  echo json_encode($response);
}
