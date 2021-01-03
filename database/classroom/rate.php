<?php

require '../connection.php';
require '../ischool.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['user_id'],
  $_POST['classroom_id'],
  $_POST['content'],
  $_POST['rate_value'])
) {

  $userId = $_POST['user_id'];
  $classroomId = $_POST['classroom_id'];
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

  $command = 'INSERT INTO classrooms_reviews (classroom_id, student_id, content, rate) VALUES (?, ?, ?, ?)';

  $statement = $connection->prepare($command);
  $statement->bind_param(
    'iiss',
    $classroomId,
    $userId,
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
