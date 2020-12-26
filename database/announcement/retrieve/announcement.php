<?php

require '../../connection.php';

if ($_SERVER['REQUEST_METHOD'] = 'GET'
  &&
  isset($_GET['user_id'],
  $_GET['announcement_id'],
  $_GET['version'],
  $_GET['comment_ref_id'])
) {

  $userId = $_GET['user_id'];
  $announcementId = $_GET['announcement_id'];
  $givenVersion = $_GET['version'];
  $commentRefId = $_GET['comment_ref_id'];

  $info = [];

  $command = "SELECT a.id, a.content, CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name), u.profile_picture, (SELECT COUNT(*) FROM announcement_likes AS al WHERE al.announcement_id = a.id), (SELECT COUNT(*) FROM announcement_comments AS ac WHERE ac.announcement_id = a.id), (SELECT COUNT(*) FROM announcement_likes AS al WHERE al.announcement_id = a.id AND user_id = ?), a.date_time_posted, a.version FROM announcements AS a LEFT JOIN classrooms AS cr ON a.classroom_id = cr.id LEFT JOIN users AS u ON cr.teacher_id = u.id WHERE a.id = ?";

  $statement = $connection->prepare($command);
  $statement->bind_param(
    'ii',
    $userId,
    $announcementId
  );
  $statement->execute();
  $statement->store_result();
  $statement->bind_result(
    $id,
    $content,
    $teacherName,
    $teacherImage,
    $likeCount,
    $commentCount,
    $liked,
    $dateTime,
    $currentVersion
  );

  if ($statement->fetch() && $givenVersion != $currentVersion) {

    $data['id'] = $id;
    $data['content'] = $content;
    $data['teacherName'] = $teacherName;
    $data['teacherImage'] = $teacherImage;
    $data['likeCount'] = $likeCount;
    $data['commentCount'] = $commentCount;
    $data['liked'] = $liked;
    $data['dateTime'] = date('M d, Y h:i a', strtotime($dateTime));
    $data['version'] = $currentVersion;

    $info = $data;
  } else {

    $info['id'] = $id;
    $info['likeCount'] = $likeCount;
    $info['commentCount'] = $commentCount;
    $info['liked'] = $liked;
  }

  $info['comments'] = [];

  $command = "SELECT ac.id, ac.content, CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name), u.profile_picture, (SELECT COUNT(*) FROM announcement_comment_likes AS acl WHERE acl.announcement_comment_id = ac.id), (SELECT COUNT(*) FROM announcement_replies AS ar WHERE ar.announcement_comment_id = ac.id), (SELECT COUNT(*) FROM announcement_comment_likes AS acl WHERE acl.announcement_comment_id = ac.id AND user_id = ?), ac.date_time_commented, ac.version, u.id FROM announcement_comments AS ac LEFT JOIN users AS u ON ac.user_id = u.id WHERE ac.announcement_id = ? AND ac.id > ?";

  $statement = $connection->prepare($command);
  $statement->bind_param(
    'iii',
    $userId,
    $info['id'],
    $commentRefId
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
    $data['replyCount'] = $replyCount;
    $data['liked'] = $liked;
    $data['dateTime'] = date('M d, Y h:i a', strtotime($dateTime));
    $data['version'] = $version;
    $data['isOwner'] = $ownerId == $userId;

    $info['comments'][] = $data;
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
