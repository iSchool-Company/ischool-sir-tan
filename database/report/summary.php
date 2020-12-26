<?php

require '../connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'GET'
  &&
  isset($_GET['type'],
  $_GET['display'])
) {

  $type = $_GET['type'];
  $display = $_GET['display'];
  $ids = isset($_GET['ids']) ? $_GET['ids'] : [];
  $summaries = [];

  if ($type === 'Assignment') {

    $command = 'SELECT CONCAT(u.last_name, ", ", u.first_name, " ", u.middle_name), asub.date_time_submitted, asub.grade, 100 FROM assignment_submissions AS asub LEFT JOIN users AS u ON asub.student_id = u.id WHERE asub.assignment_id = ? ORDER BY u.last_name';
  } else {

    $command = 'SELECT CONCAT(u.last_name, ", ", u.first_name, " ", u.middle_name), qs.date_time_took, qs.score, (SELECT COUNT(*) FROM quiz_questions AS qq WHERE qq.quiz_id = qs.quiz_id) FROM quiz_submissions AS qs LEFT JOIN users AS u ON qs.student_id = u.id WHERE qs.quiz_id = ? ORDER BY u.last_name';
  }

  $statement = $connection->prepare($command);
  $statement->bind_param('i', $id);
  $statement->bind_result(
    $name,
    $dateTime,
    $score,
    $overall
  );

  foreach ($ids as $id) {

    $statement->execute();

    if ($display === 'Detailed') {

      $record = [
        'number' => $id,
        'records' => []
      ];
    } else {

      $record = [
        'number' => $id,
        'percent' => 0
      ];

      $scores = 0;
      $overalls = 0;
    }

    while ($statement->fetch()) {

      if ($display === 'Detailed') {

        $data['name'] = $name;

        if ($dateTime === null) {

          $data['date_time'] = '---';
        } else {

          $data['date_time'] = date('M d, Y h:i A', strtotime($dateTime));
        }

        if ($type === 'Assignment') {

          if ($score === null) {

            $data['rate'] = '---';
          } else {

            $data['rate'] = $score;
          }
        } else {

          if ($score === null) {

            $data['rate'] = '---';
          } else {

            $data['rate'] = $score . '/' . $overall . ' (' . intval(($score / $overall) * 100) . '%)';
          }
        }

        $record['records'][] = $data;
      } else {

        if ($score !== null) {
          $scores += $score;
          $overalls += $overall;
        } else {
          $scores += 0;
          $overalls += $overall;
        }

        if ($scores !== 0) {
          $record['percent'] = ($scores / $overalls) * 100;
        } else {
          $record['percent'] = 0;
        }
      }
    }

    $summaries[] = $record;
  }

  $response = [
    'response' => $summaries === [] ? 'nothing' : 'found',
    'summaries' => $summaries
  ];
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
