<?php

session_start();

require '../connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['notif_id'],
  $_POST['source_id'],
  $_POST['notif_cr'],
  $_POST['notif_code'])
) {

  $_SESSION['notif_id'] = $_POST['notif_id'];
  $_SESSION['source_id'] = $_POST['source_id'];
  $_SESSION['classroom_id'] = $_POST['notif_cr'];
  $_SESSION['notif_code'] = $_POST['notif_code'];

  $response = [
    'response' => 'successful'
  ];
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
