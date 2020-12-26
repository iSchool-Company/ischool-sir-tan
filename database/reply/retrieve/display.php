<?php

require '../../connection.php';

if ($_SERVER['REQUEST_METHOD'] = 'GET'
  &&
  isset($_GET['user_id'],
  $_GET['reply_id'],
  $_GET['version'])
) {

  $userId = $_GET['user_id'];
  $replyId = $_GET['reply_id'];
  $givenVersion = $_GET['version'];

  $info = [];

  $command = "SELECT ar.id, ar.content, CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name), u.profile_picture, (SELECT COUNT(*) FROM announcement_reply_likes AS arl WHERE arl.announcement_reply_id = ar.id), (SELECT COUNT(*) FROM announcement_reply_likes AS arl WHERE arl.announcement_reply_id = ar.id AND user_id = ?), ar.date_time_replied, ar.version FROM announcement_replies AS ar LEFT JOIN users AS u ON ar.user_id = u.id WHERE ar.id = ?";

  $statement = $connection->prepare($command);
  $statement->bind_param(
    'ii',
    $userId,
    $replyId
  );
  $statement->execute();
  $statement->store_result();
  $statement->bind_result(
    $id,
    $content,
    $name,
    $image,
    $likeCount,
    $liked,
    $dateTime,
    $currentVersion
  );

  if ($statement->fetch() && $givenVersion != $currentVersion) {

    $data['id'] = $id;
    $data['content'] = $content;
    $data['name'] = $name;
    $data['image'] = $image;
    $data['likeCount'] = $likeCount;
    $data['liked'] = $liked;
    $data['dateTime'] = date('M d, Y h:i a', strtotime($dateTime));
    $data['version'] = $currentVersion;

    $info = $data;
  } else {

    $info['id'] = $id;
    $info['likeCount'] = $likeCount;
    $info['liked'] = $liked;
  }

  $response = [
    'response' => $info['id'] == null ? 'nothing' : ($givenVersion == $currentVersion ? 'same' : 'found'),
    'info' => $info
  ];
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
