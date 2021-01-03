<?php

require '../../connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'GET'
  &&
  isset($_GET['user_id'],
  $_GET['classroom_id'])
) {

  $userId = $_GET['user_id'];
  $classroomId = $_GET['classroom_id'];
  $materials = [];

  $command = 'SELECT m.id AS id, file_name FROM materials AS m LEFT JOIN materials_reviews AS mr ON m.id = material_id AND student_id = ? WHERE classroom_id = ? AND student_id IS NULL';
  $statement = $connection->prepare($command);
  $statement->bind_param(
    'ii',
    $userId,
    $classroomId
  );
  $statement->execute();
  $statement->store_result();
  $statement->bind_result(
    $id,
    $fileName
  );

  while ($statement->fetch()) {

    $data['id'] = $id;
    $data['file_name'] = $fileName;

    $materials[] = $data;
  }

  $response = [
    'response' => $materials === [] ? 'nothing' : 'found',
    'materials' => $materials
  ];
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
