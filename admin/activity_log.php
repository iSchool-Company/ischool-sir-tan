<!DOCTYPE html>
<?php
session_start();
?>
<html>

<head>

  <title>iSchool | Activity Log</title>

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
          Activity Log
        </li>

      </ul>

      <div class="row">

        <div class="col-md-2">
          <div class="form-group">
            <label for="sort_user_type">Sort by user type:</label>
            <select id="sort_user_type" class="form-control" name="sort_user_type">
              <option>All</option>
              <option>Admin</option>
              <option>Student</option>
              <option>Teacher</option>
            </select>
          </div>
        </div>

        <div class="col-md-3">
          <div class="form-group">
            <label for="from">Sort by date - From:</label>
            <input id="from" class="form-control" type="date" name="from" placeholder="Start date" />
          </div>
        </div>

        <div class="col-md-3">
          <div class="form-group">
            <label for="to">To:</label>
            <input id="to" class="form-control" type="date" name="to" placeholder="End date" />
          </div>
        </div>

      </div>

      <div class="row">

        <div class="col-md-12">

          <div class="panel panel-default">

            <div class="panel-body">

              <div class="row">
                <div class="col-md-3">
                  <h4>Login Date</h4>
                </div>

                <div class="col-md-3">
                  <h4>User Type</h4>
                </div>

                <div class="col-md-3">
                  <h4>Username</h4>
                </div>

                <div class="col-md-3">
                  <h4>Action</h4>
                </div>
              </div>

              <div class="row">
                <div class="col-md-3">
                  <p>July 16, 2017</p>
                </div>

                <div class="col-md-3">
                  <p>Admin</p>
                </div>

                <div class="col-md-3">
                  <p>@desiree_anne</p>
                </div>

                <div class="col-md-3">
                  <p>Deleted painlover25</p>
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