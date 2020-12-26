<?php

require '../../connection.php';
require '../../utilities.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'GET'
  &&
  isset($_GET['submission_id'])
) {

  $submissionId = $_GET['submission_id'];
  $info = [];

  $command = 'SELECT asub.assignment_id, CONCAT(u.last_name, ", ", u.first_name, " ", u.middle_name), asub.date_time_submitted, asub.due_date, asub.due_time, asub.grade, asub.file, asub.file_name FROM assignment_submissions AS asub LEFT JOIN users AS u ON asub.student_id = u.id WHERE asub.id = ?';

  $statement = $connection->prepare($command);
  $statement->bind_param('i', $submissionId);
  $statement->execute();
  $statement->bind_result(
    $assId,
    $name,
    $dateTimeSubmitted,
    $dueDate,
    $dueTime,
    $grade,
    $file,
    $fileName
  );

  if ($statement->fetch()) {

    $data['name'] = $name;
    $data['file'] = $file;
    $data['file_name'] = $assId . '_' . $fileName;

    if ($grade === null) {

      if ($dueDate === null) {
        $data['date_time_submitted'] = 'Publish First';
        $data['grade'] = '---';
      } elseif ($file !== null) {
        $data['date_time_submitted'] = date('M d, Y h:i A', strtotime($dateTimeSubmitted));
        $data['grade'] = '---';
      } elseif (Utilities::dateDiff($dueDate . ' ' . $dueTime) > 0) {
        $data['date_time_submitted'] = 'Pending';
        $data['grade'] = '---';
      } else {
        $data['date_time_submitted'] = 'Late';
        $data['grade'] = '---';
      }
    } else {

      $data['date_time_submitted'] = date('M d, Y h:i A', strtotime($dateTimeSubmitted));
      $data['grade'] = $grade . '%';
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
