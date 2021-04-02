<!DOCTYPE html>
<?php
session_start();
?>
<html>

<head>

  <title>LMS | My Profile</title>

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

  <style>
    .image-container {
      display: block;
      margin: 0 auto;
      margin-bottom: 15px;
      position: relative;
      width: 160px;
    }

    .img-rounded {
      border: 1px solid #ddd;
      border-radius: 4px;
      height: 200px;
      padding: 5px;
      width: 160px;
    }

    .image-overlay {
      background-color: rgba(0, 143, 149, 0.8);
      bottom: 6px;
      height: 0;
      left: 6px;
      overflow: hidden;
      position: absolute;
      transition: .5s ease;
      width: 148px;
    }

    .image-container:hover .image-overlay {
      height: 35px;
    }

    .text {
      color: #f7f7f7;
      display: block;
      font-size: 18px;
      height: 100%;
      padding-top: 2px;
      position: relative;
      text-align: center;
      width: 100%;
    }

    .text:hover,
    .text:focus {
      background-color: rgba(0, 143, 149, 0.5);
      color: #f7f7f7;
    }

    .visible-xs>.img-circle {
      height: 100px;
      width: 100px;
      margin: 0 auto;
      display: block;
      border: 1px solid #ddd;
      border-radius: 50%;
      padding: 5px;
    }

    [href="#picture_modal"] {
      margin: 0 auto;
      display: block;
      margin-bottom: 15px;
    }

    .col-md-4 {
      margin-bottom: 20px;
    }

    #name_profile {
      border-bottom: 1px solid #dfe3e1;
      margin-top: 0;
      padding-bottom: 15px;
    }

    .btn-link:hover,
    .btn-link:focus {
      background-color: transparent;
    }

    .btn-link {
      color: #008f95;
    }

    .label_name {
      font-size: 15px;
      font-weight: bolder;
    }

    .label_value {
      font-size: 15px;
    }

    .btn-edit {
      font-size: 13px;
      font-weight: bolder;
      padding: 0;
    }
  </style>

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
          My Profile
        </li>
      </ul>

      <div class="panel panel-default">

        <div class="panel-body">

          <div class="row">

            <div class="col-md-3 col-xs-12">
              <div class="image-container hidden-xs">
                <img class="img-rounded" src="../pictures/profile_pictures/20170130173105.jpg" alt="Not Available">
                <div class="image-overlay">
                  <a class="text" href="#" style="text-decoration:none;">
                    <span class="fa fa-pencil"></span> Edit Picture
                  </a>
                </div>
              </div>
            </div>

            <div class="col-md-7 col-sm-9 col-xs-9">
              <h3 id="name_profile">Desiree Anne Flores</h3>
            </div>

            <div class="col-md-2 col-sm-2 col-xs-1">
              <a class="btn btn-link btn-edit" href="#name_modal" type="button" data-toggle="modal">
                <span class="fa fa-pencil"></span> Edit
              </a>
            </div>

            <div class="col-md-3 col-xs-12">
              <p class="label_name"><span class="fa fa-user"></span> Gender:</p>
            </div>

            <div class="col-md-4 col-xs-9">
              <p id="gender_profile" class="label_value">Female</p>
            </div>

            <div class="col-md-1 col-xs-1">
              <a class="btn btn-link btn-edit" href="#gender_modal" type="button" data-toggle="modal">
                <span class="fa fa-pencil"></span> Edit
              </a>
            </div>

            <div class="col-md-3 col-xs-12">
              <p class="label_name"><span class="fa fa-calendar"></span> Birthday:</p>
            </div>

            <div class="col-md-4 col-xs-9">
              <p id="birthday_profile" class="label_value">October 25, 1997</p>
            </div>

            <div class="col-md-1 col-xs-1">
              <a class="btn btn-link btn-edit" href="#birthday_modal" type="button" data-toggle="modal">
                <span class="fa fa-pencil"></span> Edit
              </a>
            </div>

            <div class="col-md-3 col-xs-12">
              <p class="label_name"><span class="fa fa-phone"></span> Contact Number:</p>
            </div>

            <div class="col-md-4 col-xs-9">
              <p id="contact_number_profile" class="label_value">09306192586</p>
            </div>

            <div class="col-md-1 col-xs-1">
              <a class="btn btn-link btn-edit" href="#contact_modal" type="button" data-toggle="modal">
                <span class="fa fa-pencil"></span> Edit
              </a>
            </div>

            <div class="col-md-3 col-xs-12">
              <p class="label_name"><span class="fa fa-user"></span> Username:</p>
            </div>

            <div class="col-md-4 col-xs-9">
              <p id="username_profile" class="label_value">@desireeanne</p>
            </div>

            <div class="col-md-1 col-xs-1">
              <a class="btn btn-link btn-edit" href="#username_modal" type="button" data-toggle="modal">
                <span class="fa fa-pencil"></span> Edit
              </a>
            </div>

            <div class="col-md-3 col-md-offset-3 col-xs-12">
              <p class="label_name"><span class="fa fa-at"></span> Email Address:</p>
            </div>

            <div class="col-md-4 col-xs-9">
              <p id="email_profile" class="label_value">desiree_anne@yahoo.com</p>
            </div>

            <div class="col-md-1 col-xs-1">
              <a class="btn btn-link btn-edit" href="#email_modal" type="button" data-toggle="modal">
                <span class="fa fa-pencil"></span> Edit
              </a>
            </div>

            <div class="col-md-3 col-md-offset-3 col-xs-12">
              <p class="label_name"><span class="fa fa-lock"></span> Password:</p>
            </div>

            <div class="col-md-4 col-xs-9">
              <p class="label_value">******</p>
            </div>

            <div class="col-md-1 col-xs-1">
              <a class="btn btn-link btn-edit" href="#password_modal" type="button" data-toggle="modal">
                <span class="fa fa-pencil"></span> Edit
              </a>
            </div>

          </div>

        </div>

      </div>

    </div>

  </div>

  <div id="name_modal" class="modal fade">

    <div class="modal-dialog">

      <div class="modal-content">

        <div class="modal-header">

          <button class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Edit Name</h4>

        </div>

        <div class="modal-body">

          <form id="name_form" class="form-horizontal" role="form">

            <div class="form-group has-feedback">
              <label class="control-label col-md-4" for="first_name">First Name:</label>
              <div class="col-md-7">
                <input id="first_name" class="form-control" type="text" name="first_name" placeholder="Enter first name..." />
                <span class="glyphicon form-control-feedback"></span>
                <span class="help-block"></span>
              </div>
            </div>

            <div class="form-group has-feedback">
              <label class="control-label col-md-4" for="middle_name">Middle Name:</label>
              <div class="col-md-7">
                <input id="middle_name" class="form-control" type="text" name="middle_name" placeholder="Enter middle name..." />
                <span class="glyphicon form-control-feedback"></span>
                <span class="help-block"></span>
              </div>
            </div>

            <div class="form-group has-feedback">
              <label class="control-label col-md-4" for="last_name">Last Name:</label>
              <div class="col-md-7">
                <input id="last_name" class="form-control" type="text" name="last_name" placeholder="Enter last name..." />
                <span class="glyphicon form-control-feedback"></span>
                <span class="help-block"></span>
              </div>
            </div>

            <div class="form-group has-feedback">
              <label class="control-label col-md-4" for="password">Password:</label>
              <div class="col-md-7">
                <input id="password" class="form-control" type="password" name="password" placeholder="Enter password..." />
                <span class="glyphicon form-control-feedback"></span>
                <span class="help-block"></span>
              </div>
            </div>

          </form>

        </div>

        <div class="modal-footer">

          <a name="save_button" class="btn btn-success" href="#" type="button">
            <span class="fa fa-save"></span> Save
          </a>

          <a class="btn btn-danger" href="#" type="button" data-dismiss="modal">
            <span class="fa fa-remove"></span> Cancel
          </a>

        </div>

      </div>

    </div>

  </div>

  <div id="gender_modal" class="modal fade">

    <div class="modal-dialog">

      <div class="modal-content">

        <div class="modal-header">

          <button class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Edit Gender</h4>

        </div>

        <div class="modal-body">

          <form id="gender_form" class="form-horizontal" role="form">

            <div class="form-group has-feedback">
              <label class="control-label col-md-4" for="gender">Gender:</label>
              <div class="col-md-7">
                <select id="gender" class="form-control" name="gender">
                  <option disabled selected hidden>Choose Gender</option>
                  <option>Female</option>
                  <option>Male</option>
                </select>
                <span class="glyphicon form-control-feedback"></span>
                <span class="help-block"></span>
              </div>
            </div>

            <div class="form-group has-feedback">
              <label class="control-label col-md-4" for="password">Password:</label>
              <div class="col-md-7">
                <input id="password" class="form-control" type="password" name="password" placeholder="Enter password..." />
                <span class="glyphicon form-control-feedback"></span>
                <span class="help-block"></span>
              </div>
            </div>

          </form>

        </div>

        <div class="modal-footer">

          <a name="save_button" class="btn btn-success" href="#" type="button">
            <span class="fa fa-save"></span> Save
          </a>

          <a class="btn btn-danger" href="#" type="button" data-dismiss="modal">
            <span class="fa fa-remove"></span> Cancel
          </a>

        </div>

      </div>

    </div>

  </div>

  <div id="birthday_modal" class="modal fade">

    <div class="modal-dialog">

      <div class="modal-content">

        <div class="modal-header">

          <button class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Edit Birthday</h4>

        </div>

        <div class="modal-body">

          <form id="birthday_form" class="form-horizontal" role="form">

            <div class="form-group has-feedback">
              <label class="control-label col-md-4" for="birthday">Birthday:</label>
              <div class="col-md-7">
                <input id="birthday" class="form-control" type="date" name="birthday" />
                <span class="glyphicon form-control-feedback"></span>
                <span class="help-block"></span>
              </div>
            </div>

            <div class="form-group has-feedback">
              <label class="control-label col-md-4" for="password">Password:</label>
              <div class="col-md-7">
                <input id="password" class="form-control" type="password" name="password" placeholder="Enter password..." />
                <span class="glyphicon form-control-feedback"></span>
                <span class="help-block"></span>
              </div>
            </div>

          </form>

        </div>

        <div class="modal-footer">

          <a name="save_button" class="btn btn-success" href="#" type="button">
            <span class="fa fa-save"></span> Save
          </a>

          <a class="btn btn-danger" href="#" type="button" data-dismiss="modal">
            <span class="fa fa-remove"></span> Cancel
          </a>

        </div>

      </div>

    </div>

  </div>

  <div id="contact_modal" class="modal fade">

    <div class="modal-dialog">

      <div class="modal-content">

        <div class="modal-header">

          <button class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Edit Contact Number</h4>

        </div>

        <div class="modal-body">

          <form id="contact_form" class="form-horizontal" role="form">

            <div class="form-group has-feedback">
              <label class="control-label col-md-4" for="contact_number">Contact Number:</label>
              <div class="col-md-7">
                <input id="contact_number" class="form-control" type="text" name="contact_number" placeholder="Enter contact number..." />
                <span class="glyphicon form-control-feedback"></span>
                <span class="help-block"></span>
              </div>
            </div>

            <div class="form-group has-feedback">
              <label class="control-label col-md-4" for="password">Password:</label>
              <div class="col-md-7">
                <input id="password" class="form-control" type="password" name="password" placeholder="Enter password..." />
                <span class="glyphicon form-control-feedback"></span>
                <span class="help-block"></span>
              </div>
            </div>

          </form>

        </div>

        <div class="modal-footer">

          <a name="save_button" class="btn btn-success" href="#" type="button">
            <span class="fa fa-save"></span> Save
          </a>

          <a class="btn btn-danger" href="#" type="button" data-dismiss="modal">
            <span class="fa fa-remove"></span> Cancel
          </a>

        </div>

      </div>

    </div>

  </div>

  <div id="username_modal" class="modal fade">

    <div class="modal-dialog">

      <div class="modal-content">

        <div class="modal-header">

          <button class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Edit Username</h4>

        </div>

        <div class="modal-body">

          <form id="username_form" class="form-horizontal" role="form">

            <div class="form-group has-feedback">
              <label class="control-label col-md-4" for="username">Username:</label>
              <div class="col-md-7">
                <input id="username" class="form-control" type="text" name="username" placeholder="Enter username..." />
                <span class="glyphicon form-control-feedback"></span>
                <span class="help-block"></span>
              </div>
            </div>

            <div class="form-group has-feedback">
              <label class="control-label col-md-4" for="password">Password:</label>
              <div class="col-md-7">
                <input id="password" class="form-control" type="password" name="password" placeholder="Enter password..." />
                <span class="glyphicon form-control-feedback"></span>
                <span class="help-block"></span>
              </div>
            </div>

          </form>

        </div>

        <div class="modal-footer">

          <a name="save_button" class="btn btn-success" href="#" type="button">
            <span class="fa fa-save"></span> Save
          </a>

          <a class="btn btn-danger" href="#" type="button" data-dismiss="modal">
            <span class="fa fa-remove"></span> Cancel
          </a>

        </div>

      </div>

    </div>

  </div>

  <div id="email_modal" class="modal fade">

    <div class="modal-dialog">

      <div class="modal-content">

        <div class="modal-header">

          <button class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Edit Email Address</h4>

        </div>

        <div class="modal-body">

          <form id="email_form" class="form-horizontal" role="form">

            <div class="form-group has-feedback">
              <label class="control-label col-md-4" for="email">Email Address:</label>
              <div class="col-md-7">
                <input id="email" class="form-control" type="text" name="email" placeholder="Enter email address..." />
                <span class="glyphicon form-control-feedback"></span>
                <span class="help-block"></span>
              </div>
            </div>

            <div class="form-group has-feedback">
              <label class="control-label col-md-4" for="email_extension">Email Extension:</label>
              <div class="col-md-7">
                <select class="form-control" name="email_extension">
                  <option disabled selected hidden>extension.com</option>
                  <option>gmail.com</option>
                  <option>yahoo.com</option>
                  <option>hotmail.com</option>
                  <option>rocketmail.com</option>
                </select>
                <span class="glyphicon form-control-feedback"></span>
                <span class="help-block"></span>
              </div>
            </div>

            <div class="form-group has-feedback">
              <label class="control-label col-md-4" for="password">Password:</label>
              <div class="col-md-7">
                <input id="password" class="form-control" type="password" name="password" placeholder="Enter password..." />
                <span class="glyphicon form-control-feedback"></span>
                <span class="help-block"></span>
              </div>
            </div>

          </form>

        </div>

        <div class="modal-footer">

          <a name="save_button" class="btn btn-success" href="#" type="button">
            <span class="fa fa-save"></span> Save
          </a>

          <a class="btn btn-danger" href="#" type="button" data-dismiss="modal">
            <span class="fa fa-remove"></span> Cancel
          </a>

        </div>

      </div>

    </div>

  </div>

  <div id="password_modal" class="modal fade">

    <div class="modal-dialog">

      <div class="modal-content">

        <div class="modal-header">

          <button class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Edit Password</h4>

        </div>

        <div class="modal-body">

          <form class="form-horizontal" role="form">

            <div class="form-group has-feedback">
              <label class="control-label col-md-4" for="old_password">Old Password:</label>
              <div class="col-md-7">
                <input id="old_password" class="form-control" type="password" name="old_password" placeholder="Enter old password..." />
                <span class="glyphicon form-control-feedback"></span>
                <span class="help-block"></span>
              </div>
            </div>

            <div class="form-group has-feedback">
              <label class="control-label col-md-4" for="new_password">New Password:</label>
              <div class="col-md-7">
                <input id="new_password" class="form-control" type="password" name="new_password" placeholder="Enter new password..." />
                <span class="glyphicon form-control-feedback"></span>
                <span class="help-block"></span>
              </div>
            </div>

            <div class="form-group has-feedback">
              <label class="control-label col-md-4" for="confirm_password">Confirm Password:</label>
              <div class="col-md-7">
                <input id="confirm_password" class="form-control" type="password" name="confirm_password" placeholder="Confirm password..." />
                <span class="glyphicon form-control-feedback"></span>
                <span class="help-block"></span>
              </div>
            </div>

          </form>

        </div>

        <div class="modal-footer">

          <a class="btn btn-success" href="#" type="button">
            <span class="fa fa-save"></span> Save
          </a>

          <a class="btn btn-danger" href="#" type="button" data-dismiss="modal">
            <span class="fa fa-remove"></span> Cancel
          </a>

        </div>

      </div>

    </div>

  </div>

  <div id="prompt_modal" class="modal fade" style="margin-top:140px;">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">

        <div class="modal-body">

          <div class="row">

            <div class="col-md-12 col-xs-12">
              <p class="text-center">You have successfully updated your <span id="edit_type"></span>!</p>
              <hr style="border:1px; padding:0;" />
            </div>

            <div class="col-md-2 col-xs-2 col-md-offset-8 col-xs-offset-8">
              <a class="btn btn-success btn-sm" href="#" type="button" name="ok_button" data-dismiss="modal">
                <span class="fa fa-thumbs-up"></span> Ok
              </a>
            </div>

          </div>

        </div>

      </div>
    </div>
  </div>

  <script>
    var myType = '<?php echo isset($_SESSION['type']) ? $_SESSION['type'] : '' ?>';
    var myId = <?php echo isset($_SESSION['id']) ? $_SESSION['id'] : '0' ?>;
    var myLogInId = <?php echo isset($_SESSION['log_in_id']) ? $_SESSION['log_in_id'] : '0' ?>;

    $(document).ready(function() {
      $('[data-toggle="tooltip"]').tooltip();
    });
  </script>

  <script src="js/input_manipulator.js"></script>
  <script src="js/date_validator.js"></script>
  <script src="js/my_profile_manager.js"></script>

</body>

</html>