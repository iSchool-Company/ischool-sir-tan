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
    'feedbacks' => [
      'neg' => [],
      'neu' => [],
      'pos' => []
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

  $command = 'SELECT mr.content, mr.anonymous, u.username, u.first_name, u.middle_name FROM materials AS m INNER JOIN materials_reviews AS mr ON m.id = mr.material_id LEFT JOIN users AS u ON mr.student_id = u.id WHERE m.id = ?';
  $statement = $connection->prepare($command);
  $statement->bind_param('i', $materialsId);
  $statement->execute();
  $statement->bind_result(
    $content,
    $anonymous,
    $username,
    $firstName,
    $lastName
  );

  $fileName = "feedback-$classroomId-$materialsId.txt";
  $fileNameDir = "$pythonDir$fileName";

  $file = fopen($fileNameDir, 'w');

  while ($statement->fetch()) {

    $data['respondents']++;

    $displayName = $anonymous == 1 ? 'Anonymous' : "$firstName $lastName (@$username)";

    $feedback = [
      'displayName' => $displayName,
      'content' => $content
    ];

    file_put_contents($fileNameDir, $content);

    $pythonCommand = 'python ' . $pythonDir . 'sentiment_analysis.py ' . $fileName;

    $scoreJSONString = shell_exec($pythonCommand);

    $scoreJSON = json_decode($scoreJSONString, true);

    $compound = $scoreJSON['compound'];

    if ($compound >= 0.2) {
      $data['feedbacks']['pos'][] = $feedback;
    } else if ($compound <= -0.2) {
      $data['feedbacks']['neg'][] = $feedback;
    } else {
      $data['feedbacks']['neu'][] = $feedback;
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
