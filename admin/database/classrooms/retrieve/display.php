<?php

require '../../connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'GET'
) {

  $command = 'SELECT c.id, c.class, c.subject, c.description, c.date_end, c.is_review_open, u.first_name, u.middle_name, u.last_name FROM classrooms AS c LEFT JOIN users AS u ON c.teacher_id = u.id WHERE c.is_deleted = 0';
  $statement = $connection->prepare($command);
  $statement->execute();
  $statement->bind_result(
    $id,
    $className,
    $subjectName,
    $description,
    $dateEnd,
    $isReviewOpen,
    $firstName,
    $middleName,
    $lastName
  );

  $classrooms = [];

  while ($statement->fetch()) {

    $data = [
      'id' => $id,
      'className' => $className,
      'subjectName' => $subjectName,
      'description' => $description,
      'dateEnd' => $dateEnd,
      'isReviewOpen' => $isReviewOpen == 1,
      'instructor' => implode(' ', [$firstName, $middleName, $lastName])
    ];

    $classrooms[] = $data;
  }

  $response = [
    'response' => 'found',
    'classrooms' => $classrooms
  ];
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
