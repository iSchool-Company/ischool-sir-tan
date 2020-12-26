<?php

require '../../connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  &&
  isset($_POST['user_id'],
  $_POST['classroom_id'],
  $_POST['submission_id'])
) {

  $userId = $_POST['user_id'];
  $classroomId = $_POST['classroom_id'];
  $submissionId = $_POST['submission_id'];
  $dateNow = date('Y-m-d H:i:s');

  $command = 'SELECT file, file_name FROM assignment_submissions WHERE id = ?';

  $statement = $connection->prepare($command);
  $statement->bind_param('i', $submissionId);
  $statement->execute();
  $statement->bind_result(
    $file,
    $fileName
  );

  if ($statement->fetch()) {

    $statement->close();

    $command = 'SELECT * FROM backpack WHERE file_name = ? AND user_id = ?';
    $statement = $connection->prepare($command);
    $statement->bind_param(
      'si',
      $fileName,
      $userId
    );
    $statement->execute();

    if ($statement->fetch()) {

      $response = [
        'response' => 'existing'
      ];

      die(json_encode($response));
    }

    $statement->close();

    $backpackFile = 'files/backpack/' . $userId . '-' . $fileName;
    $copySuccess = copy('../../../' . $file, '../../../' . $backpackFile);
  }

  if ($copySuccess) {

    $command = 'INSERT INTO backpack(user_id, file, file_name, date_time_added) VALUES(?, ?, ?, ?)';

    $statement = $connection->prepare($command);
    $statement->bind_param(
      'isss',
      $userId,
      $backpackFile,
      $fileName,
      $dateNow
    );
    $statement->execute();
  }

  $response = [
    'response' => $statement == false ? 'failed' : 'successful'
  ];
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
