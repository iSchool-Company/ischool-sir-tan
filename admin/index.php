<!DOCTYPE html>
<?php
session_start();
?>
<html lang="en">

<head>

  <title>iSchool</title>

  <link rel="icon" href="../pictures/modules/logo.png">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
  <link href="../frameworks/Font Awesome 4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link href="../frameworks/Bootstrap 3.3.7/css/bootstrap.min.css" rel="stylesheet">
  <script src="../frameworks/JQuery 3.1.1/jquery.min.js"></script>
  <script src="../frameworks/Bootstrap 3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/navbar.css">
  <link rel="stylesheet" href="css/form.css">

  <style>
    #header {
      background-color: rgba(0, 0, 0, 0.6);
      padding: 5px 15px;
    }

    h2 {
      margin-top: 0;
    }

    span.help-block {
      background-color: rgba(255, 255, 255, 0.5);
    }

    .pull-right {
      margin-right: 45px;
    }

    .btn {
      font-size: 12px;
    }

    @media screen and (max-width: 768px) {

      #header {
        padding: 5px;
      }

      .container {
        padding: 0;
      }

      .col-md-6 {
        padding: 9px;
      }

      .form-group {
        margin-bottom: 5px;
      }

      .pull-right {
        margin-right: 0;
      }

    }
  </style>

</head>

<body>

  <div id="header">
    <a href="index.php" style="text-decoration:none;">
      <img class="ischool-logo" src="../pictures/modules/logo_banner.png" alt="iSchool" />
    </a>
  </div>

  <br />

  <div class="container">

    <div class="col-md-6 col-md-offset-3">

      <div class="panel panel-default">

        <div class="panel-body">

          <h2 class="text-primary"><strong>Sign In</strong></h2>

          <hr />

          <form id="log_in_form" class="form-horizontal" method="post" action="home.php" role="form">

            <div class="form-group has-feedback">
              <label class="control-label col-md-2 col-md-offset-1 hidden-xs" for="username">Username:</label>
              <div class="col-md-8">
                <div class="input-group">
                  <input class="form-control" type="text" name="username" placeholder="Enter username..." autocomplete="off" />
                  <span class="input-group-addon">
                    <i class="fa fa-user"></i>
                  </span>
                </div>
                <span class="glyphicon form-control-feedback"></span>
                <span class="help-block"></span>
              </div>
            </div>

            <div class="form-group has-feedback">
              <label class="control-label col-md-2 col-md-offset-1 hidden-xs" for="password">Password:</label>
              <div class="col-md-8">
                <div class="input-group">
                  <input class="form-control" type="password" name="password" placeholder="Enter password..." autocomplete="off" />
                  <span class="input-group-addon">
                    <i class="fa fa-lock"></i>
                  </span>
                </div>
                <span class="glyphicon form-control-feedback"></span>
                <span class="help-block"></span>
              </div>
            </div>

            <div class="pull-right">
              <button class="btn btn-success" type="submit" name="sign_in_button">
                <span class="fa fa-sign-in"></span> Sign In
              </button>
            </div>

          </form>

        </div>

      </div>

    </div>

  </div>

  <script src="js/account/login_manager.js"></script>
  <script src="js/utilities/input.js"></script>

</body>

</html>