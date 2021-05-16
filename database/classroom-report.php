<?php

require 'connection.php';

header('Content-type: application/csv');
header('Content-Disposition: attachment; filename=classroom-report.csv');
header("Content-Transfer-Encoding: UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

  $f = fopen('php://output', 'a');

  $command = 'select c.class as class, c.subject as subject, u.first_name as i_fn, u.middle_name as i_mn, u.last_name as i_ln, u2.first_name as s_fn, u2.middle_name as s_middle_name, u2.last_name as s_ln, cr.rate_1 as r1, cr.rate_2 as r2, cr.rate_3 as r3, cr.rate_4 as r4, cr.rate_5 as r5, cr.rate_6 as r6, cr.rate_7 as r7, cr.rate_8 as r8, cr.rate_9 as r9, cr.rate_10 as r10, cr.rate_11 as r11, cr.content as comment, cr.rate as overall_rate from classrooms as c left join users as u on c.teacher_id = u.id inner join classrooms_reviews as cr on c.id = cr.classroom_id left join users as u2 on cr.student_id = u2.id order by u.first_name, c.class, c.subject, u2.first_name';

  $result = $connection->query($command);

  $doneFirst = false;

  while ($row = $result->fetch_assoc()) {
    if (!$doneFirst) {
      fputcsv($f, array_keys($row));
      $doneFirst = true;
    }
    $data = [];
    foreach ($row as $value) {
      $data[] = strval($value);
    }
    fputcsv($f, $data);
  }

  fclose($f);
}
