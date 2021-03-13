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
  isset($_GET['classroom_id'])
) {

  $pythonDir = '../../../../python/';

  $classroomId = $_GET['classroom_id'];
  $data = [
    'classroom' => '',
    'instructor' => '',
    'respondents' => 0,
    'total' => 0,
    'overall_rate' => [
      'neg' => 0,
      'neu' => 0,
      'pos' => 0
    ],
    'rate_1' => [
      'neg' => 0,
      'neu' => 0,
      'pos' => 0
    ],
    'rate_2' => [
      'neg' => 0,
      'neu' => 0,
      'pos' => 0
    ],
    'rate_3' => [
      'neg' => 0,
      'neu' => 0,
      'pos' => 0
    ],
    'rate_4' => [
      'neg' => 0,
      'neu' => 0,
      'pos' => 0
    ],
    'rate_5' => [
      'neg' => 0,
      'neu' => 0,
      'pos' => 0
    ],
    'rate_6' => [
      'neg' => 0,
      'neu' => 0,
      'pos' => 0
    ],
    'rate_7' => [
      'neg' => 0,
      'neu' => 0,
      'pos' => 0
    ],
    'rate_8' => [
      'neg' => 0,
      'neu' => 0,
      'pos' => 0
    ],
    'rate_9' => [
      'neg' => 0,
      'neu' => 0,
      'pos' => 0
    ],
    'rate_10' => [
      'neg' => 0,
      'neu' => 0,
      'pos' => 0
    ],
    'rate_11' => [
      'neg' => 0,
      'neu' => 0,
      'pos' => 0
    ],
    'sentiment_analysis' => [
      'neg' => 0,
      'neu' => 0,
      'pos' => 0
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

  $command = 'SELECT cr.rate, cr.rate_1, cr.rate_2, cr.rate_3, cr.rate_4, cr.rate_5, cr.rate_6, cr.rate_7, cr.rate_8, cr.rate_9, cr.rate_10, cr.rate_11, cr.content FROM classrooms AS c INNER JOIN classrooms_reviews AS cr ON c.id = cr.classroom_id WHERE c.id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param('i', $classroomId);
  $statement->execute();
  $statement->bind_result(
    $rate,
    $rate_1,
    $rate_2,
    $rate_3,
    $rate_4,
    $rate_5,
    $rate_6,
    $rate_7,
    $rate_8,
    $rate_9,
    $rate_10,
    $rate_11,
    $content
  );

  $toBeProcessed = [
    'contents' => []
  ];

  while ($statement->fetch()) {

    $data['respondents']++;
    $data['overall_rate'][$rate]++;
    $data['rate_1'][$rate_1]++;
    $data['rate_2'][$rate_2]++;
    $data['rate_3'][$rate_3]++;
    $data['rate_4'][$rate_4]++;
    $data['rate_5'][$rate_5]++;
    $data['rate_6'][$rate_6]++;
    $data['rate_7'][$rate_7]++;
    $data['rate_8'][$rate_8]++;
    $data['rate_9'][$rate_9]++;
    $data['rate_10'][$rate_10]++;
    $data['rate_11'][$rate_11]++;

    $toBeProcessed['contents'][] = $content;
  }

  $ms = microseconds();
  $fileName = "detailed-cr-$ms.txt";
  $fileNameDir = "$pythonDir$fileName";

  $file = fopen($fileNameDir, 'w');

  file_put_contents($fileNameDir, json_encode($toBeProcessed));

  $pythonCommand = 'python ' . $pythonDir . 'sentiment_analysis_batch.py ' . $fileName;

  $stringOutput = shell_exec($pythonCommand);

  $jsonOutput = json_decode($stringOutput, true);

  $scores = $jsonOutput['scores'];

  foreach ($scores as &$score) {

    $compound = $score['compound'];

    if ($compound >= 0.2) {
      $data['sentiment_analysis']['pos']++;
    } else if ($compound <= -0.2) {
      $data['sentiment_analysis']['neg']++;
    } else {
      $data['sentiment_analysis']['neu']++;
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
