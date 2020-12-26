<?php

require '../connection.php';
require '../ischool.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['user_id'],
  $_POST['backpack_id'])
) {

  $userId = $_POST['user_id'];
  $backpackId = $_POST['backpack_id'];
  $dateNow = date('Y-m-d H:i:s');

  $command = 'SELECT file FROM backpack WHERE id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param('i', $backpackId);
  $statement->execute();
  $statement->bind_result($file);

  if ($statement->fetch()) {

    unlink('../../' . $file);
  }

  $statement->close();

  $ok = Ischool::hardDelete(
    $connection,
    'backpack',
    $backpackId
  );

  Ischool::activityLog(
    $connection,
    $userId,
    0,
    'back_delete',
    $dateNow
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
