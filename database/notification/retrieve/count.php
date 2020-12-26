<?php

require '../../connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'GET'
  &&
  isset($_GET['user_id'])
) {

  $userId = $_GET['user_id'];
  $data = null;

  $command = "SELECT (SELECT COUNT(*) FROM messages WHERE id IN (SELECT MAX(id) FROM messages WHERE owner_id = ? AND date_time_received IS NULL GROUP BY other_id)), (SELECT COUNT(*) FROM group_chat_messages WHERE id IN (SELECT MAX(id) FROM group_chat_messages WHERE owner_id = ? AND date_time_received IS NULL GROUP BY group_chat_id))";
  $statement = $connection->prepare($command);
  $statement->bind_param('ii', $userId, $userId);
  $statement->execute();
  $statement->bind_result($count1, $count2);

  if ($statement->fetch()) {
    $data['mess'] = $count1 + $count2;
  }

  $statement->close();

  $command = "SELECT (SELECT COUNT(*) FROM notifications WHERE user_id = ? AND received = 0 AND type IN('accept_request', 'decline_request', 'cr_delete', 'cr_change_name', 'cr_change_date', 'cr_change_desc', 'remove_student', 'added_student', 'left_student', 'removed_student', 'new_announcement', 'new_assignment', 'cancel_assignment', 'delete_assignment', 'rate_assignment', 'resubmit_assignment', 'new_quiz', 'cancel_quiz', 'delete_quiz', 'retake_quiz', 'new_material')), (SELECT COUNT(*) FROM (SELECT * FROM notifications WHERE type = 'new_student' AND user_id = ? AND received = 0 GROUP BY classroom_id,DATE(date_time_did)) AS x), (SELECT COUNT(*) FROM (SELECT * FROM notifications  WHERE type = 'new_request' AND received = 0 AND user_id = ? GROUP BY classroom_id) AS x), (SELECT COUNT(*) FROM (SELECT * FROM notifications WHERE type IN ('new_comment', 'new_reply', 'new_ann_like', 'new_com_like', 'new_rep_like', 'submit_assignment', 'take_quiz') AND user_id = ? AND received = 0 GROUP BY source_id,type) AS x)";
  $statement = $connection->prepare($command);
  $statement->bind_param(
    'iiii',
    $userId,
    $userId,
    $userId,
    $userId
  );
  $statement->execute();
  $statement->bind_result(
    $count1,
    $count2,
    $count3,
    $count4
  );

  if ($statement->fetch()) {
    $data['notif'] = $count1 + $count2 + $count3 + $count4;
  }

  $response = [
    'response' => 'found',
    'count' => $data
  ];
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
