<?php

require '../../connection.php';

if ($_SERVER['REQUEST_METHOD'] = 'GET'
  &&
  isset($_GET['user_id'],
  $_GET['comment_id'],
  $_GET['version'],
  $_GET['reply_ref_id'])
) {

  $userId = $_GET['user_id'];
  $commentId = $_GET['comment_id'];
  $givenVersion = $_GET['version'];
  $replyRefId = $_GET['reply_ref_id'];

  $info = [];

  $command = "SELECT ac.id, ac.content, CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name), u.profile_picture, (SELECT COUNT(*) FROM announcement_comment_likes AS acl WHERE acl.announcement_comment_id = ac.id), (SELECT COUNT(*) FROM announcement_replies AS ar WHERE ar.announcement_comment_id = ac.id), (SELECT COUNT(*) FROM announcement_comment_likes AS acl WHERE acl.announcement_comment_id = ac.id AND user_id = ?), ac.date_time_commented, ac.version FROM announcement_comments AS ac LEFT JOIN users AS u ON ac.user_id = u.id WHERE ac.id = ?";

  $statement = $connection->prepare($command);
  $statement->bind_param(
    'ii',
    $userId,
    $commentId
  );
  $statement->execute();
  $statement->store_result();
  $statement->bind_result(
    $id,
    $content,
    $name,
    $image,
    $likeCount,
    $replyCount,
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
    $data['replyCount'] = $replyCount;
    $data['liked'] = $liked;
    $data['dateTime'] = date('M d, Y h:i a', strtotime($dateTime));
    $data['version'] = $currentVersion;

    $info = $data;
  } else {

    $info['id'] = $id;
    $info['likeCount'] = $likeCount;
    $info['replyCount'] = $replyCount;
    $info['liked'] = $liked;
  }

  $info['replies'] = [];

  $command = "SELECT ar.id, ar.content, CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name), u.profile_picture, (SELECT COUNT(*) FROM announcement_reply_likes AS arl WHERE arl.announcement_reply_id = ar.id), (SELECT COUNT(*) FROM announcement_reply_likes AS arl WHERE arl.announcement_reply_id = ar.id AND user_id = ?), ar.date_time_replied, ar.version, u.id FROM announcement_replies AS ar LEFT JOIN users AS u ON ar.user_id = u.id WHERE ar.announcement_comment_id = ? AND ar.id > ?";

  $statement = $connection->prepare($command);
  $statement->bind_param(
    'iii',
    $userId,
    $info['id'],
    $replyRefId
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
    $version,
    $ownerId
  );

  while ($statement->fetch()) {

    $data = [];

    $data['id'] = $id;
    $data['content'] = $content;
    $data['name'] = $name;
    $data['image'] = $image;
    $data['likeCount'] = $likeCount;
    $data['liked'] = $liked;
    $data['dateTime'] = date('M d, Y h:i a', strtotime($dateTime));
    $data['version'] = $version;
    $data['isOwner'] = $ownerId == $userId;

    $info['replies'][] = $data;
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
