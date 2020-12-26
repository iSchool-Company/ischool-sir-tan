<?php

require 'connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'GET'
  &&
  isset($_GET['user_id'])
) {

  $userId = $_GET['user_id'];

  $command = 'SELECT first_name, middle_name, last_name, gender, birthday, email, email_extension, mobile_number, username, profile_picture FROM users WHERE id = ?';

  $statement = $connection->prepare($command);
  $statement->bind_param('i', $userId);
  $statement->execute();
  $statement->store_result();
  $statement->bind_result(
    $firstName,
    $middleName,
    $lastName,
    $gender,
    $birthday,
    $email,
    $emailExtension,
    $mobileNumber,
    $username,
    $profilePicture
  );

  if ($statement->fetch()) {

    $data['first_name'] = $firstName;
    $data['middle_name'] = $middleName;
    $data['last_name'] = $lastName;
    $data['gender'] = $gender;

    if ($birthday === null) {

      $data['birthday'] = 'Not Available';
      $data['birthday_firefox'] = '';
    } else {

      $data['birthday'] = date('F d, Y', strtotime($birthday));
      $data['birthday_firefox'] = date('m/d/Y', strtotime($birthday));
    }

    $data['email'] = $email;
    $data['email_extension'] = $emailExtension;
    $data['mobile_number'] = $mobileNumber;
    $data['username'] = $username;
    $data['profile_picture'] = $profilePicture;

    $response = [
      'response' => 'found',
      'info' => $data
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
