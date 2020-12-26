<!DOCTYPE html>
<?php
session_start();
?>
<html>

<head>

  <title>iSchool | Classmates Profile</title>

  <?php
  require 'meta.php';
  ?>

  <style>
    .img-rounded {
      border: 1px solid #ddd;
      border-radius: 4px;
      height: 200px;
      padding: 5px;
      width: 160px;
    }

    .panel-body>.img-circle {
      height: 100px;
      width: 100px;
      margin: 0 auto;
      display: block;
      border: 1px solid #ddd;
      border-radius: 50%;
      padding: 5px;
    }

    .col-md-4 {
      margin-bottom: 15px;
    }

    #name_profile {
      border-bottom: 1px solid #dfe3e1;
      margin-top: 0;
      padding-bottom: 15px;
    }

    .label_name {
      font-size: 15px;
      font-weight: bolder;
    }

    .label_value {
      font-size: 15px;
    }

    @media screen and (max-width: 768px) {

      .col-md-4 {
        margin-bottom: 0px;
      }

      #name_profile {
        border-bottom: 1px solid #dfe3e1;
        font-size: 18px;
        margin-top: 0;
        padding-bottom: 6px;
        text-align: center;
      }

      .label_name {
        font-size: 15px;
        font-weight: bolder;
        margin-bottom: 1px;
      }

      .label_value {
        font-size: 15px;
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
            User Profile
          </li>
        </ul>

        <div class="panel panel-default">

          <div class="panel-body">

            <img class="img-circle visible-xs" src="<?php echo isset($_SESSION['image']) ? $_SESSION['image'] : ''; ?>" alt="<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>">

            <div class="row">

              <div class="col-md-3 col-xs-12 text-center">
                <img class="img-rounded hidden-xs" src="<?php echo isset($_SESSION['image']) ? $_SESSION['image'] : ''; ?>" alt="<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>">
              </div>

              <div class="col-md-8 col-xs-12">
                <h3 id="name_profile"></h3>
              </div>

              <div class="col-md-3 col-xs-6">
                <p class="label_name"><span class="fa fa-user"></span> Gender:</p>
              </div>

              <div class="col-md-4 col-xs-6">
                <p id="gender_profile" class="label_value"></p>
              </div>

              <div class="col-md-3 col-xs-6">
                <p class="label_name"><span class="fa fa-calendar"></span> Birthday:</p>
              </div>

              <div class="col-md-4 col-xs-6">
                <p id="birthday_profile" class="label_value"></p>
              </div>

              <div class="col-md-3 col-xs-6">
                <p class="label_name"><span class="fa fa-phone"></span> <span class="hidden-xs">Contact</span> Number:</p>
              </div>

              <div class="col-md-4 col-xs-6">
                <p id="contact_number_profile" class="label_value"></p>
              </div>

              <div class="col-md-3 col-xs-6">
                <p class="label_name"><span class="fa fa-user"></span> Username:</p>
              </div>

              <div class="col-md-4 col-xs-6">
                <p id="username_profile" class="label_value"></p>
              </div>

            </div>

          </div>

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

  <script src="js/main_routing.js"></script>
  <script src="js/log_in_updater.js"></script>
  <script src="js/unset_classroom.js"></script>
  <script src="js/nav_manipulator.js"></script>
  <script src="js/date_validator.js"></script>

</body>

</html>