<?php

require 'database/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'], $_POST['part'], $_POST['password'])) {

  $user_id = $_POST['user_id'];
  $part = $_POST['part'];
  $password = $_POST['password'];
  $date_now = date('Y-m-d H:i:s');

  $command = 'SELECT * FROM admins WHERE id = ? AND password = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param('is', $user_id, md5($password));
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

      $first_name = $_POST['first_name'];
      $middle_name = $_POST['middle_name'];
      $last_name = $_POST['last_name'];

      $command = 'UPDATE admins SET first_name = ?, middle_name = ?, last_name = ? WHERE id = ? ';
      $statement = $connection->prepare($command);
      $statement->bind_param('sssi', $first_name, $middle_name, $last_name, $user_id);
      $statement->execute();

      $action = 'name_edit';

      break;

    case 'gender':

      $gender = $_POST['gender'];

      $command = 'UPDATE admins SET gender = ? WHERE id = ? ';
      $statement = $connection->prepare($command);
      $statement->bind_param('si', $gender, $user_id);
      $statement->execute();

      $action = 'gender_edit';

      break;

    case 'birthday':

      $birthday = date('Y-m-d', strtotime($_POST['birthday']));

      $command = 'UPDATE admins SET birthday = ? WHERE id = ? ';
      $statement = $connection->prepare($command);
      $statement->bind_param('si', $birthday, $user_id);
      $statement->execute();

      $action = 'birthday_edit';

      break;

    case 'contact_number':

      $contact_number = $_POST['contact_number'];

      $command = 'UPDATE admins SET mobile_number = ? WHERE id = ? ';
      $statement = $connection->prepare($command);
      $statement->bind_param('ii', $contact_number, $user_id);
      $statement->execute();

      $action = 'contact_edit';

      break;

    case 'username':

      $username = $_POST['username'];

      $command = 'UPDATE admins SET username = ? WHERE id = ? ';
      $statement = $connection->prepare($command);
      $statement->bind_param('si', $username, $user_id);
      $statement->execute();

      $action = 'username_edit';

      break;

    case 'email':

      $email = $_POST['email'];
      $email_extension = $_POST['email_extension'];

      $command = 'UPDATE admins SET email = ?, email_extension = ? WHERE id = ? ';
      $statement = $connection->prepare($command);
      $statement->bind_param('ssi', $email, $email_extension, $user_id);
      $statement->execute();

      $action = 'email_edit';

      break;

    case 'password':

      $newPassword = $_POST['new_password'];

      $command = 'UPDATE admins SET password = ? WHERE id = ?';
      $statement = $connection->prepare($command);
      $statement->bind_param('si', md5($newPassword), $user_id);
      $statement->execute();

      $action = 'password_edit';

      break;
  }

  $command = 'INSERT INTO activity_log(person_id, action, source_id, date_time_did) VALUES(?, ?, 0, ?)';
  $statement = $connection->prepare($command);
  $statement->bind_param('iss', $user_id, $action, $date_now);
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
