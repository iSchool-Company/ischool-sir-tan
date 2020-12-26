<!DOCTYPE html>
<?php
session_start();
?>
<html>

<head>

  <title>iSchool | Admins</title>

  <link rel="icon" href="../pictures/modules/logo.png">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
  <link href="../frameworks/Font Awesome 4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link href="../frameworks/Bootstrap 3.3.7/css/bootstrap.min.css" rel="stylesheet">
  <script src="../frameworks/JQuery 3.1.1/jquery.min.js"></script>
  <script src="../frameworks/Bootstrap 3.3.7/js/bootstrap.min.js"></script>
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
          Admins
        </li>

      </ul>

      <a class="btn btn-success pull-right" href="#add_modal" type="button" data-toggle="modal" style="margin-bottom:20px;">
        <span class="fa fa-plus-circle"></span> Add Admin
      </a>

      <div class="clearfix"></div>

      <div class="row">

        <div class="col-md-4">

          <div class="panel panel-default">

            <div class="panel-body">

              <div class="media">

                <div class="media-left">
                  <a href="../pictures/profile_pictures/20170130173105.jpg" target="_blank">
                    <img class="img-circle media-object" src="../pictures/profile_pictures/20170130173105.jpg" alt="Not Available" width="75px" height="75px" />
                  </a>
                </div>

                <div class="media-body">

                  <p class="media-heading">Desiree Anne Flores</p>
                  <p>@desiree_anne</p>

                  <a href="#view_modal" data-toggle="modal" style="text-decoration:none; margin-right:15px;">
                    <span class="fa fa-file-text text-main-green" title="View Details" data-toggle="tooltip" data-placement="auto" style="font-size:15px;"></span>
                  </a>

                  <a href="#edit_modal" data-toggle="modal" style="text-decoration:none; margin-right:15px;">
                    <span class="fa fa-pencil text-main-green" title="Edit" data-toggle="tooltip" data-placement="auto" style="font-size:18px;"></span>
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

  <div id="add_modal" class="modal fade">

    <div class="modal-dialog">

      <div class="modal-content">

        <div class="modal-header">

          <button class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Add Admin</h4>

        </div>

        <div class="modal-body">

          <form class="form-horizontal" role="form">

            <div class="form-group">
              <label class="control-label col-md-4" for="first_name">First Name:</label>
              <div class="col-md-6">
                <input id="first_name" class="form-control" type="text" name="first_name" placeholder="Enter first name..." />
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-4" for="middle_name">Middle Name:</label>
              <div class="col-md-6">
                <input id="middle_name" class="form-control" type="text" name="middle_name" placeholder="Enter middle name..." />
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-4" for="last_name">Last Name:</label>
              <div class="col-md-6">
                <input id="last_name" class="form-control" type="text" name="last_name" placeholder="Enter last name..." />
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-4" for="email">Email:</label>
              <div class="col-md-6">
                <input id="email" class="form-control" type="text" name="email" placeholder="Enter email..." />
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-4" for="email_extension">Email Extension:</label>
              <div class="col-md-6">
                <select id="email_extension" class="form-control" name="email_extension">
                  <option disabled selected hidden>extension.com</option>
                  <option>gmail.com</option>
                  <option>hotmail.com</option>
                  <option>rocketmail.com</option>
                  <option>yahoo.com</option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-4" for="birthday">Birthday:</label>
              <div class="col-md-6">
                <input id="birthday" class="form-control" type="date" name="birthday" placeholder="Enter birthday..." />
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-4" for="gender">Gender:</label>
              <div class="col-md-6">
                <select id="gender" class="form-control" name="gender">
                  <option disabled selected hidden>Choose gender...</option>
                  <option>Female</option>
                  <option>Male</option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-4" for="username">Username:</label>
              <div class="col-md-6">
                <input id="username" class="form-control" type="text" name="username" placeholder="Enter username..." />
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-4" for="password">Password:</label>
              <div class="col-md-6">
                <input id="password" class="form-control" type="password" name="password" placeholder="Enter password..." />
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-4" for="confirm_password">Confirm Password:</label>
              <div class="col-md-6">
                <input id="confirm_password" class="form-control" type="password" name="confirm_password" placeholder="Confirm password..." />
              </div>
            </div>

            <div class="form-group">
              <div class="col-md-2 col-md-offset-4">
                <a class="btn btn-success" href="#" type="button" name="browse_image">
                  <span class="fa fa-image"></span> Browse
                </a>
              </div>
              <p class="form-control-static col-md-6" name="image_name">Image</p>
            </div>

          </form>

        </div>

        <div class="modal-footer">

          <a class="btn btn-success" href="#" type="button" data-dismiss="modal">
            <span class="fa fa-save"></span> Save
          </a>

          <a class="btn btn-danger" href="#" type="button" data-dismiss="modal">
            <span class="fa fa-remove"></span> Cancel
          </a>

        </div>

      </div>

    </div>

  </div>

  <div id="edit_modal" class="modal fade">

    <div class="modal-dialog">

      <div class="modal-content">

        <div class="modal-header">

          <button class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Edit Admin</h4>

        </div>

        <div class="modal-body">

          <form class="form-horizontal" role="form">

            <div class="form-group">
              <label class="control-label col-md-4" for="first_name">First Name:</label>
              <div class="col-md-6">
                <input id="first_name" class="form-control" type="text" name="first_name" placeholder="Enter first name..." />
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-4" for="middle_name">Middle Name:</label>
              <div class="col-md-6">
                <input id="middle_name" class="form-control" type="text" name="middle_name" placeholder="Enter middle name..." />
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-4" for="last_name">Last Name:</label>
              <div class="col-md-6">
                <input id="last_name" class="form-control" type="text" name="last_name" placeholder="Enter last name..." />
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-4" for="email">Email:</label>
              <div class="col-md-6">
                <input id="email" class="form-control" type="text" name="email" placeholder="Enter email..." />
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-4" for="email_extension">Email Extension:</label>
              <div class="col-md-6">
                <select id="email_extension" class="form-control" name="email_extension">
                  <option disabled selected hidden>extension.com</option>
                  <option>gmail.com</option>
                  <option>hotmail.com</option>
                  <option>rocketmail.com</option>
                  <option>yahoo.com</option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-4" for="birthday">Birthday:</label>
              <div class="col-md-6">
                <input id="birthday" class="form-control" type="date" name="birthday" placeholder="Enter birthday..." />
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-4" for="gender">Gender:</label>
              <div class="col-md-6">
                <select id="gender" class="form-control" name="gender">
                  <option disabled selected hidden>Choose gender...</option>
                  <option>Female</option>
                  <option>Male</option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-4" for="username">Username:</label>
              <div class="col-md-6">
                <input id="username" class="form-control" type="text" name="username" placeholder="Enter username..." />
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-4" for="password">Password:</label>
              <div class="col-md-6">
                <input id="password" class="form-control" type="password" name="password" placeholder="Enter password..." />
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-4" for="confirm_password">Confirm Password:</label>
              <div class="col-md-6">
                <input id="confirm_password" class="form-control" type="password" name="confirm_password" placeholder="Confirm password..." />
              </div>
            </div>

            <div class="form-group">
              <div class="col-md-2 col-md-offset-4">
                <a class="btn btn-success" href="#" type="button" name="browse_image">
                  <span class="fa fa-image"></span> Browse
                </a>
              </div>
              <p class="form-control-static col-md-6" name="image_name">Image</p>
            </div>

          </form>

        </div>

        <div class="modal-footer">

          <a class="btn btn-success" href="#" type="button" data-dismiss="modal">
            <span class="fa fa-save"></span> Save
          </a>

          <a class="btn btn-danger" href="#" type="button" data-dismiss="modal">
            <span class="fa fa-remove"></span> Cancel
          </a>

        </div>

      </div>

    </div>

  </div>

  <div id="view_modal" class="modal fade">

    <div class="modal-dialog">

      <div class="modal-content">

        <div class="modal-header">

          <button class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Admin Information</h4>

        </div>

        <div class="modal-body">

          <form class="form-horizontal" role="form">

            <div class="form-group">
              <label class="control-label col-md-4" for="id_number">ID Number:</label>
              <p class="form-control-static col-md-6" name="id_number">3</p>
            </div>

            <div class="form-group">
              <label class="control-label col-md-4" for="type">Type:</label>
              <p class="form-control-static col-md-6" name="type">Admin</p>
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
          <p class="lead text-center">Are you sure you want to delete this admin?</p>
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

  <script>
    var myId = <?php echo isset($_SESSION['id']) ? $_SESSION['id'] : '0' ?>;
  </script>

  <script src="js/nav_manipulator.js"></script>
  <script src="js/main_routing.js"></script>

</body>

</html>