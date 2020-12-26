<?php

require '../../connection.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'GET'
  &&
  isset($_GET['news_id'])
) {

  $newsId = $_GET['news_id'];

  $command = 'SELECT image, title, caption, date_time_posted FROM news WHERE id = ?';

  $statement = $connection->prepare($command);
  $statement->bind_param('i', $newsId);
  $statement->execute();
  $statement->store_result();
  $statement->bind_result(
    $image,
    $title,
    $caption,
    $dateTimePosted
  );

  if ($statement->fetch()) {

    $data['image'] = $image;
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

    $response = [
      'response' => 'found',
      'info' => $data
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
