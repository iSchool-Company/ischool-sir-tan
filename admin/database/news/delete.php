<?php

require '../connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['news_id'])
) {

  $newsId = $_POST['news_id'];

  $command = 'DELETE FROM news WHERE id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param('i', $newsId);
  $statement->execute();
  $statement->close();

  $response = [
    'response' => $statement == false ? 'failed' : 'successful'
  ];
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
