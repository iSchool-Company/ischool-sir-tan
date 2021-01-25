<?php

require '../../connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'GET'
  &&
  isset($_GET['materials_id'],
  $_GET['classroom_id'])
) {

  $pythonDir = '../../../python/';

  $materialsId = $_GET['materials_id'];
  $classroomId = $_GET['classroom_id'];
  $data = [
    'name' => '',
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
    'sentiment_analysis' => [
      'neg' => 0,
      'neu' => 0,
      'pos' => 0
    ]
  ];

  $command = 'SELECT file_name FROM materials WHERE id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param('i', $materialsId);
  $statement->execute();
  $statement->bind_result($name);

  if ($statement->fetch()) {
    $data['name'] = $name;
  } else {
    $data['name'] = 'Unknown';
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

  $command = 'SELECT mr.rate, mr.rate_1, mr.rate_2, mr.rate_3, mr.rate_4, mr.rate_5, mr.content FROM materials AS m INNER JOIN materials_reviews AS mr ON m.id = mr.material_id WHERE m.id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param('i', $materialsId);
  $statement->execute();
  $statement->bind_result(
    $rate,
    $rate_1,
    $rate_2,
    $rate_3,
    $rate_4,
    $rate_5,
    $content
  );

  $fileName = "$classroomId-$materialsId.txt";
  $fileNameDir = "$pythonDir$fileName";

  $file = fopen($fileNameDir, 'w');

  while ($statement->fetch()) {

    $data['respondents']++;
    $data['overall_rate'][$rate]++;
    $data['rate_1'][$rate_1]++;
    $data['rate_2'][$rate_2]++;
    $data['rate_3'][$rate_3]++;
    $data['rate_4'][$rate_4]++;
    $data['rate_5'][$rate_5]++;

    file_put_contents($fileNameDir, $content);

    $pythonCommand = 'python ' . $pythonDir . 'sentiment_analysis.py ' . $fileName;

    $scoreJSONString = shell_exec($pythonCommand);

    $scoreJSON = json_decode($scoreJSONString, true);

    $compound = $scoreJSON['compound'];

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
