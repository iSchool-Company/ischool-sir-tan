<?php

require '../../connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'GET'
  &&
  isset($_GET['classroom_id'])
) {

  $classroomId = $_GET['classroom_id'];

  $command = "SELECT class, subject, date_end FROM classrooms WHERE id = ?";

  $statement = $connection->prepare($command);
  $statement->bind_param('i', $classroomId);
  $statement->execute();
  $statement->store_result();
  $statement->bind_result(
    $className,
    $subjectName,
    $dateEnd
  );

  if ($statement->fetch()) {

    $data['class_name'] = $className;
    $data['subject_name'] = $subjectName;

    $data['status'] = $dateEnd > date('Y-m-d') ? 'on_going' : 'archived';

    $response = [
      'response' => 'found',
      'info' => $data
    ];
  } else {

    $response = [
      'response' => 'nothing'
    ];
  }
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
