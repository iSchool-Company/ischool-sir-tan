<?php

require '../../connection.php';
require '../../utilities.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'GET'
  &&
  isset($_GET['materials_id'],
  $_GET['user_id'],
  $_GET['is_student'],
  $_GET['version'])
) {

  $materialsId = $_GET['materials_id'];
  $isStudent = $_GET['is_student'];
  $userId = $isStudent ? $_GET['user_id'] : 0;
  $version = $_GET['version'];
  $data = [];

  $command = 'SELECT file, file_name, date_time_added, (mr.id IS NOT NULL) AS has_review FROM materials AS m LEFT JOIN materials_reviews AS mr ON m.id = mr.material_id AND mr.student_id = ? WHERE m.id = ? ORDER BY m.id ASC';
  $statement = $connection->prepare($command);
  $statement->bind_param(
    'ii',
    $userId,
    $materialsId
  );
  $statement->execute();
  $statement->bind_result(
    $file,
    $fileName,
    $dateTimeAdded,
    $hasReview
  );

  if ($statement->fetch()) {
    $data['file'] = $file;
    $data['topic'] = $fileName;
    $data['date_time_added'] = date('M d, Y h:i a', strtotime($dateTimeAdded));
    $data['has_review'] = $hasReview;
  }

  $response = [
    'response' => $data === [] ? 'nothing' : 'found',
    'info' => $data
  ];
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
