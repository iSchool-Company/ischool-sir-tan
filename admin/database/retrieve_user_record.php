<?php

require 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['user_id'])) {

  $user_id = $_GET['user_id'];

  $command = 'SELECT first_name, middle_name, last_name, gender, birthday, email, email_extension, mobile_number, username, profile_picture FROM admins WHERE id = ?';

  $statement = $connection->prepare($command);
  $statement->bind_param('i', $user_id);
  $statement->execute();
  $statement->store_result();
  $statement->bind_result($first_name, $middle_name, $last_name, $gender, $birthday, $email, $email_extension, $mobile_number, $username, $profile_picture);

  if ($statement->fetch()) {

    $data['first_name'] = $first_name;
    $data['middle_name'] = $middle_name;
    $data['last_name'] = $last_name;
    $data['gender'] = $gender;
    $data['birthday'] = date('M d, Y', strtotime($birthday));
    $data['birthday_firefox'] = date('m/d/Y', strtotime($birthday));
    $data['birthday_proper'] = date('Y-m-d', strtotime($birthday));
    $data['email'] = $email;
    $data['email_extension'] = $email_extension;
    $data['mobile_number'] = $mobile_number;
    $data['username'] = $username;
    $data['profile_picture'] = $profile_picture;

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
