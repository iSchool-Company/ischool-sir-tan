<!DOCTYPE html>

<html lang="en">

<head>

  <title>LMS | <?php echo $_GET['register_type']; ?> Registration</title>

  <link rel="icon" href="pictures/modules/logo.png">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
  <link href="../frameworks/Font Awesome 4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link href="../frameworks/Bootstrap 3.3.7/css/bootstrap.min.css" rel="stylesheet">
  <script src="../frameworks/JQuery 3.1.1/jquery.min.js"></script>
  <script src="../frameworks/Bootstrap 3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/form.css">

  <style>
    .navbar {
      background-color: rgba(0, 0, 0, 0.5);
      border: 0;
    }

    .navbar-brand {
      padding: 5px 15px;
    }

    .ischool-logo {
      height: 40px;
      width: 135px;
    }

    .registration-column {
      margin-top: 60px;
    }

    .modal-body .row .col-sm-4 p {
      font-size: 17px;
      font-weight: bold;
    }

    .modal-body .row .col-sm-8 p {
      font-size: 17px;
    }

    .first-row {
      background-color: #2E3436;
    }

    .first-row .center-block {
      height: 75px;
      width: 175px;
      margin-bottom: 15px;
      margin-top: 15px;
    }

    .second-row {
      background-color: #222728;
      color: #f7f7f7;
      font-size: 16px;
      padding: 10px 0;
    }

    #welcome_modal h3 {
      margin-top: 10px;
    }

    @media screen and (max-width: 768px) {

      .registration-column {
        padding: 0 7px;
      }

      .col-md-8 {
        padding-left: 7px;
        padding-right: 7px;
      }

      .first-row .center-block {
        height: 50px;
        width: 130px;
        margin-bottom: 5px;
        margin-top: 5px;
      }

      #copyright {
        font-size: 12px;
        padding: 10px 0 0 0;
      }

      #welcome_modal h3 {
        font-size: 18px;
        margin-bottom: 5px;
        margin-top: 5px;
      }

    }
  </style>

</head>

