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

  $pythonDir = '../../../python/';

  $classroomId = $_GET['classroom_id'];
  $data = [
    'total' => 0,
    'materials' => []
  ];

  $command = 'SELECT COUNT(1) FROM classroom_student_designation WHERE classroom_id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param('i', $classroomId);
  $statement->execute();
  $statement->bind_result($total);
  $statement->fetch();

  $data['total'] = $total;

  $statement->close();

  $command = 'SELECT id, file_name FROM materials WHERE classroom_id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param('i', $classroomId);
  $statement->execute();
  $statement->bind_result($id, $materialName);

  while ($statement->fetch()) {
    $data['materials'][] = [
      'id' => $id,
      'name' => $materialName
    ];
  }

  $statement->close();

  $groups = [];

  foreach ($data['materials'] as &$mat) {

    $materialsId = $mat['id'];

    $command = 'SELECT mr.content FROM materials AS m INNER JOIN materials_reviews AS mr ON m.id = mr.material_id WHERE m.id = ?';
    $statement = $connection->prepare($command);
    $statement->bind_param('i', $materialsId);
    $statement->execute();
    $statement->bind_result($content);

    $mat['neg'] = 0;
    $mat['neu'] = 0;
    $mat['pos'] = 0;

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
  $fileName = "summary-$ms.txt";
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
        $data['materials'][$key]['pos']++;
      } else if ($compound <= -0.2) {
        $data['materials'][$key]['neg']++;
      } else {
        $data['materials'][$key]['neu']++;
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
