<?php

require '../../connection.php';
require '../../utilities.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'GET'
  &&
  isset($_GET['type'],
  $_GET['quiz_id'],
  $_GET['user_id'],
  $_GET['version'])
) {

  $type = $_GET['type'];
  $quizId = $_GET['quiz_id'];
  $userId = $_GET['user_id'];
  $version = $_GET['version'];
  $data = [];

  if ($type === 'Student') {

    $command = 'SELECT q.title, qsub.score, qsub.date_time_assigned, qsub.due_date, qsub.due_time, q.version, (SELECT COUNT(*) FROM quiz_questions AS qq WHERE qq.quiz_id = q.id), (SELECT COUNT(*) FROM quiz_submissions AS qsub WHERE qsub.quiz_id = q.id AND qsub.score IS NOT NULL AND qsub.date_time_assigned IS NOT NULL), (SELECT COUNT(*) FROM quiz_submissions AS qsub WHERE qsub.quiz_id = q.id AND qsub.score IS NULL AND qsub.date_time_assigned IS NOT NULL) FROM quiz_submissions AS qsub LEFT JOIN quizzes AS q ON qsub.quiz_id = q.id WHERE q.id = ? AND qsub.student_id = ?';

    $statement = $connection->prepare($command);
    $statement->bind_param(
      'ii',
      $quizId,
      $userId
    );
  } else {

    $command = 'SELECT q.title, q.date_time_created, q.date_time_published, q.due_date, q.due_time, q.version, (SELECT COUNT(*) FROM quiz_questions AS qq WHERE qq.quiz_id = q.id), (SELECT COUNT(*) FROM quiz_submissions AS qsub WHERE qsub.quiz_id = q.id AND qsub.score IS NOT NULL AND qsub.date_time_assigned IS NOT NULL), (SELECT COUNT(*) FROM quiz_submissions AS qsub WHERE qsub.quiz_id = q.id AND qsub.score IS NULL AND qsub.date_time_assigned IS NOT NULL) FROM quizzes AS q WHERE q.id = ?';

    $statement = $connection->prepare($command);
    $statement->bind_param('i', $quizId);
  }

  $statement->execute();

  if ($type === 'Student') {

    $statement->bind_result(
      $title,
      $score,
      $dateTimePublished,
      $dueDate,
      $dueTime,
      $cVersion,
      $questionCount,
      $takerCount,
      $idleCount
    );

    if ($statement->fetch()) {

      if ($cVersion != $version) {

        $data['title'] = $title;
        $data['date_time_published'] = date('F d, Y h:i a', strtotime($dateTimePublished));
        $data['due_date'] = date('F d, Y h:i a', strtotime($dueDate . ' ' . $dueTime));

        if (Utilities::dateDiff($dueDate . ' ' . $dueTime) > 0 || $score != null) {

          if ($score !== null) {

            if (($score / $questionCount) >= .5) {

              $data['status'] = 'Passed (' . $score . '/' . $questionCount . ')';
              $data['status_color'] = '#31708f';
            } else {

              $data['status'] = 'Failed (' . $score . '/' . $questionCount . ')';
              $data['status_color'] = '#a94442';
            }

            $data['time_remaining'] = '';
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

        $data['version'] = $cVersion;

        $response = 'found';
      } else {

        if (Utilities::dateDiff($dueDate . ' ' . $dueTime) > 0 || $score != null) {

          if ($score !== null) {

            if (($score / $questionCount) >= .5) {

              $data['status'] = 'Passed (' . $score . '/' . $questionCount . ')';
              $data['status_color'] = '#31708f';
            } else {

              $data['status'] = 'Failed (' . $score . '/' . $questionCount . ')';
              $data['status_color'] = '#a94442';
            }

            $data['time_remaining'] = '';
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

        $response = 'same';
      }

      $data['question_count'] = $questionCount;
      $data['taker_count'] = $takerCount;
      $data['idle_count'] = $idleCount;
    } else {
      $response = 'nothing';
    }
  } else {

    $statement->bind_result(
      $title,
      $dateTimeCreated,
      $dateTimePublished,
      $dueDate,
      $dueTime,
      $cVersion,
      $questionCount,
      $takerCount,
      $idleCount
    );

    if ($statement->fetch()) {

      if ($cVersion != $version) {

        $data['title'] = $title;
        $data['date_time_created'] = date('F d, Y h:i a', strtotime($dateTimeCreated));

        if ($dateTimePublished === null) {

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

        $data['version'] = $cVersion;

        $response = 'found';
      } else {

        if ($dateTimePublished === null) {

          $data['time_remaining'] = '';
          $data['status'] = 'Unpublished';
          $data['status_color'] = '#c0c0c0';
        } else {

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

        $response = 'same';
      }

      $data['question_count'] = $questionCount;
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