<body>

  <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">

    <div class="container-fluid">

      <div class="navbar-header">

        <a class="navbar-brand" href="index.php">
          <img class="ischool-logo" src="pictures/modules/logo_banner.png" alt="LMS" />
        </a>

      </div>

    </div>

  </nav>

  <div class="container">

    <div class="row">

      <div class="col-md-6 col-sm-12 col-md-offset-3 col-sm-offset-0 registration-column">

        <div class="panel panel-default">

          <div class="panel-body">

            <h3 class="text-main-green" style="margin-top:0;">
              <strong><span id="type"></span> Registration</strong>
            </h3>

            <hr />

            <form id="sign_up_form" class="form-horizontal" role="form" autocomplete="off" style="margin-bottom:20px;">

              <div class="form-group has-feedback">
                <label class="control-label col-md-4" for="first_name">First Name:</label>
                <div class="col-md-6 col-sm-12">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="fa fa-user"></i>
                    </span>
                    <input id="first_name" class="form-control" type="text" name="first_name" placeholder="First Name" />
                  </div>
                  <span class="glyphicon form-control-feedback"></span>
                  <span class="help-block"></span>
                </div>
              </div>

              <div class="form-group has-feedback">
                <label class="control-label col-md-4" for="middle_name">Middle Name:</label>
                <div class="col-md-6 col-sm-12">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="fa fa-user"></i>
                    </span>
                    <input id="middle_name" class="form-control" type="text" name="middle_name" placeholder="Middle Name" />
                  </div>
                  <span class="glyphicon form-control-feedback"></span>
                  <span class="help-block"><i class="hidden-sm">* optional</i></span>
                </div>
              </div>

              <div class="form-group has-feedback">
                <label class="control-label col-md-4" for="last_name">Last Name:</label>
                <div class="col-md-6 col-sm-12">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="fa fa-user"></i>
                    </span>
                    <input id="last_name" class="form-control" type="text" name="last_name" placeholder="Last Name" />
                  </div>
                  <span class="glyphicon form-control-feedback"></span>
                  <span class="help-block"></span>
                </div>
              </div>

              <div class="form-group row has-feedback">
                <label class="control-label col-md-4" for="gender">Gender:</label>
                <div class="col-md-6 col-sm-12">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i id="gender_icon" class="fa fa-user"></i>
                    </span>
                    <select class="form-control" name="gender">
                      <option disabled selected hidden>Gender</option>
                      <option>Female</option>
                      <option>Male</option>
                    </select>
                  </div>
                  <span class="glyphicon form-control-feedback"></span>
                  <span class="help-block"></span>
                </div>
              </div>

              <div class="form-group row has-feedback">
                <label class="control-label col-md-4" for="username">Username:</label>
                <div class="col-md-6 col-sm-12">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="fa fa-user"></i>
                    </span>
                    <input id="username" class="form-control" type="text" name="username" placeholder="Username" />
                  </div>
                  <span class="glyphicon form-control-feedback"></span>
                  <img id="loading" src="pictures/modules/loading.gif" style="width:20px; display:none;">
                  <span class="help-block"></span>
                </div>
              </div>

              <div class="form-group row has-feedback">
                <label class="control-label col-md-4" for="password">Password:</label>
                <div class="col-md-6 col-sm-12">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="fa fa-lock"></i>
                    </span>
                    <input id="password" class="form-control" type="password" name="password" placeholder="Password" />
                  </div>
                  <span class="glyphicon form-control-feedback"></span>
                  <span class="help-block"></span>
                </div>
              </div>

              <div class="form-group row has-feedback">
                <label class="control-label col-md-4" for="confirm_password">Confirm Password:</label>
                <div class="col-md-6 col-sm-12">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="fa fa-lock"></i>
                    </span>
                    <input id="confirm_password" class="form-control" type="password" name="confirm_password" placeholder="Confirm Password" />
                  </div>
                  <span class="glyphicon form-control-feedback"></span>
                  <span class="help-block"></span>
                </div>
              </div>

              <div style="float:right;">

                <button class="btn btn-success" type="submit" name="submit_button">
                  <span class="fa fa-check"></span> Submit
                </button>
                <button class="btn btn-danger" type="reset" name="cancel_button">
                  <span class="fa fa-remove"></span> Clear
                </button>

              </div>

              <br style="clear:both;">

            </form>

            <a id="change_mode" class="text-main-green" href="#">Not a <span id="change_mode_text"></span>?</a>

            <p>Already have an account? <a class="text-main-green" href="index.php?action=login">Log in</a></p>

          </div>

        </div>

      </div>

    </div>

  </div>

  <div id="submit_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <button class="close" type="button" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Confirm Submission</h4>
        </div>

        <div class="modal-body">

          <p class="text-center" style="font-size:20px;">Are you sure these are valid informations?</p>

          <div class="row">
            <div class="col-sm-4 col-xs-4">
              <p>Name:</p>
            </div>
            <div class="col-sm-8 col-xs-8">
              <p id="name_modal"></p>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-4 col-xs-4">
              <p>Gender:</p>
            </div>
            <div class="col-sm-8 col-xs-8">
              <p id="gender_modal"></p>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-4 col-xs-4">
              <p>Username:</p>
            </div>
            <div class="col-sm-8 col-xs-8">
              <p id="username_modal"></p>
            </div>
          </div>

        </div>

        <div class="modal-footer">
          <button id="submit_modal_yes" class="btn btn-success" type="submit" data-dismiss="modal">
            <span class="fa fa-check"></span> Yes
          </button>
          <button class="btn btn-danger" type="button" data-dismiss="modal">
            <span class="fa fa-remove"></span> No
          </button>
        </div>

      </div>
    </div>
  </div>

  <div id="prompt_modal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-body">
          <p class="text-center">
            <img src="pictures/modules/loading.gif" style="width:50px"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            Please wait while loading...
          </p>
        </div>

      </div>
    </div>
  </div>

  <div id="welcome_modal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-body">
          <h4 class="text-center">
            Welcome to LMS
            <span id="welcome_name"></span>!
          </h4>
        </div>

      </div>
    </div>
  </div>

  <?php
  require 'footer.php';
  ?>

  <script>
    var type = '<?php echo isset($_GET['register_type']) ? $_GET['register_type'] : ''; ?>';

    $(document).ready(function() {

      if (type != 'Teacher' && type != 'Student') {

        window.location = 'sign_up.php?register_type=Student';
      }

      $('#type').text(type);

      if (type == 'Teacher') {

        $('#change_mode_text').text(type);
      } else {

        $('#change_mode_text').text(type);
      }

      $('#change_mode').click(function() {

        if (type == 'Teacher') {

          $('#change_mode_text').text('Student');
          $('#type').text('Student');

          type = 'Student';
        } else {

          $('#change_mode_text').text('Teacher');
          $('#type').text('Teacher');

          type = 'Teacher';
        }
      });

      $('[href="#"]').click(function(e) {

        e.preventDefault();
      });
    });
  </script>

  <!-- Utilities -->
  <script src="js/utilities/input.js"></script>

  <!-- Sign Up Workers -->
  <script src="js/account/sign_up_manager.js"></script>

</body>

</html>