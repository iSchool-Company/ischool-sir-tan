<!DOCTYPE html>
<?php
session_start();
?>
<html>

<head>

  <title>LMS | Users</title>

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
          Users
        </li>

      </ul>

      <div class="row">

        <div class="col-md-4">

          <div class="panel panel-default">

            <div class="panel-body">

              <div class="media">

                <div class="media-left">
                  <a href="../pictures/profile_pictures/20170129220000.jpg" target="_blank">
                    <img class="img-circle media-object" src="../pictures/profile_pictures/20170129220000.jpg" alt="Not Available" width="75px" height="75px" />
                  </a>
                </div>

                <div class="media-body">

                  <p class="media-heading">Zeah Mae Colarat</p>
                  <p>@zeyuuuuh</p>

                  <a href="#view_modal" data-toggle="modal" style="text-decoration:none; margin-right:15px;">
                    <span class="fa fa-file-text text-main-green" title="View Details" data-toggle="tooltip" data-placement="auto" style="font-size:15px;"></span>
                  </a>

                  <a href="#delete_modal" data-toggle="modal" style="text-decoration:none;">
                    <span class="fa fa-trash text-main-red" title="Delete" data-toggle="tooltip" data-placement="auto" style="font-size:18px;"></span>
                  </a>

                </div>

              </div>

            </div>

          </div>

        </div>

      </div>

    </div>

  </div>

  <div id="view_modal" class="modal fade">

    <div class="modal-dialog">

      <div class="modal-content">

        <div class="modal-header">

          <button class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">User Information</h4>

        </div>

        <div class="modal-body">

          <form class="form-horizontal" role="form">

            <div class="form-group">
              <label class="control-label col-md-4" for="id_number">ID Number:</label>
              <p class="form-control-static col-md-6" name="id_number">2</p>
            </div>

            <div class="form-group">
              <label class="control-label col-md-4" for="type">Type:</label>
              <p class="form-control-static col-md-6" name="type">Teacher</p>
            </div>

            <div class="form-group">
              <label class="control-label col-md-4" for="first_name">First Name:</label>
              <p class="form-control-static col-md-6" name="first_name">First Name</p>
            </div>

            <div class="form-group">
              <label class="control-label col-md-4" for="middle_name">Middle Name:</label>
              <p class="form-control-static col-md-6" name="middle_name">Middle Name</p>
            </div>

            <div class="form-group">
              <label class="control-label col-md-4" for="last_name">Last Name:</label>
              <p class="form-control-static col-md-6" name="last_name">Last Name</p>
            </div>

            <div class="form-group">
              <label class="control-label col-md-4" for="email">Email:</label>
              <p class="form-control-static col-md-6" name="email">Email@extension.com</p>
            </div>

            <div class="form-group">
              <label class="control-label col-md-4" for="birthday">Birthday:</label>
              <p class="form-control-static col-md-6" name="birthday">Birthday</p>
            </div>

            <div class="form-group">
              <label class="control-label col-md-4" for="gender">Gender:</label>
              <p class="form-control-static col-md-6" name="gender">Gender</p>
            </div>

            <div class="form-group">
              <label class="control-label col-md-4" for="username">Username:</label>
              <p class="form-control-static col-md-6" name="username">Username</p>
            </div>

            <div class="form-group">
              <label class="control-label col-md-4" for="password">Password:</label>
              <p class="form-control-static col-md-6" name="password">******</p>
            </div>

            <div class="form-group">
              <label class="control-label col-md-4" for="confirm_password">Confirm Password:</label>
              <p class="form-control-static col-md-6" name="confirm_password">******</p>
            </div>

            <div class="form-group">
              <label class="control-label col-md-4" for="status">Status:</label>
              <p class="form-control-static col-md-6" name="status">Offline</p>
            </div>

            <div class="form-group">
              <label class="control-label col-md-4" for="last_online">Last Online:</label>
              <p class="form-control-static col-md-6" name="last_online">July 26, 2017 12:29PM</p>
            </div>

          </form>

        </div>

        <div class="modal-footer">

          <a class="btn btn-danger" href="#" type="button" data-dismiss="modal">
            <span class="fa fa-remove"></span> Close
          </a>

        </div>

      </div>

    </div>

  </div>

  <div id="delete_modal" class="modal fade">

    <div class="modal-dialog">

      <div class="modal-content">

        <div class="modal-header bg-danger">

          <button class="close" data-dismiss="modal">&times;</button>

          <h2 class="modal-title text-danger">Warning!</h2>

        </div>

        <div class="modal-body">
          <p class="lead text-center">Are you sure you want to delete this user?</p>
        </div>

        <div class="modal-footer">

          <a class="btn btn-success" href="#" type="button" data-dismiss="modal">
            <span class="fa fa-check"></span> Confirm
          </a>

          <a class="btn btn-danger" href="#" type="button" data-dismiss="modal">
            <span class="fa fa-remove"></span> Cancel
          </a>

        </div>

      </div>

    </div>

  </div>

  <script>
    $(document).ready(function() {
      $('[data-toggle="tooltip"]').tooltip();
    });
  </script>

</body>

</html>