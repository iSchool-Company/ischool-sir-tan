<?php

require '../../../connection.php';
require '../../../utilities.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'GET'
  &&
  isset($_GET['submission_id'])
) {

  $submissionId = $_GET['submission_id'];
  $info = [];

  $command = 'SELECT CONCAT(u.last_name, ", ", u.first_name, " ", u.middle_name), qs.date_time_took, qs.date_time_done, qs.due_date, qs.due_time, qs.score, (SELECT COUNT(*) FROM quiz_questions AS qq WHERE qq.quiz_id = qs.quiz_id) FROM quiz_submissions AS qs LEFT JOIN users AS u ON qs.student_id = u.id WHERE qs.id = ?';

  $statement = $connection->prepare($command);
  $statement->bind_param('i', $submissionId);
  $statement->execute();
  $statement->bind_result(
    $name,
    $dateTimeTook,
    $dateTimeDone,
    $dueDate,
    $dueTime,
    $score,
    $overall
  );

  if ($statement->fetch()) {

    $data['name'] = $name;

    if ($score === null) {

      if ($dueDate === null) {
        $data['date_time_taken'] = 'Publish First';
        $data['score'] = '---';
      } elseif (Utilities::dateDiff($dueDate . ' ' . $dueTime) > 0) {
        $data['date_time_taken'] = 'Pending';
        $data['score'] = '---';
      } else {
        $data['date_time_taken'] = 'Late';
        $data['score'] = '0' . '/' . $overall;
      }
    } else {

      if (Utilities::dateDiff2($dateTimeDone) < 60) {
        $data['date_time_taken'] = 'Now Taking...';
        $data['score'] = '---';
      } else {
        $data['date_time_taken'] = date('M d, Y h:i A', strtotime($dateTimeTook));
        $data['score'] = $score . '/' . $overall;
      }
    }

    $info = $data;
  }

  $response = [
    'response' => $info === [] ? 'nothing' : 'found',
    'info' => $info
  ];
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
