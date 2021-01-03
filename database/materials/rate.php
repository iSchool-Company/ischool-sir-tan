<?php

require '../connection.php';
require '../ischool.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['user_id'],
  $_POST['materials_id'],
  $_POST['content'],
  $_POST['rate_value'],
  $_POST['anonymous'])
) {

  $userId = $_POST['user_id'];
  $materialsId = $_POST['materials_id'];
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

  $command = 'INSERT INTO materials_reviews (material_id, student_id, content, rate, anonymous) VALUES (?, ?, ?, ?, ?)';

  $statement = $connection->prepare($command);
  $statement->bind_param(
    'iissi',
    $materialsId,
    $userId,
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
