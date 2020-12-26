<!DOCTYPE html>
<?php
session_start();
?>
<html>

<head>

  <title>iSchool | Materials</title>

  <?php
  require 'meta.php';
  ?>

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
            Materials
          </li>
        </ul>

        <div class="panel panel-default">
          <div class="panel-body">

            <button class="btn btn-success pull-right" type="button" data-toggle="modal" data-target="#add_modal" style="display:none;">
              <span class="fa fa-plus-circle"></span> Add Materials
            </button>

            <br style="clear:both;" />

            <hr />

            <div class="row" style="display:none;">
              <div class="col-md-1 hidden-xs">
                <h4><span class="fa fa-hashtag"></span></h4>
              </div>
              <div class="col-md-4 hidden-xs">
                <h4>File Name</h4>
              </div>
              <div class="col-md-2 hidden-xs">
                <h4>File Type</h4>
              </div>
              <div class="col-md-3 hidden-xs">
                <h4>Date Posted</h4>
              </div>
              <div class="col-md-2 hidden-xs">
              </div>
            </div>

            <div id="materials_panel">
            </div>

            <div id="empty_materials_panel" style="display:none;">
              <p class="text-center">
                Add materials and your students can study it.
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
      <div class="modal-content">

        <div class="modal-header">
          <button class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Material</h4>
        </div>

        <div class="modal-body">

          <form id="add_form" role="form" autocomplete="off">

            <div class="form-group has-feedback">
              <label>Topic:</label>
              <input class="form-control" name="topic" type="text" placeholder="Enter topic here..." autofocus />
              <span class="glyphicon form-control-feedback"></span>
              <span class="help-block"></span>
            </div>

            <div class="form-group has-feedback">
              <label style="display:block;">File to be added:</label>
              <button class="btn btn-success" name="file" type="button">
                Choose File
              </button>
              <input type="file" name="file_r" accept=".doc, .docx, .ppt, .pptx, .xls, .xlsx, .pdf, .txt" style="display:none;">
              <span name="file_name"></span>
              <i name="file_msg">No file chosen</i>
              <span class="help-block"></span>
            </div>

          </form>

        </div>

        <div class="modal-footer">
          <button class="btn btn-success" type="button" name="confirm_button">
            <span class="fa fa-plus-circle"></span> Add
          </button>
          <button class="btn btn-danger" type="button" data-dismiss="modal">
            <span class="fa fa-remove"></span> Cancel
          </button>
        </div>

      </div>
    </div>
  </div>

  <div id="edit_modal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <button class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Material</h4>
        </div>

        <div class="modal-body">

          <form id="edit_form" role="form" autocomplete="off">

            <div class="form-group has-feedback">
              <label>Topic:</label>
              <input class="form-control" name="topic" type="text" placeholder="Enter topic here..." autofocus />
              <span class="glyphicon form-control-feedback"></span>
              <span class="help-block"></span>
            </div>

            <div class="form-group">
              <label style="display:block;">File to be added:</label>
              <button class="btn btn-success" name="file" type="button">
                Choose File
              </button>
              <input type="file" name="file_r" accept=".doc, .docx, .ppt, .pptx, .xls, .xlsx, .pdf, .txt" style="display:none;">
              <span name="file_name"></span>
              <i name="file_msg">No file chosen</i>
            </div>

          </form>

        </div>

        <div class="modal-footer">
          <button class="btn btn-success" type="button" name="confirm_button">
            <span class="fa fa-save"></span> Save
          </button>
          <button class="btn btn-danger" type="button" data-dismiss="modal">
            <span class="fa fa-remove"></span> Cancel
          </button>
        </div>

      </div>
    </div>
  </div>

  <div id="pin_modal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <button class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Pin Assignment</h4>
        </div>

        <div class="modal-body">

          <form id="pin_form" role="form" autocomplete="off">

            <div class="form-group has-feedback">
              <label>Choose Classroom:</label>
              <select class="form-control" name="classrooms">
              </select>
            </div>

          </form>

        </div>

        <div class="modal-footer">
          <button class="btn btn-success" type="button" name="confirm_button">
            <span class="fa fa-thumb-tack"></span> Pin
          </button>
          <button class="btn btn-danger" type="button" data-dismiss="modal">
            <span class="fa fa-remove"></span> Cancel
          </button>
        </div>

      </div>
    </div>
  </div>

  <div id="delete_modal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header bg-danger">
          <button class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title text-danger">Warning!</h4>
        </div>

        <div class="modal-body">
          <p class="lead text-center">Are you sure you want to delete this file?</p>
        </div>

        <div class="modal-footer">
          <button class="btn btn-success" type="button" name="confirm_button">
            <span class="fa fa-check"></span> Confirm
          </button>
          <button class="btn btn-danger" type="button" data-dismiss="modal">
            <span class="fa fa-remove"></span> Cancel
          </button>
        </div>

      </div>
    </div>
  </div>

  <div id="loading_modal" class="modal fade" data-backdrop="static" data-keyboard="false">
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
  <script src="js/utilities/files.js"></script>
  <script src="js/utilities/viewport.js"></script>
  <script src="js/utilities/input.js"></script>

  <!-- Main Notification Worker -->
  <script src="js/notification/events/init.js"></script>
  <script src="js/notification/operations/retrieval.js"></script>

  <!-- Classroom Workers -->
  <script src="js/classroom_notification_manager.js"></script>
  <script src="js/classroom_breadcrumb_manager.js"></script>
  <script src="js/my_classroom_display_manager.js"></script>

  <!-- Materials Workers -->
  <script src="js/materials/variables.js"></script>
  <script src="js/materials/nodes.js"></script>
  <script src="js/materials/resets.js"></script>
  <script src="js/materials/view.js"></script>
  <script src="js/materials/displays.js"></script>
  <script src="js/materials/operations/retrieval.js"></script>
  <script src="js/materials/operations/manipulation.js"></script>
  <script src="js/materials/events/init.js"></script>
  <script src="js/materials/events/creation.js"></script>
  <script src="js/materials/events/editing.js"></script>
  <script src="js/materials/events/deleting.js"></script>
  <script src="js/materials/events/backpacking.js"></script>
  <script src="js/materials/events/pinning.js"></script>

</body>

</html>