<!DOCTYPE html>
<?php
session_start();
?>
<html>

<head>

  <title>iSchool | My Profile</title>

  <?php
  require 'meta.php';
  ?>

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

    .btn-link,
    .btn-edit:hover,
    .btn-edit:focus {
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

    @media screen and (max-width: 768px) {

      .col-md-4 {
        margin-bottom: 0px;
      }

      #name_profile {
        border-bottom: 0px solid #dfe3e1;
        font-size: 18px;
        padding-bottom: 6px;
      }

      .label_name {
        margin-bottom: 1px;
      }

    }
  </style>

</head>

<body>

  <?php
  require 'main_header.php';
  ?>

  <div class="container-fluid">

    <div class="row">

      <?php
      require 'main_sidebar.php';
      ?>

      <div class="col-md-11 col-sm-11 main-container">

        <ul class="breadcrumb">
          <li class="active">
            My Profile
          </li>
        </ul>

        <div class="panel panel-default">

          <div class="panel-body">

            <div class="visible-xs">
              <img id="dp" class="img-circle" src="">
              <a id="edit_dp_2" class="btn btn-link btn-edit" href="#picture_modal" type="button" data-toggle="modal">
                <span class="fa fa-pencil"></span> Change Picture
              </a>
            </div>

            <div class="row">

              <div class="col-md-3 col-xs-12">
                <div class="image-container hidden-xs">
                  <img id="dp2" class="img-rounded" src="">
                  <div class="image-overlay">
                    <a id="edit_dp" class="text" href="#" style="text-decoration:none;">
                      <span class="fa fa-pencil"></span> Edit Picture
                    </a>
                    <input id="edit_dp_r" type="file" accept="image/*" style="display:none;">
                  </div>
                </div>
              </div>

              <div class="col-md-7 col-sm-9 col-xs-9">
                <h3 id="name_profile"></h3>
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
                <p id="gender_profile" class="label_value"></p>
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
                <p id="birthday_profile" class="label_value"></p>
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
                <p id="contact_number_profile" class="label_value"></p>
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
                <p id="username_profile" class="label_value"></p>
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
                <p id="email_profile" class="label_value"></p>
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

  </div>

  <div id="name_modal" class="modal fade">

    <div class="modal-dialog">

      <div class="modal-content">

        <div class="modal-header">

          <button class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Edit Name</h4>

        </div>

        <div class="modal-body">

          <form id="name_form" class="form-horizontal" role="form" autocomplete="off">

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

          <button name="save_button" class="btn btn-success" type="button">
            <span class="fa fa-save"></span> Save
          </button>

          <button class="btn btn-danger" type="button" data-dismiss="modal">
            <span class="fa fa-remove"></span> Cancel
          </button>

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

          <form id="gender_form" class="form-horizontal" role="form" autocomplete="off">

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

          <button name="save_button" class="btn btn-success" type="button">
            <span class="fa fa-save"></span> Save
          </button>

          <button class="btn btn-danger" type="button" data-dismiss="modal">
            <span class="fa fa-remove"></span> Cancel
          </button>

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

          <form id="birthday_form" class="form-horizontal" role="form" autocomplete="off">

            <div class="form-group has-feedback">
              <label class="control-label col-md-4" for="birthday">Birthday:</label>
              <div class="col-md-7">
                <input id="birthday" class="form-control" type="text" name="birthday" />
                <span class="glyphicon form-control-feedback"></span>
                <span class="help-block"><b>Format:</b> mm/dd/yyyy</span>
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

          <button name="save_button" class="btn btn-success" type="button">
            <span class="fa fa-save"></span> Save
          </button>

          <button class="btn btn-danger" type="button" data-dismiss="modal">
            <span class="fa fa-remove"></span> Cancel
          </button>

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

          <form id="contact_form" class="form-horizontal" role="form" autocomplete="off">

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

          <button name="save_button" class="btn btn-success" type="button">
            <span class="fa fa-save"></span> Save
          </button>

          <button class="btn btn-danger" type="button" data-dismiss="modal">
            <span class="fa fa-remove"></span> Cancel
          </button>

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

          <form id="username_form" class="form-horizontal" role="form" autocomplete="off">

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

          <button name="save_button" class="btn btn-success" type="button">
            <span class="fa fa-save"></span> Save
          </button>

          <button class="btn btn-danger" type="button" data-dismiss="modal">
            <span class="fa fa-remove"></span> Cancel
          </button>

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

          <form id="email_form" class="form-horizontal" role="form" autocomplete="off">

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

          <button name="save_button" class="btn btn-success" type="button">
            <span class="fa fa-save"></span> Save
          </button>

          <button class="btn btn-danger" type="button" data-dismiss="modal">
            <span class="fa fa-remove"></span> Cancel
          </button>

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

          <form id="password_form" class="form-horizontal" role="form" autocomplete="off">

            <div class="form-group has-feedback">
              <label class="control-label col-md-4" for="old_password">Old Password:</label>
              <div class="col-md-7">
                <input id="old_password" class="form-control" type="password" name="password" placeholder="Enter old password..." />
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

          <button name="save_button" class="btn btn-success" type="button">
            <span class="fa fa-save"></span> Save
          </button>

          <button class="btn btn-danger" type="button" data-dismiss="modal">
            <span class="fa fa-remove"></span> Cancel
          </button>

        </div>

      </div>

    </div>

  </div>

  <div id="prompt_modal" class="modal fade">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">

        <div class="modal-body">
          <div class="row">
            <div class="col-md-12 col-xs-12">
              <p class="text-center">You have successfully updated your <span id="edit_type"></span>!</p>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button class="btn btn-success btn-sm" type="button" name="ok_button" data-dismiss="modal">
            <span class="fa fa-thumbs-up"></span> Ok
          </button>
        </div>

      </div>
    </div>
  </div>

  <!-- Main Variables -->
  <script>
    var myType = '<?php echo isset($_SESSION['type']) ? $_SESSION['type'] : '' ?>';
    var myId = <?php echo isset($_SESSION['id']) ? $_SESSION['id'] : '0' ?>;
    var myLogInId = <?php echo isset($_SESSION['log_in_id']) ? $_SESSION['log_in_id'] : '0' ?>;
  </script>

  <!-- Main Workers -->
  <script src="js/main_routing.js"></script>
  <script src="js/log_in_updater.js"></script>
  <script src="js/nav_manipulator.js"></script>

  <!-- Utilities -->
  <script src="js/utilities/input.js"></script>
  <script src="js/utilities/date.js"></script>
  <script src="js/utilities/files.js"></script>

  <!-- Main Notification Worker -->
  <script src="js/notification/events/init.js"></script>
  <script src="js/notification/operations/retrieval.js"></script>

  <!-- Profile Workers -->
  <script src="js/account/profile_manager.js"></script>

</body>

</html>