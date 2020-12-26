<!DOCTYPE html>
<?php
session_start();
?>
<html>

<head>

  <title>iSchool | My Progress</title>

  <?php
  require 'meta.php';
  ?>

  <style>
    h4 {
      margin-top: 0;
    }

    .timeline-left {
      margin-right: 46%;
      padding-right: 15px;
      padding-left: 15px;
    }

    .timeline-right {
      margin-left: 46%;
      padding-right: 15px;
      padding-left: 15px;
    }

    .timeline-left::before,
    .timeline-right::before {
      top: 53px;
      bottom: 0;
      position: absolute;
      content: " ";
      width: 3px;
      background-color: #008f95;
      left: 50%;
      margin-bottom: 1.7%;
      box-shadow: 1px 1px 5px grey;
    }

    .img-circle-left {
      height: 60px;
      width: 60px;
      color: #f7f7f7;
      position: relative;
      background-color: #eb6e80;
      border-radius: 50%;
      z-index: 1;
      clear: both;
      float: right;
      box-shadow: 5px 5px 5px grey;
    }

    .img-circle-right {
      height: 60px;
      width: 60px;
      color: #f7f7f7;
      position: relative;
      background-color: #e9b000;
      border-radius: 50%;
      clear: both;
      z-index: 1;
      float: left;
      box-shadow: 5px 5px 5px grey;
    }

    .icon-left {
      font-size: 35px;
      position: absolute;
      left: 14px;
      top: 12px;
    }

    .icon-right {
      font-size: 35px;
      position: absolute;
      left: 12px;
      top: 12px;
    }

    .progress-left {
      float: right;
      border: 1px solid #008f95;
      border-radius: 25px;
      padding: 20px;
      position: relative;
      max-width: 85%;
      margin-bottom: 50px;
      margin-right: 25px;
      box-shadow: 2px 2px 5px grey;
    }

    .progress-right {
      float: left;
      border: 1px solid #008f95;
      border-radius: 25px;
      padding: 20px;
      position: relative;
      max-width: 85%;
      margin-bottom: 50px;
      margin-left: 25px;
      box-shadow: 2px 2px 5px grey;
    }

    .progress-left::before {
      position: absolute;
      top: 20px;
      right: -15px;
      border-top: 15px solid transparent;
      border-left: 15px solid #008f95;
      border-bottom: 15px solid transparent;
      content: " ";
    }

    .progress-right::before {
      position: absolute;
      top: 20px;
      left: -15px;
      border-top: 15px solid transparent;
      border-right: 15px solid #008f95;
      border-bottom: 15px solid transparent;
      content: " ";
    }

    @media screen and (max-width: 768px) {

      .timeline-left {
        margin-right: 0;
        padding-right: 0;
        padding-left: 0;
      }

      .timeline-right {
        margin-left: 0;
        padding-right: 0;
        padding-left: 0;
      }

      .timeline-left::before,
      .timeline-right::before {
        top: 70px;
        left: 40px;
        margin-bottom: 0;
        box-shadow: 1px 1px 4px grey;
      }

      .img-circle-left {
        height: 40px;
        width: 40px;
        top: 15px;
        float: left;
        margin-left: 15px;
        box-shadow: 1px 1px 4px grey;
      }

      .img-circle-right {
        height: 40px;
        width: 40px;
        top: 15px;
        float: left;
        margin-left: 15px;
        box-shadow: 1px 1px 4px grey;
      }

      .icon-left {
        font-size: 25px;
        left: 9px;
        top: 7px;
      }

      .icon-right {
        font-size: 25px;
        left: 7px;
        top: 8px;
      }

      .progress-left {
        float: left;
        padding: 20px;
        left: 20px;
        max-width: 70%;
        margin-bottom: 20px;
        margin-right: 0;
        box-shadow: 1px 1px 4px grey;
      }

      .progress-right {
        float: left;
        padding: 20px;
        left: 20px;
        max-width: 70%;
        margin-bottom: 20px;
        margin-left: 0;
        box-shadow: 1px 1px 4px grey;
      }

      .progress-left::before {
        right: 100%;
        border-left: 15px solid transparent;
        border-right: 15px solid #008f95;
      }

    }
  </style>

</head>

<body>

  <?php
  require 'classroom_header.php';
  ?>

  <div class="container-fluid">

    <div class="row">

      <?php
      require 'classrooms_sidebar.php';
      ?>

      <div class="col-md-11 col-sm-11 main-container">

        <ul class="breadcrumb">
          <li>
            <a class="text-main-green" href="my_classrooms.php" style="z-index:8; position:relative;">
              My Classrooms
            </a>
          </li>
          <li>
            <a id="classroom_name" class="text-main-green" href="classrooms_subject_overview.php"></a>
          </li>
          <li class="active">
            My Progress
          </li>
        </ul>

        <div class="panel panel-default">
          <div class="panel-body">

            <div id="progress_panel">
            </div>

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

    $(document).ready(function() {
      $('#back').hover(function() {
        $('.breadcrumb [href="my_classrooms.php"]').css('z-index', '6');
      }, function() {
        setTimeout(function() {
          $('.breadcrumb [href="my_classrooms.php"]').css('z-index', '8');
        }, 300);
      });
    });
  </script>

  <!-- Main Workers -->
  <script src="js/main_routing.js"></script>
  <script src="js/log_in_updater.js"></script>
  <script src="js/nav_manipulator.js"></script>

  <!-- Main Notification Worker -->
  <script src="js/notification/events/init.js"></script>
  <script src="js/notification/operations/retrieval.js"></script>

  <!-- Classroom Workers -->
  <script src="js/classroom_notification_manager.js"></script>
  <script src="js/classroom_breadcrumb_manager.js"></script>
  <script src="js/my_classroom_display_manager.js"></script>

  <!-- Materials Workers -->
  <script src="js/progress/nodes.js"></script>
  <script src="js/progress/display_manager.js"></script>

</body>

</html>