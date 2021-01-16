<?php

require '../connection.php';
require '../ischool.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['user_id'],
  $_POST['materials_id'],
  $_POST['rate_1'],
  $_POST['rate_2'],
  $_POST['rate_3'],
  $_POST['rate_4'],
  $_POST['rate_5'],
  $_POST['content'],
  $_POST['rate_value'],
  $_POST['anonymous'])
) {

  $userId = $_POST['user_id'];
  $materialsId = $_POST['materials_id'];
  $rate1 = $_POST['rate_1'];
  $rate2 = $_POST['rate_2'];
  $rate3 = $_POST['rate_3'];
  $rate4 = $_POST['rate_4'];
  $rate5 = $_POST['rate_5'];
  $content = $_POST['content'];
  $rateValue = $_POST['rate_value'];
  $anonymous = $_POST['anonymous'];
  $dateNow = date('Y-m-d H:i:s');

  $command = 'SELECT 1 FROM materials_reviews WHERE material_id = ? AND student_id = ?';

  $statement = $connection->prepare($command);
  $statement->bind_param(
    'ii',
    $materialsId,
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

  $command = 'INSERT INTO materials_reviews (material_id, student_id, rate_1, rate_2, rate_3, rate_4, rate_5, content, rate, anonymous) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';

  $statement = $connection->prepare($command);
  $statement->bind_param(
    'iisssssssi',
    $materialsId,
    $userId,
    $rate1,
    $rate2,
    $rate3,
    $rate4,
    $rate5,
    $content,
    $rateValueSubstr,
    $anonymous
  );
  $statement->execute();
  $statement->close();

  Ischool::activityLog(
    $connection,
    $userId,
    $materialsId,
    'mat_rate',
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
