<?php

require 'connection.php';

header('Content-type: application/csv');
header('Content-Disposition: attachment; filename=material-report.csv');
header("Content-Transfer-Encoding: UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

  $f = fopen('php://output', 'a');

  $command = 'select c.class as class, c.subject as subject, u.first_name as i_fn, u.middle_name as i_mn, u.last_name as i_ln, m.file_name as material, u2.first_name as s_fn, u2.middle_name as s_middle_name, u2.last_name as s_ln, mr.rate_1 as r1, mr.rate_2 as r2, mr.rate_3 as r3, mr.rate_4 as r4, mr.rate_5 as r5, mr.content as comment, mr.rate as overall_rate from classrooms as c left join users as u on c.teacher_id = u.id inner join materials as m on m.classroom_id = c.id inner join materials_reviews as mr on m.id = mr.material_id left join users as u2 on mr.student_id = u2.id order by u.first_name, c.class, c.subject, m.file_name, u2.first_name';

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
