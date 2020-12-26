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

  $command = 'SELECT id, password FROM admins WHERE username = ?';

  $statement = $connection->prepare($command);
  $statement->bind_param('s', $username);
  $statement->execute();
  $statement->store_result();
  $statement->bind_result(
    $id,
    $passwordOriginal
  );

  if ($statement->fetch()) {

    if ($passwordOriginal != md5($password)) {

      $response = [
        'response' => 'wrong password'
      ];
    } else {

      $_SESSION['id'] = $info['id'] = $id;

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
