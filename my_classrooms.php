<!DOCTYPE html>
<?php
session_start();
?>
<html>

<head>

  <title>iSchool | My Classrooms</title>

  <?php
  require 'meta.php';
  ?>

  <style>
    [href="#join_modal"],
    [href="#add_modal"],
    [href="#request_modal"] {
      display: none;
    }

    #modal_button_panel .btn-link:hover,
    #modal_button_panel .btn-link:focus {
      background-color: #dfe3ee;
      border-radius: 25px;
    }

    #modal_button_panel .btn-link>span {
      font-size: 20px;
      color: #008f95;
    }

    #join_modal .modal_body,
    #request_modal .modal_body {
      max-height: 350px;
      overflow: auto;
    }

    [id^="srchcr"] hr {
      margin-top: 0;
    }

    [id^="srchcr"]:last-child hr {
      display: none;
    }

    [id^="reqcr"] {
      margin: 0;
    }

    [id^="reqcr"] .pull-right {
      padding: 10px 0;
    }

    [id^="reqcr"] p {
      margin: 0;
    }

    [id^="reqcr"] hr {
      margin: 5px 0;
    }

    [id^="reqcr"]:last-child>hr {
      display: none;
    }

    #request_load_more_button {
      margin: 10px 0;
    }

    #request_loading_panel>img {
      margin: 20px;
    }

    .panel-classroom:hover {
      background-color: rgba(96, 96, 96, 0.1);
      border-radius: 24px;
    }

    [id^="cr"] [name="time_remaining"] {
      color: green;
    }

    [id^="cr"] [name="num"] {
      color: #008f95;
    }

    [id^="cr"] [name="negative_button"] {
      font-size: 20px;
      color: #e24e42;
    }

    [id^="cr"] [name="classroom_name"] {
      font-size: 16px;
      font-weight: bold;
      color: #008f95;
    }

    [id^="cr"] [name="teacher_image"] {
      width: 30px;
      height: 30px;
    }

    [id^="cr"] [name="teacher_name"] {
      color: #008f95;
    }

    @media screen and (max-width: 768px) {

      .panel-body {
        padding: 15px 12px;
      }

      #details_modal>.modal-dialog {
        max-height: 510px;
      }

      #request_modal .full-screen-modal-body {
        bottom: 60px;
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
            My Classrooms
          </li>
        </ul>

        <div class="panel panel-default">

          <div class="panel-body">

            <div id="modal_button_panel">
              <a class="btn btn-link pull-right" href="#join_modal" type="button" data-toggle="modal">
                <span class="fa fa-plus-circle" title="Join Classroom" data-toggle="tooltip" data-placement="auto"></span>
              </a>
              <a class="btn btn-link pull-right" href="#add_modal" type="button" data-toggle="modal">
                <span class="fa fa-plus-circle" title="Add Classroom" data-toggle="tooltip" data-placement="auto"></span>
              </a>
              <a class="btn btn-link pull-right" href="#request_modal" type="button" data-toggle="modal">
                <span class="fa fa-users" title="Classroom Requests" data-toggle="tooltip" data-placement="auto"></span>
              </a>
            </div>

            <div class="clearfix"></div>

            <hr>

            <div id="classroom_panel" class="row">

            </div>

            <div id="empty_classroom_panel" class="text-center">
              <p>
                No current classroom. Try adding one and you can manage it.
                <span class="fa fa-plus-circle"></span>
              </p>
            </div>

          </div>

        </div>

      </div>

    </div>

  </div>

  <div id="join_modal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <button class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Join Classroom</h4>
        </div>

        <div class="modal-body">

          <form id="join_form" class="form-horizontal" role="form" autocomplete="off">

            <div class="form-group">
              <label class="control-label col-md-2" for="search">Search:</label>
              <div class="col-md-9">
                <div class="panel panel-default panel-gray">
                  <input name="search_bar" class="form-control" type="text" name="search" placeholder="Search classroom, or teacher" />
                  <div class="panel-body">
                    <div id="join_panel">

                    </div>
                    <div id="empty_join_panel">
                      <p class="text-center">Search a classroom and you can start joining on it.</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </form>

        </div>

        <div class="modal-footer">
          <button class="btn btn-danger" type="button" data-dismiss="modal">
            <span class="fa fa-remove"></span> Cancel
          </button>
        </div>

      </div>
    </div>
  </div>

  <div id="request_modal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content full-screen-modal-content">

        <div class="modal-header">
          <button class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Classroom Requests</h4>
        </div>

        <div class="modal-body full-screen-modal-body">
          <div id="request_panel">

          </div>
          <div id="request_loading_panel" class="text-center" style="display:none;margin-bottom:5px;">
            <img src="pictures/modules/loading.gif" style="width:20px;">
          </div>
          <div id="empty_request_panel" style="display:none;">
            <p class="text-center">No current request. Please come back later.</p>
          </div>
          <button id="request_load_more_button" class="btn btn-link btn-block" type="button" style="display:none;">Load More...</button>
        </div>

        <div class="modal-footer full-screen-modal-footer">
          <button class="btn btn-danger" type="button" data-dismiss="modal">
            <span class="fa fa-remove"></span> Close
          </button>
        </div>

      </div>
    </div>
  </div>

  <div id="add_modal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content full-screen-modal-content">

        <div class="modal-header">
          <button class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Classroom</h4>
        </div>

        <div class="modal-body full-screen-modal-body">

          <form id="add_form" class="form-horizontal" role="form" method="post" autocomplete="off">

            <div class="form-group has-feedback">
              <label class="control-label col-md-4" for="add_class_name">Class Name:</label>
              <div class="col-md-7">
                <input id="add_class_name" class="form-control" type="text" name="class_name" placeholder="Enter class name..." />
                <span class="glyphicon form-control-feedback"></span>
                <span class="help-block"></span>
              </div>
            </div>

            <div class="form-group has-feedback">
              <label class="control-label col-md-4" for="add_subject_name">Subject Name:</label>
              <div class="col-md-7">
                <input id="add_subject_name" class="form-control" type="text" name="subject_name" placeholder="Enter subject name..." />
                <span class="glyphicon form-control-feedback"></span>
                <span class="help-block"></span>
              </div>
            </div>

            <div class="form-group has-feedback">
              <label class="control-label col-md-4" for="add_date_range">End Date:</label>
              <div class="col-md-7">
                <input id="add_date_range" class="form-control" type="text" name="date_range" placeholder="Enter end date..." />
                <span class="glyphicon form-control-feedback"></span>
                <span class="help-block"><b>Format:</b> mm/dd/yyyy</span>
              </div>
            </div>

            <div class="form-group has-feedback">
              <label class="control-label col-md-4" for="add_description">Description:</label>
              <div class="col-md-7">
                <textarea id="add_description" class="form-control" name="description" rows="5" placeholder="Enter description here..."></textarea>
                <span class="glyphicon form-control-feedback"></span>
                <span class="help-block"></span>
              </div>
            </div>

          </form>

        </div>

        <div class="modal-footer full-screen-modal-footer">
          <button class="btn btn-success" name="save_button" type="submit" form="add_form">
            <span class="fa fa-plus-circle"></span> Add
          </button>
          <button class="btn btn-danger" type="button" data-dismiss="modal">
            <span class="fa fa-remove"></span> Cancel
          </button>
        </div>

      </div>
    </div>
  </div>

  <div id="leave_modal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header bg-danger">
          <button class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title text-danger">Warning!</h4>
        </div>

        <div class="modal-body">
          <p class="lead text-center" name="message" style="margin-bottom:10px;"></p>
          <small name="note"></small>
        </div>

        <div class="modal-footer">
          <button class="btn btn-success" name="delete_confirm_button" type="button" data-dismiss="modal">
            <span class="fa fa-check"></span> Yes
          </button>
          <button class="btn btn-danger" type="button" data-dismiss="modal">
            <span class="fa fa-remove"></span> No
          </button>
        </div>

      </div>
    </div>
  </div>

  <div id="details_modal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <button class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Classroom Details</h4>
        </div>

        <div class="modal-body">

          <p class="lead text-center">You have successfully created a classroom!</p>

          <form id="details_form" class="form-horizontal" role="form" autocomplete="off">

            <div class="form-group">
              <label class="control-label col-md-4 col-md-offset-2">Classroom Name:</label>
              <p class="form-control-static col-md-6" name="classroom_name">Classroom Name</p>
            </div>

            <div class="form-group">
              <label class="control-label col-md-4 col-md-offset-2">Class Name:</label>
              <p class="form-control-static col-md-6" name="class_name">Class Name</p>
            </div>

            <div class="form-group">
              <label class="control-label col-md-4 col-md-offset-2">Subject Name:</label>
              <p class="form-control-static col-md-6" name="subject_name">Subject Name</p>
            </div>

            <div class="form-group">
              <label class="control-label col-md-4 col-md-offset-2">End Date:</label>
              <p class="form-control-static col-md-6" name="date_range">End Date</p>
            </div>

          </form>

        </div>

        <div class="modal-footer">
          <button class="btn btn-success" type="button" name="go_button">
            <span class="fa fa-arrow-circle-right"></span> Go to classroom
          </button>
          <button class="btn btn-danger" type="button" data-dismiss="modal">
            <span class="fa fa-remove"></span> Close
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
          <div class="row">
            <div class="col-md-12 col-xs-12">
              <p class="text-center" name="message">Please wait for the approval of the teacher!</p>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button id="close_button" class="btn btn-success btn-sm" type="button" name="ok_button" data-dismiss="modal">
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
    var myImage = '<?php echo isset($_SESSION['image']) ? $_SESSION['image'] : '' ?>';
    var myName = '<?php echo isset($_SESSION['id']) ? $_SESSION['first_name'] . ' ' . $_SESSION['middle_name'] . ' ' . $_SESSION['last_name'] : '' ?>';
    var myLogInId = <?php echo isset($_SESSION['log_in_id']) ? $_SESSION['log_in_id'] : '0' ?>;
  </script>

  <!-- Main Workers -->
  <script src="js/main_routing.js"></script>
  <script src="js/log_in_updater.js"></script>
  <script src="js/unset_classroom.js"></script>
  <script src="js/nav_manipulator.js"></script>

  <!-- Utilities -->
  <script src="js/utilities/viewport.js"></script>
  <script src="js/utilities/input.js"></script>
  <script src="js/utilities/date.js"></script>

  <!-- Main Notification Worker -->
  <script src="js/notification/events/init.js"></script>
  <script src="js/notification/operations/retrieval.js"></script>

  <!-- Classroom Workers -->
  <script src="js/classroom/variables.js"></script>
  <script src="js/classroom/nodes.js"></script>
  <script src="js/classroom/resets.js"></script>
  <script src="js/classroom/view.js"></script>
  <script src="js/classroom/displays.js"></script>
  <script src="js/classroom/operations/retrieval.js"></script>
  <script src="js/classroom/operations/manipulation.js"></script>
  <script src="js/classroom/events/init.js"></script>
  <script src="js/classroom/events/creation.js"></script>
  <script src="js/classroom/events/deleting.js"></script>
  <script src="js/classroom/events/joining.js"></script>
  <script src="js/classroom/events/requesting.js"></script>
  <script src="js/classroom/events/content.js"></script>

</body>

</html>