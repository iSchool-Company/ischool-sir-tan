<?php

require '../../connection.php';

function microseconds()
{
  $mt = explode(' ', microtime());
  return ((int)$mt[1]) * 1000000 + ((int)round($mt[0] * 1000000));
}

if (
  $_SERVER['REQUEST_METHOD'] === 'GET'
  &&
  isset(
    $_GET['classroom_id']
  )
) {

  $pythonDir = '../../../../python/';

  $classroomId = $_GET['classroom_id'];
  $data = [
    'classroom' => '',
    'instructor' => '',
    'respondents' => 0,
    'total' => 0,
    'feedbacks' => [
      'neg' => [],
      'neu' => [],
      'pos' => []
    ]
  ];

  $command = 'SELECT c.class, c.subject, u.first_name, u.middle_name, u.last_name FROM classrooms AS c LEFT JOIN users AS u ON c.teacher_id = u.id WHERE c.id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param('i', $classroomId);
  $statement->execute();
  $statement->bind_result(
    $className,
    $subjectName,
    $firstName,
    $middleName,
    $lastName
  );

  if ($statement->fetch()) {
    $data['classroom'] = $className . ' - ' . $subjectName;
    $data['instructor'] = implode(' ', array($firstName, $middleName, $lastName));
  } else {
    $data['classroom'] = 'Unknown';
    $data['instructor'] = 'Unknown';
  }

  $statement->close();

  $command = 'SELECT COUNT(1) FROM classroom_student_designation WHERE classroom_id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param('i', $classroomId);
  $statement->execute();
  $statement->bind_result($total);
  $statement->fetch();

  $data['total'] = $total;

  $statement->close();

  $command = 'SELECT cr.content, u.username, u.first_name, u.middle_name FROM classrooms AS c INNER JOIN classrooms_reviews AS cr ON c.id = cr.classroom_id LEFT JOIN users AS u ON cr.student_id = u.id WHERE c.id = ? ORDER BY u.first_name, u.last_name';
  $statement = $connection->prepare($command);
  $statement->bind_param('i', $classroomId);
  $statement->execute();
  $statement->bind_result(
    $content,
    $username,
    $firstName,
    $lastName
  );

  $feedbacks = [];
  $toBeProcessed = [
    'contents' => []
  ];

  while ($statement->fetch()) {

    $data['respondents']++;

    $displayName = "$firstName $lastName (@$username)";

    $feedback = [
      'displayName' => $displayName,
      'content' => $content
    ];

    $toBeProcessed['contents'][] = $content;
    $feedbacks[] = $feedback;
  }

  $ms = microseconds();
  $fileName = "feedback-cr-$ms.txt";
  $fileNameDir = "$pythonDir$fileName";

  $file = fopen($fileNameDir, 'w');

  file_put_contents($fileNameDir, json_encode($toBeProcessed));

  $pythonCommand = 'python ' . $pythonDir . 'sentiment_analysis_batch.py ' . $fileName;

  $stringOutput = shell_exec($pythonCommand);

  $jsonOutput = json_decode($stringOutput, true);

  $scores = $jsonOutput['scores'];

  foreach ($scores as $key => $score) {

    $compound = $score['compound'];
    $content = $feedbacks[$key];

    if ($compound >= 0.2) {
      $data['feedbacks']['pos'][] = $content;
    } else if ($compound <= -0.2) {
      $data['feedbacks']['neg'][] = $content;
    } else {
      $data['feedbacks']['neu'][] = $content;
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
