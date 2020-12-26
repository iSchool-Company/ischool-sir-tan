<!DOCTYPE html>
<?php
session_start();
?>
<html>

<head>

  <title>iSchool | Assignments</title>

  <?php
  require 'meta.php';
  ?>

  <style>
    #add_assignment,
    [name="due_date_fg"] {
      display: none;
    }

    [id^="assmt"] [name="assmt_dropdown"] {
      float: right;
    }

    [name="time_remaining"] {
      color: green;
    }

    #submissions_modal .form-group>p {
      padding: 0;
      margin: 5px 15px;
      float: left;
      width: 65px;
    }

    #submissions_modal .form-group>select {
      width: 200px;
    }

    [data-target="#report_modal"] {
      margin: 0 15px;
    }

    @media screen and (max-width: 768px) {

      #assignment_panel .panel-body {
        padding: 15px 10px;
      }

      [name="assmt_dropdown"]>.btn-link {
        padding: 0;
        border: none;
      }

      #submissions_modal .form-group>select {
        width: 200px;
      }

      [data-target="#report_modal"] {
        margin-top: 15px;
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
          <li id="ass_bc" class="active">
            Assignments
          </li>
        </ul>

        <div class="panel panel-default">

          <div class="panel-body">

            <div id="assignment_content_panel" value="0" style="display:none;">

              <button id="assignment_back_button" class="btn btn-link" type="button" style="z-index:8; position:relative;">
                <span class="fa fa-chevron-left"></span>
              </button>

              <button class="btn btn-success pull-right" type="button" data-toggle="modal" data-target="#submissions_modal" style="display:none;">
                <span class="fa fa-check"></span> Submissions
              </button>

              <button id="submit_button" class="btn btn-success pull-right" type="button" data-toggle="modal" data-target="#submit_modal" style="display:none;">
                <span class="fa fa-check"></span> <span name="text">Submit</span>
              </button>

              <br style="clear:both;" />

              <hr>

              <div id="manage_button" class="dropdown pull-right" style="display:none;">
                <button class="btn btn-link dropdown-toggle text-main-green" type="button" data-toggle="dropdown" style="text-decoration:none;">
                  <span class="fa fa-gear" style="font-size:16px;"></span> <span class="fa fa-chevron-down"></span>
                </button>
                <ul class="dropdown-menu dropdown-menu-right">
                  <li>
                    <a href="#publish_modal" data-toggle="modal" name="publish_button" style="display:none;">
                    </a>
                  </li>
                  <li>
                    <a href="#edit_modal" data-toggle="modal" name="edit_button" style="display:none;">
                      <span class="fa fa-pencil"></span> <span class="text-main-black">Edit</span>
                    </a>
                  </li>
                  <li>
                    <a href="#x" name="backpack_button" data-toggle="modal" style="display:none;">
                      <span class="fa fa-briefcase"></span> <span class="text-main-black">Add to Backpack</span>
                    </a>
                  </li>
                  <li>
                    <a href="#pin_modal" name="pin_button" data-toggle="modal">
                      <span class="fa fa-thumb-tack"></span> <span class="text-main-black">Pin</span>
                    </a>
                  </li>
                  <li>
                    <a href="#delete_modal" data-toggle="modal" name="delete_button">
                      <span class="fa fa-trash text-main-red"></span> <span class="text-main-black">Delete</span>
                    </a>
                  </li>
                </ul>
              </div>

              <h3>
                <span name="title">---</span>
              </h3>

              <p>
                <b style="font-size:16px;">Status:</b>
                <span class="fa fa-circle" name="status_color" style="color:gray;"></span>
                <span name="status">---</span>
              </p>

              <p style="display:none;margin-left:5px;">
                <b>Date Created:</b> <span name="date_time_created">---</span>
              </p>

              <p style="margin-left:5px;">
                <b>Date Published:</b> <span name="date_time_published">---</span>
              </p>

              <p style="margin-left:5px;">
                <b>Due Date:</b> <span name="due_date">---</span>
                <br class="visible-xs" />
                <small name="time_remaining">---</small>
              </p>

              <p style="margin-left:5px;">
                <b>Attached File:</b>
                <span class="fa fa-file-word-o" name="attachment_icon" style="font-size:20px;"></span>&nbsp;
                <a href="#" name="file" data-toggle="tooltip" data-placement="auto" title="Click to Download">
                  ---
                </a>
              </p>

              <b style="margin-left:5px;">Description:</b>
              <p name="description" style="margin-left:15px;">---</p>

            </div>

            <div id="assignment_main_panel">

              <div id="add_assignment">
                <button class="btn btn-success pull-right" data-target="#add_modal" type="button" data-toggle="modal">
                  <span class="fa fa-plus-circle"></span> Add Assignment
                </button>
              </div>

              <br style="clear:both;" />

              <hr>

              <div id="assignment_panel">

              </div>

              <div id="empty_assignment_panel">
                <p class="text-center">
                  Add an assignment and you can choose where to publish it.
                  <span class="fa fa-plus-circle"></span>
                </p>
              </div>

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
          <h4 class="modal-title">Add Assignment</h4>
        </div>

        <div class="modal-body full-screen-modal-body">

          <form id="add_form" role="form" autocomplete="off">

            <div class="form-group has-feedback">
              <label>Title:</label>
              <input class="form-control" type="text" name="title" placeholder="Enter title here..." />
              <span class="glyphicon form-control-feedback"></span>
              <span class="help-block"></span>
            </div>

            <div class="form-group has-feedback">
              <label>Description:</label>
              <textarea class="form-control" type="text" name="description" placeholder="Enter description here..." /></textarea>
              <span class="glyphicon form-control-feedback"></span>
              <span class="help-block"></span>
            </div>

            <div class="form-group">
              <label style="display:block;">Additional File:</label>
              <button class="btn btn-success" name="file" type="button">
                Choose File
              </button>
              <input type="file" name="file_r" accept=".doc, .docx, .ppt, .pptx, .xls, .xlsx, .pdf, .txt" style="display:none;">
              <i name="file_msg">No file chosen</i>
              <span name="file_name"></span>
            </div>

            <div class="form-group">
              <div class="checkbox text-center">
                <label>
                  <input type="checkbox" name="publish" />
                  Publish now?
                </label>
              </div>
            </div>

            <div class="form-group has-feedback" name="due_date_fg">
              <label>Due Date:</label>
              <div class="row">
                <div class="col-md-6">
                  <input class="form-control" type="text" name="due_date" placeholder="Enter due date here..." />
                  <span class="glyphicon form-control-feedback" style="right:15px;"></span>
                  <span class="help-block"><b>Format:</b> mm/dd/yyyy</span>
                </div>
                <div class="col-md-6">
                  <select class="form-control" name="due_time">
                    <option disabled>---Morning---</option>
                    <option value="00:00:00">12:00 am</option>
                    <option value="01:00:00">1:00 am</option>
                    <option value="02:00:00">2:00 am</option>
                    <option value="03:00:00">3:00 am</option>
                    <option value="04:00:00">4:00 am</option>
                    <option value="05:00:00">5:00 am</option>
                    <option value="06:00:00">6:00 am</option>
                    <option value="07:00:00">7:00 am</option>
                    <option value="08:00:00">8:00 am</option>
                    <option value="09:00:00">9:00 am</option>
                    <option value="10:00:00">10:00 am</option>
                    <option value="11:00:00">11:00 am</option>
                    <option disabled>---Afternoon---</option>
                    <option value="12:00:00">12:00 pm</option>
                    <option value="13:00:00">1:00 pm</option>
                    <option value="14:00:00">2:00 pm</option>
                    <option value="15:00:00">3:00 pm</option>
                    <option value="16:00:00">4:00 pm</option>
                    <option value="17:00:00">5:00 pm</option>
                    <option value="18:00:00">6:00 pm</option>
                    <option value="19:00:00">7:00 pm</option>
                    <option value="20:00:00">8:00 pm</option>
                    <option value="21:00:00">9:00 pm</option>
                    <option value="22:00:00">10:00 pm</option>
                    <option value="23:00:00">11:00 pm</option>
                  </select>
                </div>
              </div>
            </div>

          </form>

        </div>

        <div class="modal-footer full-screen-modal-footer">
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

  <div id="publish_modal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <button class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Publish Assignment</h4>
        </div>

        <div class="modal-body">

          <form id="publish_form" class="form" autocomplete="off">

            <div class="form-group has-feedback">
              <label>Due Date:</label>
              <div class="row">
                <div class="col-md-6">
                  <input class="form-control" name="due_date" placeholder="Enter due date here..." />
                  <span class="glyphicon form-control-feedback" style="right:15px;"></span>
                  <span class="help-block"><b>Format:</b> mm/dd/yyyy</span>
                </div>
                <div class="col-md-6">
                  <select class="form-control" name="due_time">
                    <option disabled>---Morning---</option>
                    <option value="00:00:00">12:00 am</option>
                    <option value="01:00:00">1:00 am</option>
                    <option value="02:00:00">2:00 am</option>
                    <option value="03:00:00">3:00 am</option>
                    <option value="04:00:00">4:00 am</option>
                    <option value="05:00:00">5:00 am</option>
                    <option value="06:00:00">6:00 am</option>
                    <option value="07:00:00">7:00 am</option>
                    <option value="08:00:00">8:00 am</option>
                    <option value="09:00:00">9:00 am</option>
                    <option value="10:00:00">10:00 am</option>
                    <option value="11:00:00">11:00 am</option>
                    <option disabled>---Afternoon---</option>
                    <option value="12:00:00">12:00 pm</option>
                    <option value="13:00:00">1:00 pm</option>
                    <option value="14:00:00">2:00 pm</option>
                    <option value="15:00:00">3:00 pm</option>
                    <option value="16:00:00">4:00 pm</option>
                    <option value="17:00:00">5:00 pm</option>
                    <option value="18:00:00">6:00 pm</option>
                    <option value="19:00:00">7:00 pm</option>
                    <option value="20:00:00">8:00 pm</option>
                    <option value="21:00:00">9:00 pm</option>
                    <option value="22:00:00">10:00 pm</option>
                    <option value="23:00:00">11:00 pm</option>
                  </select>
                </div>
              </div>
            </div>

          </form>

          <div id="publish_message" style="display:none;">
            <p class="lead text-center">Are you sure you want to unpublish this assignment?</p>
          </div>

        </div>

        <div class="modal-footer">
          <button class="btn btn-success" type="button" name="confirm_button">
            <span class="fa fa-eye"></span> Publish
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
          <h4 class="modal-title">Edit Assignment</h4>
        </div>

        <div class="modal-body">

          <form id="edit_form" role="form" autocomplete="off">

            <div class="form-group has-feedback">
              <label>Title:</label>
              <input class="form-control" type="text" name="title" placeholder="Enter title here..." />
              <span class="glyphicon form-control-feedback"></span>
              <span class="help-block"></span>
            </div>

            <div class="form-group has-feedback">
              <label>Description:</label>
              <textarea class="form-control" type="text" name="description" placeholder="Enter description here..." /></textarea>
              <span class="glyphicon form-control-feedback"></span>
              <span class="help-block"></span>
            </div>

            <div class="form-group">
              <label style="display:block;">Additional File:</label>
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

  <div id="delete_modal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header bg-danger">
          <button class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title text-danger">Warning!</h4>
        </div>

        <div class="modal-body">
          <p class="lead text-center">Are you sure you want to delete this assignment?</p>
          <small>
            <strong>Note:</strong> Once you delete this assignment, the students' submitted assignment will also be deleted.
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

  <div id="submit_modal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <button class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Submit Assignment</h4>
        </div>

        <div class="modal-body">

          <form id="submit_form" role="form" autocomplete="off">

            <div class="form-group has-feedback">
              <label style="display:block;">File to be submitted:</label>
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
            <span class="fa fa-save"></span> Submit
          </button>
          <button class="btn btn-danger" type="button" data-dismiss="modal">
            <span class="fa fa-remove"></span> Cancel
          </button>
        </div>

      </div>
    </div>
  </div>

  <div id="submissions_modal" class="modal fade">
    <div class="modal-dialog modal-lg">
      <div class="modal-content full-screen-modal-content">

        <div class="modal-header">
          <button class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Submissions</h4>
        </div>

        <div class="modal-body full-screen-modal-body">

          <div class="form-group row">
            <p><b>Sort by:</b></p>
            <select class="form-control pull-left" id="assignment_result_sort_by">
              <option>Date Submitted</option>
              <option>Name</option>
              <option>Grade</option>
            </select>

            <button class="btn btn-success pull-right" type="button" data-toggle="modal" data-target="#report_modal">
              <span class="fa fa-print"></span> Report
            </button>
          </div>

          <div class="row hidden-xs hidden-sm">
            <div class="col-md-1">
              <span class="fa fa-hashtag"></span>
            </div>
            <div class="col-md-4">
              <b>Name</b>
            </div>
            <div class="col-md-3">
              <b>Date Submitted</b>
            </div>
            <div class="col-md-2">
              <b>Grade</b>
            </div>
            <div class="col-md-2"></div>
          </div>

          <div id="assignment_result_panel">

          </div>

        </div>

        <div class="modal-footer full-screen-modal-footer">
          <button class="btn btn-danger" type="button" data-dismiss="modal">
            <span class="fa fa-remove"></span> Close
          </button>
        </div>

      </div>
    </div>
  </div>

  <div id="rate_modal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <button class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Rate Assignment</h4>
        </div>

        <div class="modal-body">

          <form id="rate_form" role="form" class="form-horizontal" autocomplete="off">

            <div class="form-group has-feedback">
              <label class="control-label col-md-6" name="student_name"></label>
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-6">
                    <input class="form-control" type="number" name="grade" />
                    <span class="glyphicon form-control-feedback"></span>
                  </div>
                </div>
                <span class="help-block">Grade must be in percent(50-100)</span>
              </div>
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

  <div id="resubmit_modal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <button class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Resubmit Assignment</h4>
        </div>

        <div class="modal-body">

          <form id="resubmit_form" class="form" autocomplete="off">

            <div class="form-group has-feedback">
              <label>Due Date:</label>
              <div class="row">
                <div class="col-md-6">
                  <input class="form-control" name="due_date" placeholder="Enter due date here..." />
                  <span class="glyphicon form-control-feedback"></span>
                  <span class="help-block"><b>Format:</b> mm/dd/yyyy</span>
                </div>
                <div class="col-md-6">
                  <select class="form-control" name="due_time">
                    <option disabled>---Morning---</option>
                    <option value="00:00:00">12:00 am</option>
                    <option value="01:00:00">1:00 am</option>
                    <option value="02:00:00">2:00 am</option>
                    <option value="03:00:00">3:00 am</option>
                    <option value="04:00:00">4:00 am</option>
                    <option value="05:00:00">5:00 am</option>
                    <option value="06:00:00">6:00 am</option>
                    <option value="07:00:00">7:00 am</option>
                    <option value="08:00:00">8:00 am</option>
                    <option value="09:00:00">9:00 am</option>
                    <option value="10:00:00">10:00 am</option>
                    <option value="11:00:00">11:00 am</option>
                    <option disabled>---Afternoon---</option>
                    <option value="12:00:00">12:00 pm</option>
                    <option value="13:00:00">1:00 pm</option>
                    <option value="14:00:00">2:00 pm</option>
                    <option value="15:00:00">3:00 pm</option>
                    <option value="16:00:00">4:00 pm</option>
                    <option value="17:00:00">5:00 pm</option>
                    <option value="18:00:00">6:00 pm</option>
                    <option value="19:00:00">7:00 pm</option>
                    <option value="20:00:00">8:00 pm</option>
                    <option value="21:00:00">9:00 pm</option>
                    <option value="22:00:00">10:00 pm</option>
                    <option value="23:00:00">11:00 pm</option>
                  </select>
                </div>
              </div>
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
          <button class="btn btn-success btn-sm" type="button" data-dismiss="modal">
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
    var notifId = <?php echo isset($_SESSION['source_id']) ? $_SESSION['source_id'] : '0' ?>;
    var notifCode = '<?php echo isset($_SESSION['notif_code']) ? $_SESSION['notif_code'] : '' ?>';
    var crStatus = '';

    $(document).ready(function() {
      $('#nav_subject_overview').hover(function() {
        $('#assignment_back_button').css('z-index', '6');
      }, function() {
        setTimeout(function() {
          $('#assignment_back_button').css('z-index', '8');
        }, 300);
      });

      $('#back').hover(function() {
        $('.breadcrumb [href="my_classrooms.php"]').css('z-index', '6');
      }, function() {
        setTimeout(function() {
          $('.breadcrumb [href="my_classrooms.php"]').css('z-index', '8');
        }, 300);
      });
    });

    <?php
    unset($_SESSION['source_id']);
    unset($_SESSION['notif_code']);
    ?>
  </script>

  <!-- Main Workers -->
  <script src="js/main_routing.js"></script>
  <script src="js/log_in_updater.js"></script>
  <script src="js/nav_manipulator.js"></script>

  <!-- Utilities -->
  <script src="js/utilities/viewport.js"></script>
  <script src="js/utilities/date.js"></script>
  <script src="js/utilities/files.js"></script>
  <script src="js/utilities/input.js"></script>

  <!-- Main Notification Worker -->
  <script src="js/notification/events/init.js"></script>
  <script src="js/notification/operations/retrieval.js"></script>

  <!-- Classroom Workers -->
  <script src="js/classroom_notification_manager.js"></script>
  <script src="js/classroom_breadcrumb_manager.js"></script>
  <script src="js/my_classroom_display_manager.js"></script>

  <!-- Assignment Workers -->
  <script src="js/assignment/variables.js"></script>
  <script src="js/assignment/nodes.js"></script>
  <script src="js/assignment/view.js"></script>
  <script src="js/assignment/displays.js"></script>
  <script src="js/assignment/resets.js"></script>
  <script src="js/assignment/operations/retrieval.js"></script>
  <script src="js/assignment/operations/manipulation.js"></script>
  <script src="js/assignment/events/init.js"></script>
  <script src="js/assignment/events/creation.js"></script>
  <script src="js/assignment/events/editing.js"></script>
  <script src="js/assignment/events/deleting.js"></script>
  <script src="js/assignment/events/publishing.js"></script>
  <script src="js/assignment/events/pinning.js"></script>
  <script src="js/assignment/events/backpacking.js"></script>
  <script src="js/assignment/events/content.js"></script>
  <script src="js/assignment/events/submission.js"></script>
  <script src="js/assignment/events/results.js"></script>
  <script src="js/assignment/events/reporting.js"></script>

</body>

</html>