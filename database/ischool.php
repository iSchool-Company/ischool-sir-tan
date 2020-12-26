<?php

class Ischool
{

  static function crDelete(
    $connection,
    $id
  ) {

    $command = "UPDATE classrooms SET is_deleted = 1 WHERE id = ?";
    $statement = $connection->prepare($command);
    $statement->bind_param('i', $id);
    $statement->execute();
    $statement->close();

    return $statement;
  }

  static function smoothDelete(
    $connection,
    $tableName,
    $id
  ) {

    $command = "UPDATE $tableName SET deleted = 1 WHERE id = ?";
    $statement = $connection->prepare($command);
    $statement->bind_param('i', $id);
    $statement->execute();
    $statement->close();

    return $statement;
  }

  static function hardDelete(
    $connection,
    $tableName,
    $id
  ) {

    $command = "DELETE FROM $tableName WHERE id = ?";
    $statement = $connection->prepare($command);
    $statement->bind_param('i', $id);
    $statement->execute();
    $statement->close();

    return $statement;
  }

  static function activityLog(
    $connection,
    $userId,
    $sourceId,
    $action,
    $dateTime
  ) {

    $command = 'INSERT INTO activity_log(person_id, source_id, action, date_time_did) VALUES(?, ?, ?, ?)';
    $statement = $connection->prepare($command);
    $statement->bind_param(
      'iiss',
      $userId,
      $sourceId,
      $action,
      $dateTime
    );
    $statement->execute();
    $statement->close();

    return $statement;
  }

  static function deleteNotif(
    $connection,
    $doerId,
    $type,
    $sourceId
  ) {

    $command = 'DELETE FROM notifications WHERE doer_id = ? AND type = ? AND source_id = ?';
    $statement = $connection->prepare($command);
    $statement->bind_param(
      'isi',
      $doerId,
      $type,
      $sourceId
    );
    $statement->execute();
    $statement->close();

    return $statement;
  }

  static function deleteNotif2(
    $connection,
    $type,
    $sourceId
  ) {

    $command = 'DELETE FROM notifications WHERE type = ? AND source_id = ?';
    $statement = $connection->prepare($command);
    $statement->bind_param(
      'si',
      $type,
      $sourceId
    );
    $statement->execute();
    $statement->close();

    return $statement;
  }

  static function updateNotifSeen(
    $connection,
    $userId,
    $classroomId,
    $module
  ) {

    switch ($module) {

      case 'overview':
        $types = '"cr_change_name", "cr_change_date", "cr_change_desc"';
        break;

      case 'students':
        $types = '"new_student", "remove_student", "left_student"';
        break;

      case 'announcements':
        $types = '"new_announcement", "new_comment", "new_reply", "new_ann_like", "new_com_like", "new_rep_like"';
        break;

      case 'assignments':
        $types = '"new_assignment", "cancel_assignment", "delete_assignment", "submit_assignment", "rate_assignment", "resubmit_assignment"';
        break;

      case 'quizzes':
        $types = '"new_quiz", "cancel_quiz", "delete_quiz", "take_quiz", "retake_quiz"';
        break;

      case 'materials':
        $types = '"new_material"';
        break;
    }

    $command = "UPDATE notifications SET received = 1, seen = 1 WHERE user_id = ? AND classroom_id = ? AND type IN($types)";
    $statement = $connection->prepare($command);
    $statement->bind_param(
      'ii',
      $userId,
      $classroomId
    );
    $statement->execute();
    $statement->close();

    return $statement;
  }

  static function updateNotifSeen2(
    $connection,
    $userId,
    $module
  ) {

    switch ($module) {

      case 'requests':
        $types = '"new_request"';
        break;

      case 'classrooms':
        $types = '"accept_request", "decline_request", "added_student", "removed_student", "cr_delete"';
        break;
    }

    $command = "UPDATE notifications SET received = 1, seen = 1 WHERE user_id = ? AND type IN($types)";
    $statement = $connection->prepare($command);
    $statement->bind_param('i', $userId);
    $statement->execute();
    $statement->close();

    return $statement;
  }

  static function notifStudent(
    $connection,
    $doerId,
    $studentId,
    $classroomId,
    $type,
    $sourceId,
    $dateTime
  ) {

    $command = 'INSERT INTO notifications(doer_id, user_id, classroom_id, type, source_id, date_time_did) VALUES(?, ?, ?, ?, ?, ?)';
    $statement = $connection->prepare($command);
    $statement->bind_param(
      'iiisis',
      $doerId,
      $studentId,
      $classroomId,
      $type,
      $sourceId,
      $dateTime
    );
    $statement->execute();
    $statement->close();

    return $statement;
  }

  static function notifStudents(
    $connection,
    $doerId,
    $classroomId,
    $type,
    $sourceId,
    $dateTime
  ) {

    $command = 'INSERT INTO notifications(doer_id, user_id, classroom_id, type, source_id, date_time_did) SELECT ?, student_id, ?, ?, ?, ? FROM classroom_student_designation WHERE classroom_id = ? AND pending = 0';
    $statement = $connection->prepare($command);
    $statement->bind_param(
      'iisisi',
      $doerId,
      $classroomId,
      $type,
      $sourceId,
      $dateTime,
      $classroomId
    );
    $statement->execute();
    $statement->close();

    return $statement;
  }

  static function notifClassmates(
    $connection,
    $doerId,
    $studentId,
    $classroomId,
    $type,
    $sourceId,
    $dateTime
  ) {

    $command = 'INSERT INTO notifications(doer_id, user_id, classroom_id, type, source_id, date_time_did) SELECT ?, student_id, ?, ?, ?, ? FROM classroom_student_designation WHERE classroom_id = ? AND student_id != ? AND pending = 0';
    $statement = $connection->prepare($command);
    $statement->bind_param(
      'iisisii',
      $doerId,
      $classroomId,
      $type,
      $sourceId,
      $dateTime,
      $classroomId,
      $studentId
    );
    $statement->execute();
    $statement->close();

    return $statement;
  }

  static function notifTeacher(
    $connection,
    $doerId,
    $classroomId,
    $type,
    $sourceId,
    $dateTime
  ) {

    $command = 'INSERT INTO notifications(doer_id, user_id, classroom_id, type, source_id, date_time_did) SELECT ?, teacher_id, ?, ?, ?, ? FROM classrooms WHERE id = ?';
    $statement = $connection->prepare($command);
    $statement->bind_param(
      'iisisi',
      $doerId,
      $classroomId,
      $type,
      $sourceId,
      $dateTime,
      $classroomId
    );
    $statement->execute();
    $statement->close();

    return $statement;
  }

  static function notifOthers(
    $connection,
    $ownerId,
    $classroomId,
    $type,
    $sourceId,
    $dateTime
  ) {

    $command = 'INSERT INTO notifications(doer_id, user_id, classroom_id, type, source_id, date_time_did) SELECT ?, student_id, ?, ?, ?, ? FROM classroom_student_designation WHERE classroom_id = ? AND pending = 0 AND student_id != ? UNION SELECT ?, teacher_id, ?, ?, ?, ? FROM classrooms WHERE id = ? AND teacher_id != ?';
    $statement = $connection->prepare($command);
    $statement->bind_param(
      'iisisiiiisisii',
      $ownerId,
      $classroomId,
      $type,
      $sourceId,
      $dateTime,
      $classroomId,
      $ownerId,
      $ownerId,
      $classroomId,
      $type,
      $sourceId,
      $dateTime,
      $classroomId,
      $ownerId
    );
    $statement->execute();
    $statement->close();

    return $statement;
  }
}
