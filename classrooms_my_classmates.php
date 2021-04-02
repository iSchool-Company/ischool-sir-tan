<!DOCTYPE html>
<?php
session_start();
?>
<html>

<head>

  <title>LMS | My Classmates</title>

  <?php
  require 'meta.php';
  ?>

  <style>
    .tooltip-inner {
      white-space: nowrap;
      max-width: none;
    }

    .panel-student:hover {
      background-color: rgba(96, 96, 96, 0.1);
      border-radius: 24px;
    }

    [id^="students"]>.panel-default::before {
      position: absolute;
      top: -1px;
      right: 85px;
      border-top: 15px solid #008f95;
      border-left: 15px solid #008f95;
      border-right: 15px solid #008f95;
      border-bottom: 15px solid transparent;
      content: " ";
      height: 45px;
    }

    @media screen and (max-width: 768px) {

      #add_button {
        margin-top: 15px;
      }

      [id^="students"]>.panel-default::before {
        right: 55px;
        border-top: 12px solid #008f95;
        border-left: 12px solid #008f95;
        border-right: 12px solid #008f95;
        border-bottom: 15px solid transparent;
        content: " ";
        height: 10px;
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
            My Classmates
          </li>
        </ul>

        <div class="panel panel-default">

          <div class="panel-body">

            <form id="find_form" class="form-horizontal" autocomplete="off">

              <div class="form-group row">

                <div class="col-md-4 col-xs-12">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="fa fa-search"></i>
                    </span>
                    <input class="form-control" type="text" name="search" placeholder="Search student...">
                  </div>
                </div>

                <div class="col-md-2 col-xs-12 col-md-offset-6">
                  <button id="add_button" class="btn btn-success pull-right" data-target="#add_modal" type="button" data-toggle="modal" style="display:none;">
                    <span class="fa fa-plus-circle"></span> Add Student
                  </button>
                </div>

              </div>

            </form>

            <hr>

            <div id="student_panel" class="row">

            </div>

            <div id="empty_student_panel" style="display:none;">
              <p class="text-center">
                Add a student and you can start discussions.
                <span class="fa fa-plus-circle"></span>
              </p>
            </div>

          </div>

        </div>

      </div>

    </div>

  </div>

  <div id="add_modal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content full-screen-modal-content">

        <div class="modal-header">
          <button class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Student</h4>
        </div>

        <div class="modal-body full-screen-modal-body">

          <form id="search_form" class="form-horizontal" role="form" autocomplete="off">

            <div class="form-group row">
              <label class="control-label col-md-2" for="search">Search:</label>
              <div class="col-md-9">

                <div class="panel panel-default panel-gray">

                  <input class="form-control" type="text" name="search" placeholder="Search student..." />

                  <div class="panel-body">

                    <div id="search_panel">

                    </div>

                    <div id="empty_search_panel">
                      Search a student and you can start adding them. <span class="fa fa-user"></span>
                    </div>

                  </div>

                </div>

              </div>
            </div>

          </form>

        </div>

        <div class="modal-footer full-screen-modal-footer">
          <button class="btn btn-danger" type="button" data-dismiss="modal">
            <span class="fa fa-remove"></span> Cancel
          </button>
        </div>

      </div>
    </div>
  </div>

  <div id="remove_modal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header bg-danger">
          <button class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title text-danger">Warning!</h4>
        </div>

        <div class="modal-body">
          <p class="lead text-center">Are you sure you want to remove the student from this classroom?</p>
          <small>
            <strong>Note:</strong> Once you remove this student, he can no longer receive notifications and go to this classroom.
          </small>
        </div>

        <div class="modal-footer">
          <button class="btn btn-success" type="button" name="confirm_button" data-dismiss="modal">
            <span class="fa fa-check"></span> Yes
          </button>
          <button class="btn btn-danger" type="button" data-dismiss="modal">
            <span class="fa fa-remove"></span> No
          </button>
        </div>

      </div>
    </div>
  </div>

  <div id="loading_modal" class="modal fade" style="margin-top:72px;" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">

        <div class="modal-body">
          <div class="text-center">
            <img src="pictures/modules/loading2.gif" style="width:50px;">
            <h4>Please Wait.....</h4>
          </div>
        </div>

      </div>
    </div>
  </div>

  <div id="prompt_modal" class="modal fade">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">

        <div class="modal-body">
          <p class="text-center" name="message"></p>
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
    var classroomId = <?php echo isset($_SESSION['classroom_id']) ? $_SESSION['classroom_id'] : '0' ?>;
    var myType = '<?php echo isset($_SESSION['type']) ? $_SESSION['type'] : '' ?>';
    var myId = <?php echo isset($_SESSION['id']) ? $_SESSION['id'] : '0' ?>;
    var myLogInId = <?php echo isset($_SESSION['log_in_id']) ? $_SESSION['log_in_id'] : '0' ?>;
    var crStatus = '';

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

  <!-- Utilities -->
  <script src="js/utilities/viewport.js"></script>

  <!-- Main Notification Worker -->
  <script src="js/notification/events/init.js"></script>
  <script src="js/notification/operations/retrieval.js"></script>

  <!-- Classroom Workers -->
  <script src="js/classroom_notification_manager.js"></script>
  <script src="js/classroom_breadcrumb_manager.js"></script>
  <script src="js/my_classroom_display_manager.js"></script>

  <!-- Notification Workers -->
  <script src="js/my_classmates_notif_monitor.js"></script>

  <!-- Student Workers -->
  <script src="js/student/view.js"></script>
  <script src="js/student/variables.js"></script>
  <script src="js/student/nodes.js"></script>
  <script src="js/student/displays.js"></script>
  <script src="js/student/resets.js"></script>
  <script src="js/student/operations/retrieval.js"></script>
  <script src="js/student/operations/manipulation.js"></script>
  <script src="js/student/events/init.js"></script>
  <script src="js/student/events/searching.js"></script>
  <script src="js/student/events/deleting.js"></script>
  <script src="js/student/events/adding.js"></script>

</body>

</html>