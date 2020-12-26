<?php

require '../../connection.php';
require '../../ischool.php';

if ($_SERVER['REQUEST_METHOD'] = 'GET'
  &&
  isset($_GET['method'],
  $_GET['user_id'],
  $_GET['classroom_id'])
) {

  $method = $_GET['method'];
  $userId = $_GET['user_id'];
  $classroomId = $_GET['classroom_id'];
  $announcements = [];

  switch ($method) {

    case 'newer':

      if (!isset($_GET['ref_id'])) {

        $response = [
          'response' => 'unauthorized'
        ];

        die(json_encode($response));
      }

      $refId = $_GET['ref_id'];
      $command = "SELECT a.id, a.content, CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name), u.profile_picture, (SELECT COUNT(*) FROM announcement_likes AS al WHERE al.announcement_id = a.id), (SELECT COUNT(*) FROM announcement_comments AS ac WHERE ac.announcement_id = a.id), (SELECT COUNT(*) FROM announcement_likes AS al WHERE al.announcement_id = a.id AND user_id = ?), a.date_time_posted, a.version FROM announcements AS a LEFT JOIN classrooms AS cr ON a.classroom_id = cr.id LEFT JOIN users AS u ON cr.teacher_id = u.id WHERE a.classroom_id = ? AND a.id > ? ORDER BY id ASC";

      $statement = $connection->prepare($command);
      $statement->bind_param(
        'iii',
        $userId,
        $classroomId,
        $refId
      );
      $statement->execute();

      break;

    case 'fresh':

      $command = "SELECT a.id, a.content, CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name), u.profile_picture, (SELECT COUNT(*) FROM announcement_likes AS al WHERE al.announcement_id = a.id), (SELECT COUNT(*) FROM announcement_comments AS ac WHERE ac.announcement_id = a.id), (SELECT COUNT(*) FROM announcement_likes AS al WHERE al.announcement_id = a.id AND user_id = ?), a.date_time_posted, a.version FROM announcements AS a LEFT JOIN classrooms AS cr ON a.classroom_id = cr.id LEFT JOIN users AS u ON cr.teacher_id = u.id WHERE a.classroom_id = ? ORDER BY id DESC LIMIT 5";

      $statement = $connection->prepare($command);
      $statement->bind_param(
        'ii',
        $userId,
        $classroomId
      );
      $statement->execute();

      break;

    case 'later':

      if (!isset($_GET['ref_id'])) {

        $response = [
          'response' => 'unauthorized'
        ];

        die(json_encode($response));
      }

      $refId = $_GET['ref_id'];
      $command = "SELECT a.id, a.content, CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name), u.profile_picture, (SELECT COUNT(*) FROM announcement_likes AS al WHERE al.announcement_id = a.id), (SELECT COUNT(*) FROM announcement_comments AS ac WHERE ac.announcement_id = a.id), (SELECT COUNT(*) FROM announcement_likes AS al WHERE al.announcement_id = a.id AND user_id = ?), a.date_time_posted, a.version FROM announcements AS a LEFT JOIN classrooms AS cr ON a.classroom_id = cr.id LEFT JOIN users AS u ON cr.teacher_id = u.id WHERE a.classroom_id = ? AND a.id < ? ORDER BY id DESC LIMIT 5";

      $statement = $connection->prepare($command);
      $statement->bind_param(
        'iii',
        $userId,
        $classroomId,
        $refId
      );
      $statement->execute();

      break;
  }

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
    $version
  );

  while ($statement->fetch()) {

    $data['id'] = $id;
    $data['content'] = $content;
    $data['teacherName'] = $teacherName;
    $data['teacherImage'] = $teacherImage;
    $data['likeCount'] = $likeCount;
    $data['commentCount'] = $commentCount;
    $data['liked'] = $liked;
    $data['dateTime'] = date('M d, Y h:i a', strtotime($dateTime));
    $data['version'] = $version;

    $announcements[] = $data;
  }

  $annLength = count($announcements);

  for ($i = 0; $i < $annLength; $i++) {

    $announcements[$i]['comments'] = [];

    $command = "SELECT ac.id, ac.content, CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name), u.profile_picture, (SELECT COUNT(*) FROM announcement_comment_likes AS acl WHERE acl.announcement_comment_id = ac.id), (SELECT COUNT(*) FROM announcement_replies AS ar WHERE ar.announcement_comment_id = ac.id), (SELECT COUNT(*) FROM announcement_comment_likes AS acl WHERE acl.announcement_comment_id = ac.id AND user_id = ?), ac.date_time_commented, ac.version, u.id FROM announcement_comments AS ac LEFT JOIN users AS u ON ac.user_id = u.id WHERE ac.announcement_id = ?";

    $statement = $connection->prepare($command);
    $statement->bind_param(
      'ii',
      $userId,
      $announcements[$i]['id']
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

      $announcements[$i]['comments'][] = $data;
    }
  }

  for ($i = 0; $i < count($announcements); $i++) {

    for ($j = 0; $j < count($announcements[$i]['comments']); $j++) {

      $announcements[$i]['comments'][$j]['replies'] = [];

      $command = "SELECT ar.id, ar.content, CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name), u.profile_picture, (SELECT COUNT(*) FROM announcement_reply_likes AS arl WHERE arl.announcement_reply_id = ar.id), (SELECT COUNT(*) FROM announcement_reply_likes AS arl WHERE arl.announcement_reply_id = ar.id AND user_id = ?), ar.date_time_replied, ar.version, u.id FROM announcement_replies AS ar LEFT JOIN users AS u ON ar.user_id = u.id WHERE ar.announcement_comment_id = ?";

      $statement = $connection->prepare($command);
      $statement->bind_param(
        'ii',
        $userId,
        $announcements[$i]['comments'][$j]['id']
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

        $announcements[$i]['comments'][$j]['replies'][] = $data;
      }
    }
  }

  Ischool::updateNotifSeen(
    $connection,
    $userId,
    $classroomId,
    'announcements'
  );

  $response = [
    'response' => $announcements == null ? 'nothing' : 'found',
    'announcements' => $announcements
  ];
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
