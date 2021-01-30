<?php

require '../connection.php';
require '../ischool.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['user_id'],
  $_POST['classroom_id'],
  $_POST['rate_1'],
  $_POST['rate_2'],
  $_POST['rate_3'],
  $_POST['rate_4'],
  $_POST['rate_5'],
  $_POST['rate_6'],
  $_POST['rate_7'],
  $_POST['rate_8'],
  $_POST['rate_9'],
  $_POST['rate_10'],
  $_POST['rate_11'],
  $_POST['content'],
  $_POST['rate_value'])
) {

  $userId = $_POST['user_id'];
  $classroomId = $_POST['classroom_id'];
  $rate1 = $_POST['rate_1'];
  $rate2 = $_POST['rate_2'];
  $rate3 = $_POST['rate_3'];
  $rate4 = $_POST['rate_4'];
  $rate5 = $_POST['rate_5'];
  $rate6 = $_POST['rate_6'];
  $rate7 = $_POST['rate_7'];
  $rate8 = $_POST['rate_8'];
  $rate9 = $_POST['rate_9'];
  $rate10 = $_POST['rate_10'];
  $rate11 = $_POST['rate_11'];
  $content = $_POST['content'];
  $rateValue = $_POST['rate_value'];
  $dateNow = date('Y-m-d H:i:s');

  $command = 'SELECT 1 FROM classrooms_reviews WHERE classroom_id = ? AND student_id = ?';

  $statement = $connection->prepare($command);
  $statement->bind_param(
    'ii',
    $classroomId,
    $userId
  );
  $statement->execute();

  if ($statement->fetch()) {

    $response = [
      'response' => 'existing'
    ];

    die(json_encode($response));
  }

  $rateValueSubstr = substr($rateValue, 0, 3);

  $command = 'INSERT INTO classrooms_reviews (classroom_id, student_id, rate_1, rate_2, rate_3, rate_4, rate_5, rate_6, rate_7, rate_8, rate_9, rate_10, rate_11, content, rate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';

  $statement = $connection->prepare($command);
  $statement->bind_param(
    'iisssssssssssss',
    $classroomId,
    $userId,
    $rate1,
    $rate2,
    $rate3,
    $rate4,
    $rate5,
    $rate6,
    $rate7,
    $rate8,
    $rate9,
    $rate10,
    $rate11,
    $content,
    $rateValueSubstr
  );
  $statement->execute();
  $statement->close();

  Ischool::activityLog(
    $connection,
    $userId,
    $classroomId,
    'cr_rate',
    $dateNow
  );

  $response = [
    'response' => $statement == false ? 'failed' : 'successful'
  ];
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
