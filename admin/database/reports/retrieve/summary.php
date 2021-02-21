<?php

require '../../connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'GET'
) {

  $pythonDir = '../../../../python/';

  $data = [
    'classrooms' => []
  ];

  $command = 'SELECT c.id, c.class, c.subject, u.first_name, u.middle_name, u.last_name FROM classrooms AS c LEFT JOIN users AS u ON c.teacher_id = u.id WHERE is_deleted = 0';
  $statement = $connection->prepare($command);
  $statement->execute();
  $statement->bind_result(
    $id,
    $className,
    $subjectName,
    $firstName,
    $middleName,
    $lastName
  );

  while ($statement->fetch()) {
    $data['classrooms'][] = [
      'id' => $id,
      'classroom' => $className . ' - ' . $subjectName,
      'instructor' => implode(' ', array($firstName, $middleName, $lastName))
    ];
  }

  $statement->close();

  foreach ($data['classrooms'] as &$cr) {

    $classroomId = $cr['id'];

    $command = 'SELECT COUNT(1) FROM classroom_student_designation WHERE classroom_id = ?';
    $statement = $connection->prepare($command);
    $statement->bind_param('i', $classroomId);
    $statement->execute();
    $statement->bind_result($total);
    $statement->fetch();

    $cr['total'] = $total;

    $statement->close();
  }

  foreach ($data['classrooms'] as &$cr) {

    $classroomId = $cr['id'];

    $fileName = "summary-cr-$classroomId.txt";
    $fileNameDir = "$pythonDir$fileName";

    $file = fopen($fileNameDir, 'w');

    $command = 'SELECT cr.content FROM classrooms AS c INNER JOIN classrooms_reviews AS cr ON c.id = cr.classroom_id WHERE c.id = ?';
    $statement = $connection->prepare($command);
    $statement->bind_param('i', $classroomId);
    $statement->execute();
    $statement->bind_result($content);

    $cr['neg'] = 0;
    $cr['neu'] = 0;
    $cr['pos'] = 0;

    while ($statement->fetch()) {

      file_put_contents($fileNameDir, $content);

      $pythonCommand = 'python ' . $pythonDir . 'sentiment_analysis.py ' . $fileName;

      $scoreJSONString = shell_exec($pythonCommand);

      $scoreJSON = json_decode($scoreJSONString, true);

      $compound = $scoreJSON['compound'];

      if ($compound >= 0.2) {
        $cr['pos']++;
      } else if ($compound <= -0.2) {
        $cr['neg']++;
      } else {
        $cr['neu']++;
      }
    }

    fclose($file);

    unlink($fileNameDir);
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
