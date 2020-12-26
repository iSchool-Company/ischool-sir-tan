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
      background-color: #bcc5dd;
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
      padding: 10px 0;
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
            Notifications
          </li>
        </ul>

        <div class="panel panel-default">

          <div class="panel-body">

            <div id="notification_panel">

            </div>

            <div id="empty_notification_panel" style="display:nones;">
              <p class="text-center">
                Doesn't have any notification yet.
              </p>
            </div>

            <button id="load_more_button" class="btn btn-link btn-block text-main-green" type="button" style="display:none; margin-top:20px;">
              Load More
            </button>

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
  <script src="js/unset_classroom.js"></script>

  <!-- Main Notification Worker -->
  <script src="js/notification/events/init.js"></script>
  <script src="js/notification/operations/retrieval.js"></script>

  <!-- Notification Workers -->
  <script src="js/notif/variables.js"></script>
  <script src="js/notif/displays.js"></script>
  <script src="js/notif/nodes.js"></script>
  <script src="js/notif/events/init.js"></script>
  <script src="js/notif/operations/retrieval.js"></script>
  <script src="js/notif/operations/manipulation.js"></script>

</body>

</html>