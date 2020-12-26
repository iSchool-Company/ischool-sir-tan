<?php

require '../../connection.php';
require '../../ischool.php';
require '../../utilities.php';

if (
  $_SERVER['REQUEST_METHOD'] === 'GET'
  &&
  isset($_GET['user_type'],
  $_GET['user_id'])
) {

  $type = $_GET['user_type'];
  $userId = $_GET['user_id'];
  $classrooms = [];

  if ($type === 'Student') {

    $command = "SELECT cr.id, CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name), u.profile_picture, cr.class, cr.subject, cr.is_deleted, csd.pending, cr.date_time_created, cr.date_end, (SELECT COUNT(*) FROM classroom_student_designation AS csd WHERE csd.classroom_id = cr.id), (SELECT COUNT(*) FROM announcements AS ann WHERE ann.classroom_id = cr.id), (SELECT COUNT(*) FROM assignments AS ass WHERE ass.classroom_id = cr.id AND ass.deleted = 0), (SELECT COUNT(*) FROM quizzes AS qz WHERE qz.classroom_id = cr.id AND qz.deleted = 0), (SELECT COUNT(*) FROM materials AS mat WHERE mat.classroom_id = cr.id) FROM classroom_student_designation AS csd LEFT JOIN classrooms AS cr ON csd.classroom_id = cr.id LEFT JOIN users AS u ON cr.teacher_id = u.id WHERE csd.student_id = ? ORDER BY cr.class, cr.subject, u.last_name, cr.date_end ASC";

    $statement = $connection->prepare($command);
    $statement->bind_param('i', $userId);
    $statement->execute();
    $statement->store_result();
    $statement->bind_result(
      $classroomId,
      $teacherName,
      $teacherImage,
      $className,
      $subjectName,
      $isDeleted,
      $pending,
      $dateCreated,
      $endDate,
      $stdCount,
      $annCount,
      $assCount,
      $qzCount,
      $matCount
    );

    while ($statement->fetch()) {

      $data['classroom_id'] = $classroomId;
      $data['teacher_name'] = $teacherName;
      $data['teacher_image'] = $teacherImage;
      $data['class_name'] = $className;
      $data['subject_name'] = $subjectName;

      if ($isDeleted || date('Y-m-d', strtotime($endDate)) < date('Y-m-d')) {

        $data['status'] = 'Archived';
        $data['status_color'] = '#c0c0c0';
        $data['time_remaining'] = '';
      } else if ($pending) {

        $data['status'] = 'Pending';
        $data['status_color'] = '#8a6d3b';
        $data['time_remaining'] = '';
      } else {

        $data['status'] = 'Active';
        $data['status_color'] = '#3c763d';
        $data['time_remaining'] = Utilities::trWeek($endDate);
      }

      $data['date_created'] = date('F d, Y h:i a', strtotime($dateCreated));
      $data['end_date'] = date('F d, Y', strtotime($endDate));
      $data['count']['std'] = $stdCount;
      $data['count']['ann'] = $annCount;
      $data['count']['ass'] = $assCount;
      $data['count']['qz'] = $qzCount;
      $data['count']['mat'] = $matCount;

      $classrooms[] = $data;
    }
  } else if ($type === 'Teacher') {

    $command = "SELECT cr.id, cr.class, cr.subject, cr.date_time_created, cr.date_end, (SELECT COUNT(*) FROM classroom_student_designation AS csd WHERE csd.classroom_id = cr.id AND csd.pending = 0), (SELECT COUNT(*) FROM announcements AS ann WHERE ann.classroom_id = cr.id), (SELECT COUNT(*) FROM assignments AS ass WHERE ass.classroom_id = cr.id AND ass.deleted = 0), (SELECT COUNT(*) FROM quizzes AS qz WHERE qz.classroom_id = cr.id AND qz.deleted = 0), (SELECT COUNT(*) FROM materials AS mat WHERE mat.classroom_id = cr.id) FROM classrooms AS cr WHERE cr.teacher_id = ? AND cr.is_deleted = 0 ORDER BY cr.class, cr.subject, cr.date_end ASC";

    $statement = $connection->prepare($command);
    $statement->bind_param('i', $userId);
    $statement->execute();
    $statement->store_result();
    $statement->bind_result(
      $classroomId,
      $className,
      $subjectName,
      $dateCreated,
      $endDate,
      $stdCount,
      $annCount,
      $assCount,
      $qzCount,
      $matCount
    );

    while ($statement->fetch()) {

      $data['classroom_id'] = $classroomId;
      $data['class_name'] = $className;
      $data['subject_name'] = $subjectName;

      if (strtotime($endDate) < strtotime(date('Y-m-d'))) {

        $data['status'] = 'Archived';
        $data['status_color'] = '#c0c0c0';
        $data['time_remaining'] = '';
      } else {

        $data['status'] = 'Active';
        $data['status_color'] = '#3c763d';
        $data['time_remaining'] = Utilities::trWeek($endDate);
      }

      $data['date_created'] = date('F d, Y h:i a', strtotime($dateCreated));
      $data['end_date'] = date('F d, Y', strtotime($endDate));
      $data['count']['std'] = $stdCount;
      $data['count']['ann'] = $annCount;
      $data['count']['ass'] = $assCount;
      $data['count']['qz'] = $qzCount;
      $data['count']['mat'] = $matCount;

      $classrooms[] = $data;
    }
  }

  $statement->close();

  Ischool::updateNotifSeen2(
    $connection,
    $userId,
    'classrooms'
  );

  $response = [
    'response' => $classrooms == null ? 'nothing' : 'found',
    'classrooms' => $classrooms
  ];
} else {

  $response = [
    'response' => 'unauthorized'
  ];
}

echo json_encode($response);
