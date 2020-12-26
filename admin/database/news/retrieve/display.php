<?php

require '../../connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'GET'
  &&
  isset($_GET['method'])
) {

  switch ($_GET['method']) {

    case 'newer':

      $command = 'SELECT n.id, n.image, n.title, n.caption, n.date_time_posted, u.id, u.username FROM news AS n LEFT JOIN admins AS u ON n.admin_id = u.id WHERE n.id > ? ORDER BY n.id DESC LIMIT 3';

      $statement = $connection->prepare($command);
      $statement->bind_param('i', $_GET['news_id']);
      $statement->execute();

      break;

    case 'fresh':

      $command = 'SELECT n.id, n.image, n.title, n.caption, n.date_time_posted, u.id, u.username FROM news AS n LEFT JOIN admins AS u ON n.admin_id = u.id ORDER BY n.id DESC LIMIT 3';

      $statement = $connection->prepare($command);
      $statement->execute();

      break;

    case 'later':

      $command = 'SELECT n.id, n.image, n.title, n.caption, n.date_time_posted, u.id, u.username FROM news AS n LEFT JOIN admins AS u ON n.admin_id = u.id WHERE n.id < ? ORDER BY n.id DESC LIMIT 3';

      $statement = $connection->prepare($command);
      $statement->bind_param('i', $_GET['news_id']);
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
    $image,
    $title,
    $caption,
    $dateTimePosted,
    $adminId,
    $adminUsername
  );

  if ($statement->num_rows > 0) {

    while ($statement->fetch()) {

      $data['id'] = $id;
      $data['image'] = '../' . $image;
      $data['title'] = $title;
      $data['caption'] = $caption;

      $dateDiff = strtotime(date('Y-m-d H:i:s')) - strtotime($dateTimePosted);

      if ($dateDiff > 86400) {
        $data['date_time_posted'] = date('M d, Y h:i A', strtotime($dateTimePosted));
      } else if ($dateDiff > 7200) {
        $data['date_time_posted'] = intval($dateDiff / 3600) . ' hours ago';
      } else if ($dateDiff > 3600) {
        $data['date_time_posted'] = intval($dateDiff / 3600) . ' hour ago';
      } else if ($dateDiff > 120) {
        $data['date_time_posted'] = intval($dateDiff / 60) . ' minutes ago';
      } else if ($dateDiff > 60) {
        $data['date_time_posted'] = intval($dateDiff / 60) . ' minute ago';
      } else {
        $data['date_time_posted'] = 'Just Now!';
      }

      $data['admin_id'] = $adminId;
      $data['admin_username'] = $adminUsername;

      $news[] = $data;
    }

    $response = [
      'response' => 'found',
      'news' => $news
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
