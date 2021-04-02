<!DOCTYPE html>
<?php
session_start();
?>
<html>

<head>

  <title>LMS | Backpack</title>

  <?php
  require 'meta.php';
  ?>

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
            Backpack
          </li>
        </ul>

        <div class="panel panel-default">
          <div class="panel-body">

            <button class="btn btn-success pull-right" type="button" data-toggle="modal" data-target="#add_modal">
              <span class="fa fa-plus-circle"></span> Add File
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

            <div id="backpack_panel">

            </div>

            <div id="empty_backpack_panel" style="display:none;">
              <p class="text-center">
                You can store files here.
                <span class="fa fa-briefcase"></span>
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
          <h4 class="modal-title">Add to Backpack</h4>
        </div>

        <div class="modal-body">

          <form id="add_form" role="form" autocomplete="off">

            <div class="form-group has-feedback">
              <label>File Name:</label>
              <input class="form-control" name="file_name_r" type="text" placeholder="Enter topic here..." autofocus />
              <span class="glyphicon form-control-feedback"></span>
              <span class="help-block"></span>
            </div>

            <div class="form-group has-feedback">
              <label style="display:block;">File:</label>
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
          <h4 class="modal-title">Edit File</h4>
        </div>

        <div class="modal-body">

          <form id="edit_form" role="form" autocomplete="off">

            <div class="form-group has-feedback">
              <label>File Name:</label>
              <input class="form-control" name="file_name_r" type="text" placeholder="Enter topic here..." autofocus />
              <span class="glyphicon form-control-feedback"></span>
              <span class="help-block"></span>
            </div>

            <div class="form-group has-feedback">
              <label style="display:block;">File:</label>
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
          <h4 class="modal-title">Pin File</h4>
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
          <small>
            <strong>Note:</strong> Once you delete this file, you cannot undo it. The files that you pinned to classroom won't be affected.
          </small>
        </div>

        <div class="modal-footer">
          <button class="btn btn-success" type="button" name="confirm_button">
            <span class="fa fa-check"></span> Yes
          </button>
          <button class="btn btn-danger" type="button" data-dismiss="modal">
            <span class="fa fa-remove"></span> No
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
          <button class="btn btn-success btn-sm" href="#" type="button" name="ok_button" data-dismiss="modal">
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
  </script>

  <!-- Main Workers -->
  <script src="js/main_routing.js"></script>
  <script src="js/log_in_updater.js"></script>
  <script src="js/nav_manipulator.js"></script>

  <!-- Utilities -->
  <script src="js/utilities/files.js"></script>
  <script src="js/utilities/input.js"></script>
  <script src="js/utilities/viewport.js"></script>

  <!-- Main Notification Worker -->
  <script src="js/notification/events/init.js"></script>
  <script src="js/notification/operations/retrieval.js"></script>

  <!-- Materials Workers -->
  <script src="js/backpack/variables.js"></script>
  <script src="js/backpack/nodes.js"></script>
  <script src="js/backpack/resets.js"></script>
  <script src="js/backpack/displays.js"></script>
  <script src="js/backpack/operations/retrieval.js"></script>
  <script src="js/backpack/operations/manipulation.js"></script>
  <script src="js/backpack/events/init.js"></script>
  <script src="js/backpack/events/adding.js"></script>
  <script src="js/backpack/events/editing.js"></script>
  <script src="js/backpack/events/deleting.js"></script>
  <script src="js/backpack/events/pinning.js"></script>

</body>

</html>