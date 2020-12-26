<?php

require '../../connection.php';
require '../../ischool.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['user_id'],
  $_POST['question_id'])
) {

  $userId = $_POST['user_id'];
  $questionId = $_POST['question_id'];
  $dateNow = date('Y-m-d H:i:s');

  $ok = Ischool::hardDelete(
    $connection,
    'quiz_questions',
    $questionId
  );

  $response = [
    'response' => $ok === false ? 'failed' : 'successful'
  ];
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
