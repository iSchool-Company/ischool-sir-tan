<?php

require '../../connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'GET'
  &&
  isset($_GET['method'],
  $_GET['user_id'])
) {

  $userId = $_GET['user_id'];

  switch ($_GET['method']) {

    case 'newer':

      $refId = $_GET['ref_id'];

      $command = "SELECT * FROM ("
        . "SELECT MAX(n.id) AS xid, n.source_id, CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name) AS doer_name, n.classroom_id, CONCAT(cr.class, ' - ', cr.subject) AS cr_name, n.type, MAX(n.date_time_did), n.received, n.seen, COUNT(*) FROM notifications AS n LEFT JOIN users AS u ON n.doer_id = u.id LEFT JOIN classrooms AS cr ON n.classroom_id = cr.id WHERE n.type = 'new_student' AND n.user_id = ? GROUP BY n.classroom_id,DATE(n.date_time_did) UNION "
        . "SELECT MAX(n.id) AS xid, n.source_id, CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name) AS doer_name, n.classroom_id, CONCAT(cr.class, ' - ', cr.subject) AS cr_name, n.type, MAX(n.date_time_did), n.received, n.seen, COUNT(*) FROM notifications AS n LEFT JOIN users AS u ON n.doer_id = u.id LEFT JOIN classrooms AS cr ON n.classroom_id = cr.id WHERE n.type = 'new_request' AND n.user_id = ? GROUP BY n.classroom_id UNION "
        . "SELECT n.id AS xid, n.source_id, CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name) AS doer_name, n.classroom_id, CONCAT(cr.class, ' - ', cr.subject) AS cr_name, n.type, n.date_time_did, n.received, n.seen, 0 FROM notifications AS n LEFT JOIN users AS u ON n.doer_id = u.id LEFT JOIN classrooms AS cr ON n.classroom_id = cr.id WHERE n.type IN('accept_request', 'decline_request', 'cr_delete', 'cr_change_name', 'cr_change_date', 'cr_change_desc', 'remove_student', 'added_student', 'left_student', 'removed_student', 'new_announcement', 'new_assignment', 'cancel_assignment', 'delete_assignment', 'rate_assignment', 'resubmit_assignment', 'new_quiz', 'cancel_quiz', 'delete_quiz', 'retake_quiz', 'new_material') AND n.user_id = ? UNION "
        . "SELECT n.id AS xid, n.source_id, CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name) AS doer_name, n.classroom_id, CONCAT(cr.class, ' - ', cr.subject) AS cr_name, n.type, n.date_time_did, n.received, n.seen, COUNT(DISTINCT n.doer_id) FROM notifications AS n LEFT JOIN users AS u ON n.doer_id = u.id LEFT JOIN classrooms AS cr ON n.classroom_id = cr.id WHERE n.type = 'new_comment' AND n.user_id = ? GROUP BY n.source_id UNION "
        . "SELECT MAX(n.id) AS xid, n.source_id, CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name) AS doer_name, n.classroom_id, CONCAT(cr.class, ' - ', cr.subject) AS cr_name, n.type, MAX(n.date_time_did), n.received, n.seen, COUNT(DISTINCT n.doer_id) - 1 FROM notifications AS n LEFT JOIN users AS u ON n.doer_id = u.id LEFT JOIN classrooms AS cr ON n.classroom_id = cr.id WHERE n.type IN ('new_comment', 'new_reply', 'new_ann_like', 'new_com_like', 'new_rep_like') AND n.user_id = ? GROUP BY n.source_id,n.type UNION "
        . "SELECT MAX(n.id) AS xid, n.source_id, CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name) AS doer_name, n.classroom_id, CONCAT(cr.class, ' - ', cr.subject) AS cr_name, n.type, MAX(n.date_time_did), n.received, n.seen, COUNT(*) - 1 FROM notifications AS n LEFT JOIN users AS u ON n.doer_id = u.id LEFT JOIN classrooms AS cr ON n.classroom_id = cr.id WHERE n.type IN ('submit_assignment', 'take_quiz') AND n.user_id = ? GROUP BY n.classroom_id,n.source_id,n.type"
        . ") AS x WHERE xid > ? ORDER BY xid DESC LIMIT 5";
      $statement = $connection->prepare($command);
      $statement->bind_param(
        'iiiiiii',
        $userId,
        $userId,
        $userId,
        $userId,
        $userId,
        $userId,
        $refId
      );
      $statement->execute();

      break;

    case 'fresh':

      $command = "SELECT * FROM ("
        . "SELECT MAX(n.id) AS xid, n.source_id, CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name) AS doer_name, n.classroom_id, CONCAT(cr.class, ' - ', cr.subject) AS cr_name, n.type, MAX(n.date_time_did), n.received, n.seen, COUNT(*) FROM notifications AS n LEFT JOIN users AS u ON n.doer_id = u.id LEFT JOIN classrooms AS cr ON n.classroom_id = cr.id WHERE n.type = 'new_student' AND n.user_id = ? GROUP BY n.classroom_id,DATE(n.date_time_did) UNION "
        . "SELECT MAX(n.id) AS xid, n.source_id, CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name) AS doer_name, n.classroom_id, CONCAT(cr.class, ' - ', cr.subject) AS cr_name, n.type, MAX(n.date_time_did), n.received, n.seen, COUNT(*) FROM notifications AS n LEFT JOIN users AS u ON n.doer_id = u.id LEFT JOIN classrooms AS cr ON n.classroom_id = cr.id WHERE n.type = 'new_request' AND n.user_id = ? GROUP BY n.classroom_id UNION "
        . "SELECT n.id AS xid, n.source_id, CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name) AS doer_name, n.classroom_id, CONCAT(cr.class, ' - ', cr.subject) AS cr_name, n.type, n.date_time_did, n.received, n.seen, 0 FROM notifications AS n LEFT JOIN users AS u ON n.doer_id = u.id LEFT JOIN classrooms AS cr ON n.classroom_id = cr.id WHERE n.type IN('accept_request', 'decline_request', 'cr_delete', 'cr_change_name', 'cr_change_date', 'cr_change_desc', 'remove_student', 'added_student', 'left_student', 'removed_student', 'new_announcement', 'new_assignment', 'cancel_assignment', 'delete_assignment', 'rate_assignment', 'resubmit_assignment', 'new_quiz', 'cancel_quiz', 'delete_quiz', 'retake_quiz', 'new_material') AND n.user_id = ? UNION "
        . "SELECT MAX(n.id) AS xid, n.source_id, CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name) AS doer_name, n.classroom_id, CONCAT(cr.class, ' - ', cr.subject) AS cr_name, n.type, MAX(n.date_time_did), n.received, n.seen, COUNT(DISTINCT n.doer_id) - 1 FROM notifications AS n LEFT JOIN users AS u ON n.doer_id = u.id LEFT JOIN classrooms AS cr ON n.classroom_id = cr.id WHERE n.type IN ('new_comment', 'new_reply', 'new_ann_like', 'new_com_like', 'new_rep_like') AND n.user_id = ? GROUP BY n.source_id,n.type UNION "
        . "SELECT MAX(n.id) AS xid, n.source_id, CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name) AS doer_name, n.classroom_id, CONCAT(cr.class, ' - ', cr.subject) AS cr_name, n.type, MAX(n.date_time_did), n.received, n.seen, COUNT(*) - 1 FROM notifications AS n LEFT JOIN users AS u ON n.doer_id = u.id LEFT JOIN classrooms AS cr ON n.classroom_id = cr.id WHERE n.type IN ('submit_assignment', 'take_quiz') AND n.user_id = ? GROUP BY n.classroom_id,n.source_id,n.type"
        . ") AS x ORDER BY xid DESC LIMIT 5";

      $statement = $connection->prepare($command);
      $statement->bind_param(
        'iiiii',
        $userId,
        $userId,
        $userId,
        $userId,
        $userId
      );
      $statement->execute();

      break;

    case 'later':

      $refId = $_GET['ref_id'];

      $command = "SELECT * FROM ("
        . "SELECT MAX(n.id) AS xid, n.source_id, CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name) AS doer_name, n.classroom_id, CONCAT(cr.class, ' - ', cr.subject) AS cr_name, n.type, MAX(n.date_time_did), n.received, n.seen, COUNT(*) FROM notifications AS n LEFT JOIN users AS u ON n.doer_id = u.id LEFT JOIN classrooms AS cr ON n.classroom_id = cr.id WHERE n.type = 'new_student' AND n.user_id = ? GROUP BY n.classroom_id,DATE(n.date_time_did) UNION "
        . "SELECT MAX(n.id) AS xid, n.source_id, CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name) AS doer_name, n.classroom_id, CONCAT(cr.class, ' - ', cr.subject) AS cr_name, n.type, MAX(n.date_time_did), n.received, n.seen, COUNT(*) FROM notifications AS n LEFT JOIN users AS u ON n.doer_id = u.id LEFT JOIN classrooms AS cr ON n.classroom_id = cr.id WHERE n.type = 'new_request' AND n.user_id = ? GROUP BY n.classroom_id UNION "
        . "SELECT n.id AS xid, n.source_id, CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name) AS doer_name, n.classroom_id, CONCAT(cr.class, ' - ', cr.subject) AS cr_name, n.type, n.date_time_did, n.received, n.seen, 0 FROM notifications AS n LEFT JOIN users AS u ON n.doer_id = u.id LEFT JOIN classrooms AS cr ON n.classroom_id = cr.id WHERE n.type IN('accept_request', 'decline_request', 'cr_delete', 'cr_change_name', 'cr_change_date', 'cr_change_desc', 'remove_student', 'added_student', 'left_student', 'removed_student', 'new_announcement', 'new_assignment', 'cancel_assignment', 'delete_assignment', 'rate_assignment', 'resubmit_assignment', 'new_quiz', 'cancel_quiz', 'delete_quiz', 'retake_quiz', 'new_material') AND n.user_id = ? UNION "
        . "SELECT MAX(n.id) AS xid, n.source_id, CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name) AS doer_name, n.classroom_id, CONCAT(cr.class, ' - ', cr.subject) AS cr_name, n.type, MAX(n.date_time_did), n.received, n.seen, COUNT(DISTINCT n.doer_id) - 1 FROM notifications AS n LEFT JOIN users AS u ON n.doer_id = u.id LEFT JOIN classrooms AS cr ON n.classroom_id = cr.id WHERE n.type IN ('new_comment', 'new_reply', 'new_ann_like', 'new_com_like', 'new_rep_like') AND n.user_id = ? GROUP BY n.source_id,n.type UNION "
        . "SELECT MAX(n.id) AS xid, n.source_id, CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name) AS doer_name, n.classroom_id, CONCAT(cr.class, ' - ', cr.subject) AS cr_name, n.type, MAX(n.date_time_did), n.received, n.seen, COUNT(*) - 1 FROM notifications AS n LEFT JOIN users AS u ON n.doer_id = u.id LEFT JOIN classrooms AS cr ON n.classroom_id = cr.id WHERE n.type IN ('submit_assignment', 'take_quiz') AND n.user_id = ? GROUP BY n.classroom_id,n.source_id,n.type"
        . ") AS x WHERE xid < ? ORDER BY xid DESC LIMIT 5";
      $statement = $connection->prepare($command);
      $statement->bind_param(
        'iiiiii',
        $userId,
        $userId,
        $userId,
        $userId,
        $userId,
        $refId
      );
      $statement->execute();

      break;

    default:

      $response = [
        'response' => 'error'
      ];

      die(json_encode($response));
  }

  $statement->store_result();
  $statement->bind_result(
    $id,
    $sourceId,
    $name,
    $classroomId,
    $classroom,
    $type,
    $dateTimeDid,
    $received,
    $seen,
    $count
  );

  if ($statement->num_rows > 0) {

    while ($statement->fetch()) {

      $data['id'] = $id;
      $data['source_id'] = $sourceId;
      $data['name'] = $name;
      $data['classroom_id'] = $classroomId;
      $data['classroom'] = $classroom;
      $data['type'] = $type;

      $dateDiff = strtotime(date('Y-m-d H:i:s')) - strtotime($dateTimeDid);

      if ($dateDiff > 86400) {
        $data['date_time_did'] = date('M d, Y h:i A', strtotime($dateTimeDid));
      } else if ($dateDiff > 7200) {
        $data['date_time_did'] = intval($dateDiff / 3600) . ' hours ago';
      } else if ($dateDiff > 3600) {
        $data['date_time_did'] = intval($dateDiff / 3600) . ' hour ago';
      } else if ($dateDiff > 120) {
        $data['date_time_did'] = intval($dateDiff / 60) . ' minutes ago';
      } else if ($dateDiff > 60) {
        $data['date_time_did'] = intval($dateDiff / 60) . ' minute ago';
      } else {
        $data['date_time_did'] = 'Just Now!';
      }

      $data['received'] = $received;
      $data['seen'] = $seen;
      $data['count'] = $count;

      $notifs[] = $data;
    }

    $statement->close();

    for ($i = 0; $i < count($notifs); $i++) {

      switch ($notifs[$i]['type']) {

        case 'remove_student':

          $command = "SELECT CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name) FROM notifications AS n LEFT JOIN users AS u ON n.source_id = u.id WHERE n.id = ?";
          $statement = $connection->prepare($command);
          $statement->bind_param('i', $notifs[$i]['id']);
          $statement->execute();
          $statement->bind_result($name);
          $statement->fetch();

          $notifs[$i]['other_name'] = $name;

          $statement->close();

          break;

        case 'new_comment':
        case 'new_reply':
        case 'new_ann_like':
        case 'new_com_like':
        case 'new_rep_like':
        case 'submit_assignment':
        case 'take_quiz':

          $command = "SELECT CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name), n.received, n.seen FROM notifications AS n LEFT JOIN users AS u ON n.doer_id = u.id WHERE n.id = ?";
          $statement = $connection->prepare($command);
          $statement->bind_param('i', $notifs[$i]['id']);
          $statement->execute();
          $statement->bind_result(
            $name,
            $received,
            $seen
          );
          $statement->fetch();

          $notifs[$i]['name'] = $name;
          $notifs[$i]['received'] = $received;
          $notifs[$i]['seen'] = $seen;

          $statement->close();

          break;
      }

      switch ($notifs[$i]['type']) {

        case 'new_assignment':
        case 'cancel_assignment':
        case 'delete_assignment':
        case 'submit_assignment':
        case 'rate_assignment':
        case 'resubmit_assignment':

          $command = "SELECT title FROM assignments WHERE id = ?";
          $statement = $connection->prepare($command);
          $statement->bind_param('i', $notifs[$i]['source_id']);
          $statement->execute();
          $statement->bind_result($title);
          $statement->fetch();

          $notifs[$i]['title'] = $title;

          $statement->close();

          break;

        case 'new_quiz':
        case 'cancel_quiz':
        case 'delete_quiz':
        case 'take_quiz':
        case 'retake_quiz':

          $command = "SELECT title FROM quizzes WHERE id = ?";
          $statement = $connection->prepare($command);
          $statement->bind_param('i', $notifs[$i]['source_id']);
          $statement->execute();
          $statement->bind_result($title);
          $statement->fetch();

          $notifs[$i]['title'] = $title;

          $statement->close();

          break;
      }
    }

    $response = [
      'response' => 'found',
      'notifs' => $notifs
    ];
  } else {

    $response = [
      'response' => 'nothing'
    ];
  }
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
