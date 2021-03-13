<?php

require '../../connection.php';

function microseconds()
{
  $mt = explode(' ', microtime());
  return ((int)$mt[1]) * 1000000 + ((int)round($mt[0] * 1000000));
}

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

  $groups = [];

  foreach ($data['classrooms'] as &$cr) {

    $classroomId = $cr['id'];

    $command = 'SELECT cr.content FROM classrooms AS c INNER JOIN classrooms_reviews AS cr ON c.id = cr.classroom_id WHERE c.id = ?';
    $statement = $connection->prepare($command);
    $statement->bind_param('i', $classroomId);
    $statement->execute();
    $statement->bind_result($content);

    $cr['neg'] = 0;
    $cr['neu'] = 0;
    $cr['pos'] = 0;

    $group = [];

    while ($statement->fetch()) {
      $group[] = $content;
    }

    $groups[] = $group;
  }

  $toBeProcessed = [
    'groups' => $groups
  ];

  $ms = microseconds();
  $fileName = "summary-cr-$ms.txt";
  $fileNameDir = "$pythonDir$fileName";

  $file = fopen($fileNameDir, 'w');

  file_put_contents($fileNameDir, json_encode($toBeProcessed));

  $pythonCommand = 'python ' . $pythonDir . 'sentiment_analysis_group.py ' . $fileName;

  $stringOutput = shell_exec($pythonCommand);

  $jsonOutput = json_decode($stringOutput, true);

  $scores = $jsonOutput['groups'];

  foreach ($scores as $key => $group) {

    foreach ($group as $score) {

      $compound = $score['compound'];

      if ($compound >= 0.2) {
        $data['classrooms'][$key]['pos']++;
      } else if ($compound <= -0.2) {
        $data['classrooms'][$key]['neg']++;
      } else {
        $data['classrooms'][$key]['neu']++;
      }
    }
  }

  fclose($file);

  unlink($fileNameDir);

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
