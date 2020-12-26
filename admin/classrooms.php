<!DOCTYPE html>
<?php
session_start();
?>
<html>

<head>

  <title>iSchool | Classrooms</title>

  <link rel="icon" href="../pictures/modules/logo.png">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
  <link href="../../frameworks/Font Awesome 4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link href="../../frameworks/Bootstrap 3.3.7/css/bootstrap.min.css" rel="stylesheet">
  <script src="../../frameworks/JQuery 3.1.1/jquery.min.js"></script>
  <script src="../../frameworks/Bootstrap 3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/navbar.css">
  <link rel="stylesheet" href="css/sidebar.css">
  <link rel="stylesheet" href="css/form.css">

</head>

<body>

  <?php

  require 'main_header.php';

  ?>

  <div class="container-fluid main-container-fluid">

    <br /><br />

    <?php

    require 'main_sidebar.php';

    ?>

    <br />

    <div class="col-md-11">

      <ul class="breadcrumb">

        <li class="active">
          Classrooms
        </li>

      </ul>

      <div class="row">

        <div class="col-md-12">

          <div class="panel panel-default">

            <div class="panel-body">

              <div class="row">
                <div class="col-md-1">
                  <h4>ID</h4>
                </div>

                <div class="col-md-2">
                  <h4>Instructor</h4>
                </div>

                <div class="col-md-2">
                  <h4>Class Name</h4>
                </div>

                <div class="col-md-2">
                  <h4>Subject Code</h4>
                </div>

                <div class="col-md-2">
                  <h4>End Date</h4>
                </div>

                <div class="col-md-3">
                  <h4>Classroom Description</h4>
                </div>
              </div>

              <div class="row">
                <div class="col-md-1">
                  <p>1</p>
                </div>

                <div class="col-md-2">
                  <p>Randy Otero</p>
                </div>

                <div class="col-md-2">
                  <p>BSCS4A</p>
                </div>

                <div class="col-md-2">
                  <p>Cisco</p>
                </div>

                <div class="col-md-2">
                  <p>Oct 31, 2017</p>
                </div>

                <div class="col-md-3">
                  <p>Course Syllabus</p>
                </div>
              </div>

            </div>

          </div>

        </div>

      </div>

      <ul class="pagination pull-right">
        <li id="pg_previous"><a href="#">Previous</a></li>
        <li id="pg_one" value="1"><a href="#">1</a></li>
        <li id="pg_two" value="2"><a href="#">2</a></li>
        <li id="pg_three" value="3"><a href="#">3</a></li>
        <li id="pg_four" value="4"><a href="#">4</a></li>
        <li id="pg_five" value="5"><a href="#">5</a></li>
        <li id="pg_next"><a href="#">Next</a></li>
      </ul>

    </div>

  </div>

  <script>
    $(document).ready(function() {
      $('[data-toggle="tooltip"]').tooltip();
    });
  </script>

</body>

</html>