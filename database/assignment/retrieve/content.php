<?php

require '../../connection.php';
require '../../utilities.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'GET'
  &&
  isset($_GET['type'],
  $_GET['assignment_id'],
  $_GET['user_id'],
  $_GET['version'])
) {

  $type = $_GET['type'];
  $assignmentId = $_GET['assignment_id'];
  $userId = $_GET['user_id'];
  $version = $_GET['version'];
  $data = [];

  if ($type === 'Student') {

    $command = 'SELECT a.title, a.description, a.file, a.file_name, asub.file, asub.grade, a.date_time_published, asub.due_date, asub.due_time, a.version, (SELECT COUNT(*) FROM assignment_submissions AS asub WHERE asub.assignment_id = a.id AND asub.file IS NOT NULL AND asub.date_time_assigned IS NOT NULL), (SELECT COUNT(*) FROM assignment_submissions AS asub WHERE asub.assignment_id = a.id AND asub.file IS NULL AND asub.date_time_assigned IS NOT NULL) FROM assignment_submissions AS asub LEFT JOIN assignments AS a ON asub.assignment_id = a.id WHERE a.id = ? AND asub.student_id = ?';

    $statement = $connection->prepare($command);
    $statement->bind_param(
      'ii',
      $assignmentId,
      $userId
    );
  } else {

    $command = 'SELECT a.title, a.description, a.date_time_created, a.date_time_published, a.due_date, a.due_time, a.version, a.file, a.file_name, (SELECT COUNT(*) FROM assignment_submissions AS asub WHERE asub.assignment_id = a.id AND asub.file IS NOT NULL AND asub.date_time_assigned IS NOT NULL), (SELECT COUNT(*) FROM assignment_submissions AS asub WHERE asub.assignment_id = a.id AND asub.file IS NULL AND asub.date_time_assigned IS NOT NULL) FROM assignments AS a WHERE a.id = ? AND a.deleted = 0';

    $statement = $connection->prepare($command);
    $statement->bind_param('i', $assignmentId);
  }

  $statement->execute();

  if ($type === 'Student') {

    $statement->bind_result(
      $title,
      $description,
      $file,
      $fileName,
      $sFile,
      $grade,
      $dateTimePublished,
      $dueDate,
      $dueTime,
      $cVersion,
      $takerCount,
      $idleCount
    );

    if ($statement->fetch()) {

      if ($cVersion != $version) {

        $data['title'] = $title;
        $data['description'] = $description;
        $data['date_time_published'] = date('F d, Y h:i a', strtotime($dateTimePublished));
        $data['due_date'] = date('F d, Y h:i a', strtotime($dueDate . ' ' . $dueTime));
        $data['file'] = $file;
        $data['file_name'] = $fileName;
        $data['version'] = $cVersion;

        $response = 'found';
      } else {

        $response = 'same';
      }

      if (Utilities::dateDiff($dueDate . ' ' . $dueTime) > 0 || $sFile !== null) {

        if ($grade !== null) {

          $data['time_remaining'] = '';
          $data['status'] = 'Graded(' . $grade . '%)';
          $data['status_color'] = '#31708f';
        } elseif ($sFile !== null) {

          $data['time_remaining'] = '';
          $data['status'] = 'Submitted';
          $data['status_color'] = '#337ab7';
        } else {

          $data['time_remaining'] = Utilities::trWeek($dueDate . ' ' . $dueTime);
          $data['status'] = 'On Going';
          $data['status_color'] = '#3c763d';
        }
      } else {

        $data['time_remaining'] = '';
        $data['status'] = 'Late';
        $data['status_color'] = '#a94442';
      }

      $data['taker_count'] = $takerCount;
      $data['idle_count'] = $idleCount;
    } else {

      $response = 'nothing';
    }
  } else {

    $statement->bind_result(
      $title,
      $description,
      $dateTimeCreated,
      $dateTimePublished,
      $dueDate,
      $dueTime,
      $cVersion,
      $file,
      $fileName,
      $takerCount,
      $idleCount
    );

    if ($statement->fetch()) {

      if ($cVersion != $version) {

        $data['title'] = $title;
        $data['description'] = $description;
        $data['date_time_created'] = date('F d, Y h:i a', strtotime($dateTimeCreated));
        $data['file'] = $file;
        $data['file_name'] = $fileName;
        $data['version'] = $cVersion;

        $response = 'found';
      } else {

        $response = 'same';
      }

      if ($dateTimePublished == null) {

        $data['date_time_published'] = 'Not yet published';
        $data['due_date'] = '---';
        $data['time_remaining'] = '';
        $data['status'] = 'Unpublished';
        $data['status_color'] = '#c0c0c0';
      } else {

        $data['date_time_published'] = date('F d, Y h:i a', strtotime($dateTimePublished));
        $data['due_date'] = date('F d, Y h:i a', strtotime($dueDate . ' ' . $dueTime));

        if (Utilities::dateDiff($dueDate . ' ' . $dueTime) > 0) {

          $data['time_remaining'] = Utilities::trWeek($dueDate . ' ' . $dueTime);
          $data['status'] = 'Published';
          $data['status_color'] = '#3c763d';
        } else {

          $data['time_remaining'] = '';
          $data['status'] = 'Closed';
          $data['status_color'] = '#a94442';
        }
      }

      $data['taker_count'] = $takerCount;
      $data['idle_count'] = $idleCount;
    } else {
      $response = 'nothing';
    }
  }

  $response = [
    'response' => $response,
    'info' => $data
  ];
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
