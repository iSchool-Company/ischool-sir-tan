<?php

require '../../connection.php';

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

  $fileName = "summary-$classroomId.txt";
  $fileNameDir = "$pythonDir$fileName";

  $file = fopen($fileNameDir, 'w');

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

    while ($statement->fetch()) {

      file_put_contents($fileNameDir, $content);

      $pythonCommand = 'python ' . $pythonDir . 'sentiment_analysis.py ' . $fileName;

      $scoreJSONString = shell_exec($pythonCommand);

      $scoreJSON = json_decode($scoreJSONString, true);

      $compound = $scoreJSON['compound'];

      if ($compound >= 0.2) {
        $mat['pos']++;
      } else if ($compound <= -0.2) {
        $mat['neg']++;
      } else {
        $mat['neu']++;
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
