<!DOCTYPE html>
<?php
session_start();
?>
<html>

<head>

  <title>iSchool | Notifications</title>

  <?php
  require 'meta.php';
  ?>

  <style>
    .col-md-12:hover {
      background-color: #dfe3ee;
      border-radius: 5px;
    }

    .panel-body>.row {
      margin: 0px;
    }

    a.notif-content {
      color: #333333;
      font-size: 15px;
      text-decoration: none;
    }

    .notif-content:hover {
      color: #000000;
    }

    .notif-content>p {
      margin: 0;
      padding: 4px 0;
    }

    .text-muted {
      margin-left: 15px;
    }

    hr {
      height: 0;
      margin-bottom: 0;
      margin-top: 0;
      width: 100%;
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
            Activity Log
          </li>
        </ul>

        <div class="panel panel-default">

          <div class="panel-body">

            <div class="row">
              <div class="col-md-12">
                <a class="notif-content" href="#">
                  <p>
                    <span class="fa fa-plus-circle"></span> You have joined <a href="#">BSCS4A-THESIS A.</a>
                    <br />
                    <small class="text-muted">
                      <i>Sep 04, 2017 08:24 AM</i>
                    </small>
                  </p>
                </a>
              </div>
            </div>

            <hr />

            <div class="row">
              <div class="col-md-12">
                <a class="notif-content" href="#">
                  <p>
                    <span class="fa fa-sign-out"></span> You have left BSCS4A-ADVANCE PHP.
                    <br />
                    <small class="text-muted">
                      <i>Sep 04, 2017 08:00 PM</i>
                    </small>
                  </p>
                </a>
              </div>
            </div>

            <hr />

            <div class="row">
              <div class="col-md-12">
                <a class="notif-content" href="#">
                  <p>
                    <span class="fa fa-remove"></span> You have cancelled your request from BSCS4A-CISCO.
                    <br />
                    <small class="text-muted">
                      <i>Sep 04, 2017 08:05 PM</i>
                    </small>
                  </p>
                </a>
              </div>
            </div>

            <hr />

            <div class="row">
              <div class="col-md-12">
                <a class="notif-content" href="#">
                  <p>
                    <span class="fa fa-cloud-download"></span> You have downloaded a backpack in <a href="#">BSCS4A-THESIS B.</a>
                    <br />
                    <small class="text-muted">
                      <i>Sep 05, 2017 09:05 AM</i>
                    </small>
                  </p>
                </a>
              </div>
            </div>

            <hr />

            <div class="row">
              <div class="col-md-12">
                <a class="notif-content" href="#">
                  <p>
                    <span class="fa fa-edit"></span> You have taken a quiz in <a href="#">BSCS4A-THESIS A.</a>
                    <br />
                    <small class="text-muted">
                      <i>Sep 04, 2017 09:05 PM</i>
                    </small>
                  </p>
                </a>
              </div>
            </div>

            <hr />

            <div class="row">
              <div class="col-md-12">
                <a class="notif-content" href="#">
                  <p>
                    <span class="fa fa-check"></span> You have submitted a quiz in <a href="#">BSCS4A-JAVA.</a>
                    <br />
                    <small class="text-muted">
                      <i>Sep 05, 2017 10:05 AM</i>
                    </small>
                  </p>
                </a>
              </div>
            </div>

            <hr />

            <div class="row">
              <div class="col-md-12">
                <a class="notif-content" href="#">
                  <p>
                    <span class="fa fa-check"></span> You have submitted an assignment in <a href="#">BSCS4A-THESIS B.</a>
                    <br />
                    <small class="text-muted">
                      <i>Sep 05, 2017 10:15 AM</i>
                    </small>
                  </p>
                </a>
              </div>
            </div>

            <hr />

            <div class="row">
              <div class="col-md-12">
                <a class="notif-content" href="#">
                  <p>
                    <span class="fa fa-thumbs-up"></span> You have liked the comment posted in <a href="#">BSCS4A-JAVA.</a>
                    <br />
                    <small class="text-muted">
                      <i>Sep 05, 2017 10:24 AM</i>
                    </small>
                  </p>
                </a>
              </div>
            </div>

            <hr />

            <div class="row">
              <div class="col-md-12">
                <a class="notif-content" href="#">
                  <p>
                    <span class="fa fa-trash"></span> You have deleted your reply in the comment posted in <a href="#">BSCS4A-THESIS A.</a>
                    <br />
                    <small class="text-muted">
                      <i>Sep 05, 2017 11:24 AM</i>
                    </small>
                  </p>
                </a>
              </div>
            </div>

            <hr />

            <div class="row">
              <div class="col-md-12">
                <a class="notif-content" href="#">
                  <p>
                    <span class="fa fa-thumbs-up"></span> You have liked an announcement posted in <a href="#">BSCS4A-JAVA.</a>
                    <br />
                    <small class="text-muted">
                      <i>Aug 8,2017 10:46 AM</i>
                    </small>
                  </p>
                </a>
              </div>
            </div>

            <hr />

          </div>

        </div>

      </div>

    </div>

  </div>

  <!-- Main Variables -->
  <script>
    var classroomId = <?php echo isset($_SESSION['classroom_id']) ? $_SESSION['classroom_id'] : '0' ?>;
    var myType = '<?php echo isset($_SESSION['type']) ? $_SESSION['type'] : '' ?>';
    var myId = <?php echo isset($_SESSION['id']) ? $_SESSION['id'] : '0' ?>;
    var myLogInId = <?php echo isset($_SESSION['log_in_id']) ? $_SESSION['log_in_id'] : '0' ?>;
  </script>

  <!-- Main Workers -->
  <script src="js/main_routing.js"></script>
  <script src="js/log_in_updater.js"></script>
  <script src="js/nav_manipulator.js"></script>

  <!-- Main Notification Worker -->
  <script src="js/notification/events/init.js"></script>
  <script src="js/notification/operations/retrieval.js"></script>

</body>

</html>