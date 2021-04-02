<!DOCTYPE html>
<?php
session_start();
?>
<html>

<head>

  <title>LMS | Quizzes</title>

  <?php
  require 'meta.php';
  ?>

  <style>
    [data-target="#add_modal"] {
      display: none;
    }

    [id^="qz"] [name="qz_dropdown"] {
      float: right;
    }

    [name="time_remaining"] {
      color: green;
    }

    [id^="qstn"]:last-child hr {
      display: none;
    }

    #result_modal .form-group>p {
      padding: 0;
      margin: 5px 15px;
      float: left;
      width: 65px;
    }

    #result_modal .form-group>select {
      width: 200px;
    }

    [data-target="#report_modal"] {
      margin: 0 15px;
    }

    @media screen and (max-width: 768px) {

      #quiz_panel .panel-body {
        padding: 15px 10px;
      }

      [name="qz_dropdown"]>.btn-link {
        padding: 0;
        border: none;
      }

      #result_modal .form-group>select {
        width: 50%;
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
            <a id="classroom_name" class="text-main-green" href="classrooms_subject_overview.php">
              ---
            </a>
          </li>
          <li id="quiz_bc" class="active">
            Quizzes
          </li>
        </ul>

        <div class="panel panel-default">

          <div class="panel-body">

            <div id="quiz_content_panel" value="0" style="display:none;">

              <button id="quiz_back_button" class="btn btn-link" type="button" style="z-index:8; position:relative;">
                <span class="fa fa-chevron-left"></span>
              </button>

              <button class="btn btn-success pull-right" type="button" data-toggle="modal" data-target="#result_modal">
                <span class="fa fa-bar-chart"></span> Quiz Result
              </button>

              <button id="take_now_button" class="btn btn-success pull-right" type="button" data-toggle="modal" data-target="#take_modal" style="display:none;">
                <span class="fa fa-pencil-square-o"></span> Take Now
              </button>

              <br style="clear:both;" />

              <hr>

              <div id="manage_button" class="dropdown pull-right" style="display:none;">
                <button class="btn btn-link dropdown-toggle text-main-green" type="button" data-toggle="dropdown" style="text-decoration:none;">
                  <span class="fa fa-gear" style="font-size:16px;"></span> <span class="fa fa-chevron-down"></span>
                </button>
                <ul class="dropdown-menu dropdown-menu-right">
                  <li class="disabled">
                    <a href="#publish_modal" data-toggle="modal" name="publish_button">
                    </a>
                  </li>
                  <li>
                    <a href="#edit_modal" data-toggle="modal" name="edit_button">
                      <span class="fa fa-pencil"></span> Edit
                    </a>
                  </li>
                  <li>
                    <a href="#delete_modal" data-toggle="modal" name="delete_button">
                      <span class="fa fa-trash"></span> Delete
                    </a>
                  </li>
                  <li>
                    <a href="#pin_modal" data-toggle="modal" name="pin_button">
                      <span class="fa fa-thumb-tack"></span> Pin
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

              <p style="margin-left:5px;">
                <b>Duration:</b> <span name="duration">---</span> &nbsp;&nbsp;&nbsp;&nbsp;
                <br class="visible-xs" />
                <b>Items:</b> <span name="question_count">---</span> &nbsp;&nbsp;&nbsp;&nbsp;
                <br class="visible-xs" />
                <b>Type:</b> <span name="type">---</span>
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

              <b style="margin-left:5px;">Description:</b>
              <p name="description" style="margin-left:15px;">---</p>

              <button id="add_question_button" class="btn btn-success" type="button" data-toggle="modal" data-target="#add_question_modal" style="text-decoration:none; display:none; z-index:8; position:relative;">
                <span class="fa fa-plus-circle"></span> Add Question
              </button>

              <div id="bottom_question_panel" class="panel panel-default panel-gray" style="margin-top:20px;">

                <div id="manage_question_panel" style="display:none;">

                </div>

                <div id="empty_manage_question_panel" class="panel-body text-center">
                  <p>Add a question to make a quiz <span class="fa fa-plus-circle"></span></p>
                </div>

              </div>

            </div>

            <div id="quiz_main_panel">

              <button class="btn btn-success pull-right" type="button" data-toggle="modal" data-target="#add_modal">
                <span class="fa fa-plus-circle"></span> Add Quiz
              </button>

              <br style="clear:both;" />

              <hr>

              <div id="quiz_panel">

              </div>

              <div id="empty_quiz_panel">
                <p class="text-center">
                  Add a quiz and you can choose where to publish it.
                  <span class="fa fa-plus-circle"></span>
                </p>
              </div>

            </div>

          </div>

        </div>

      </div>

    </div>

  </div>

  <div id="add_modal" class="modal fade" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content full-screen-modal-content">

        <div class="modal-header">
          <button class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Quiz</h4>
        </div>

        <div class="modal-body full-screen-modal-body">

          <form id="add_form" role="form" autocomplete="off">

            <div class="form-group has-feedback">
              <label for="title_modal">Title:</label>
              <input id="title_modal" class="form-control" name="title" type="text" placeholder="Enter title here..." autofocus />
              <span class="glyphicon form-control-feedback"></span>
              <span class="help-block"></span>
            </div>

            <div class="form-group has-feedback">
              <label for="description_modal">Description:</label>
              <textarea id="description_modal" class="form-control" name="description" placeholder="Enter description here..." rows="4"></textarea>
              <span class="glyphicon form-control-feedback"></span>
              <span class="help-block"></span>
            </div>

            <div class="form-group row has-feedback">
              <div class="col-md-6">
                <label for="type">Choose Type:</label>
                <select id="type" class="form-control" name="type">
                  <option value="1">Multiple Choice</option>
                  <option value="2">True/False</option>
                  <option value="3">Identification</option>
                </select>
                <span class="glyphicon form-control-feedback"></span>
                <span class="help-block"></span>
              </div>
            </div>

            <div class="form-group row has-feedback">
              <div class="col-md-6">
                <label for="duration">Duration:</label>
                <select id="duration" class="form-control" name="duration">
                  <option value="1">15 mins</option>
                  <option value="2">20 mins</option>
                  <option value="3">25 mins</option>
                  <option value="4">30 mins</option>
                  <option value="5">45 mins</option>
                  <option value="6">1 hr</option>
                </select>
                <span class="glyphicon form-control-feedback"></span>
                <span class="help-block"></span>
              </div>
            </div>

            <label>Assign to:</label>
            <div id="tags" class="alert alert-success" style="padding:5px;margin-bottom:5px;">
              <b>
                <input type="checkbox" name="check_all" checked>
                <span name="name" class="text-main-green">All Students</span>
                <a href="#" name="hide">
                  <span class="fa fa-chevron-down text-main-green"></span>
                </a>
              </b>
              <div name="members" style="display:none;">
              </div>
            </div>

            <div class="form-group">
              <div class="checkbox text-center">
                <label>
                  <input type="checkbox" name="question_now" />
                  Add Questions now?
                </label>
              </div>
            </div>

            <div id="add_question_panel" style="display:none;">

            </div>

            <div id="add_question_button_panel" style="display:none;">
              <hr>
              <span class="pull-right">
                <div class="form-group">
                  <select class="form-control">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                  </select>
                </div>
                <button class="btn btn-success" type="button" style="margin-bottom:15px;">
                  <span class="fa fa-plus-circle"></span>
                  Add Question
                </button>
              </span>
            </div>

            <div class="clearfix"></div>

            <div class="form-group" name="publish_fg" style="display:none;">
              <div class="checkbox text-center">
                <label>
                  <input type="checkbox" name="publish_now" />
                  Publish now?
                </label>
              </div>
            </div>

            <div class="form-group has-feedback" name="due_date_fg" style="display:none;">
              <label for="due_date_modal">Due Date:</label>
              <div class="row">
                <div class="col-md-6">
                  <input id="due_date_modal" class="form-control" name="due_date" placeholder="Enter due date here..." />
                  <span class="glyphicon form-control-feedback"></span>
                  <span class="help-block"><b>Format:</b> mm/dd/yyyy</span>
                </div>
                <div class="col-md-6">
                  <select class="form-control" name="due_time">
                    <option disabled>Morning</option>
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
                    <option disabled>Afternoon</option>
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
          <button class="btn btn-success" type="submit" form="add_form">
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
          <h4 class="modal-title">Publish Quiz</h4>
        </div>

        <div class="modal-body">
          <form id="publish_form" class="form" autocomplete="off">
            <div class="form-group has-feedback">
              <label for="due_date_modal">Due Date:</label>
              <div class="row">
                <div class="col-md-6">
                  <input class="form-control" name="due_date" placeholder="Enter due date here..." />
                  <span class="glyphicon form-control-feedback"></span>
                  <span class="help-block"><b>Format:</b> mm/dd/yyyy</span>
                </div>
                <div class="col-md-6">
                  <select class="form-control" name="due_time">
                    <option disabled>Morning</option>
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
                    <option disabled>Afternoon</option>
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
          <div id="publish_message">
            <p class="lead text-center">Are you sure you want to unpublish this quiz?</p>
          </div>
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

  <div id="edit_modal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content full-screen-modal-content">

        <div class="modal-header">
          <button class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Quiz</h4>
        </div>

        <div class="modal-body full-screen-modal-body">

          <form id="edit_form" role="form" autocomplete="off">

            <div class="form-group has-feedback">
              <label for="title_modal">Title:</label>
              <input id="title_modal" class="form-control" name="title" type="text" placeholder="Enter title here..." autofocus />
              <span class="glyphicon form-control-feedback"></span>
              <span class="help-block"></span>
            </div>

            <div class="form-group has-feedback">
              <label for="description_modal">Description:</label>
              <textarea id="description_modal" class="form-control" name="description" placeholder="Enter description here..." rows="4"></textarea>
              <span class="glyphicon form-control-feedback"></span>
            </div>

            <div class="form-group row has-feedback">
              <div class="col-md-6">
                <label for="type">Choose Type:</label>
                <select id="type" class="form-control" name="type">
                  <option value="1">Multiple Choice</option>
                  <option value="2">True/False</option>
                  <option value="3">Identification</option>
                </select>
                <span class="glyphicon form-control-feedback"></span>
              </div>
              <div class="col-md-12">
                <span class="help-block"><b>Note:</b> <i>Once you changed the type, all the questions will be deleted!</i></span>
              </div>
            </div>

            <div class="form-group row has-feedback">
              <div class="col-md-6">
                <label for="duration">Duration:</label>
                <select id="duration" class="form-control" name="duration">
                  <option value="1">15 mins</option>
                  <option value="2">20 mins</option>
                  <option value="3">25 mins</option>
                  <option value="4">30 mins</option>
                  <option value="5">45 mins</option>
                  <option value="6">1 hr</option>
                </select>
                <span class="glyphicon form-control-feedback"></span>
                <span class="help-block"></span>
              </div>
            </div>

          </form>

        </div>

        <div class="modal-footer full-screen-modal-footer">
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
          <p class="lead text-center">Are you sure you want to delete this quiz?</p>
          <small>
            <strong>Note:</strong> Once you delete this quiz, the students' record of his quiz will also be deleted.
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

  <div id="add_question_modal" class="modal fade" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content full-screen-modal-content">

        <div class="modal-header">
          <button class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Questions</h4>
        </div>

        <div class="modal-body full-screen-modal-body">

          <form id="add_question_form" role="form" autocomplete="off">

            <div id="add_question_question_panel">

            </div>
            <hr>
            <div id="add_question_question_button_panel">
              <span class="pull-right">
                <div class="form-group">
                  <select class="form-control">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                  </select>
                </div>
                <button class="btn btn-success" type="button">
                  <span class="fa fa-plus-circle"></span>
                  Add Question
                </button>
              </span>
              <div class="clearfix"></div>
            </div>

          </form>

        </div>

        <div class="modal-footer full-screen-modal-footer">
          <button class="btn btn-success" type="submit" form="add_question_form">
            <span class="fa fa-save"></span> Save
          </button>
          <button class="btn btn-danger" type="button" data-dismiss="modal">
            <span class="fa fa-remove"></span> Cancel
          </button>
        </div>

      </div>
    </div>
  </div>

  <div id="edit_question_modal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content full-screen-modal-content">

        <div class="modal-header">
          <button class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Question</h4>
        </div>

        <div class="modal-body full-screen-modal-body">

          <form id="edit_question_form" role="form" autocomplete="off">

            <div id="edit_question_panel">

            </div>

          </form>

        </div>

        <div class="modal-footer full-screen-modal-footer">
          <button class="btn btn-success" type="submit" form="edit_question_form">
            <span class="fa fa-save"></span> Save
          </button>
          <button class="btn btn-danger" type="button" data-dismiss="modal">
            <span class="fa fa-remove"></span> Cancel
          </button>
        </div>

      </div>
    </div>
  </div>

  <div id="delete_question_modal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header bg-danger">
          <button class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title text-danger">Warning!</h4>
        </div>

        <div class="modal-body">
          <p class="lead text-center">Are you sure you want to delete this question?</p>
        </div>

        <div class="modal-footer">
          <button class="btn btn-success" name="confirm_button">
            <span class="fa fa-check"></span> Confirm
          </button>
          <button class="btn btn-danger" data-dismiss="modal">
            <span class="fa fa-remove"></span> Cancel
          </button>
        </div>

      </div>
    </div>
  </div>

  <div id="result_modal" class="modal fade">
    <div class="modal-dialog modal-lg">
      <div class="modal-content full-screen-modal-content">

        <div class="modal-header">
          <button class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Result</h4>
        </div>

        <div class="modal-body full-screen-modal-body">

          <div class="form-group row">
            <p><b>Sort by:</b></p>
            <select class="form-control pull-left" id="quiz_result_sort_by">
              <option>Date Taken</option>
              <option>Name</option>
              <option>Score</option>
            </select>

            <button class="btn btn-success pull-right" type="button" data-toggle="modal" data-target="#report_modal">
              <span class="fa fa-print"></span> Report
            </button>
          </div>

          <div class="row hidden-xs hidden-sm">
            <div class="col-md-1">
              <span class="fa fa-hashtag"></span>
            </div>
            <div class="col-md-5">
              <b>Name</b>
            </div>
            <div class="col-md-3">
              <b>Date Taken</b>
            </div>
            <div class="col-md-2">
              <b>Score</b>
            </div>
            <div class="col-md-1"></div>
          </div>

          <div id="quiz_result_panel">

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

  <div id="retake_modal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <button class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Retake Quiz</h4>
        </div>

        <div class="modal-body">
          <form id="retake_form" class="form" autocomplete="off">
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
                    <option disabled>Morning</option>
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
                    <option disabled>Afternoon</option>
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
            <span class="fa fa-check"></span> Confirm
          </button>
          <button class="btn btn-danger" type="button" data-dismiss="modal">
            <span class="fa fa-remove"></span> Cancel
          </button>
        </div>

      </div>
    </div>
  </div>

  <div id="take_modal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <button class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title text-danger">Attention!</h4>
        </div>

        <div class="modal-body">
          <p class="lead text-center">Are you sure you want to take this quiz?</p>
        </div>

        <div class="modal-footer">
          <button class="btn btn-success" name="confirm_button">
            <span class="fa fa-check"></span> Confirm
          </button>
          <button class="btn btn-danger" type="button" data-dismiss="modal">
            <span class="fa fa-remove"></span> Cancel
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
      $('#nav_quizzes').hover(function() {
        $('#add_question_button').css('z-index', '6');
      }, function() {
        setTimeout(function() {
          $('#add_question_button').css('z-index', '8');
        }, 300);
      });

      $('#nav_subject_overview').hover(function() {
        $('#quiz_back_button').css('z-index', '6');
      }, function() {
        setTimeout(function() {
          $('#quiz_back_button').css('z-index', '8');
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
  </script>

  <!-- Main Workers -->
  <script src="js/main_routing.js"></script>
  <script src="js/log_in_updater.js"></script>
  <script src="js/nav_manipulator.js"></script>

  <!-- Utilities -->
  <script src="js/utilities/viewport.js"></script>
  <script src="js/utilities/date.js"></script>
  <script src="js/utilities/input.js"></script>

  <!-- Main Notification Worker -->
  <script src="js/notification/events/init.js"></script>
  <script src="js/notification/operations/retrieval.js"></script>

  <!-- Classroom Workers -->
  <script src="js/classroom_notification_manager.js"></script>
  <script src="js/classroom_breadcrumb_manager.js"></script>
  <script src="js/my_classroom_display_manager.js"></script>

  <!-- Quiz Workers -->
  <script src="js/quiz/variables.js"></script>
  <script src="js/quiz/nodes.js"></script>
  <script src="js/quiz/resets.js"></script>
  <script src="js/quiz/view.js"></script>
  <script src="js/quiz/displays.js"></script>
  <script src="js/quiz/operations/retrieval.js"></script>
  <script src="js/quiz/operations/manipulation.js"></script>
  <script src="js/quiz/events/init.js"></script>
  <script src="js/quiz/events/creation.js"></script>
  <script src="js/quiz/events/editing.js"></script>
  <script src="js/quiz/events/deleting.js"></script>
  <script src="js/quiz/events/publishing.js"></script>
  <script src="js/quiz/events/pinning.js"></script>
  <script src="js/quiz/events/taking.js"></script>
  <script src="js/quiz/events/content.js"></script>
  <script src="js/quiz/events/result.js"></script>
  <script src="js/quiz/events/question/creation.js"></script>
  <script src="js/quiz/events/question/editing.js"></script>
  <script src="js/quiz/events/question/deleting.js"></script>
  <script src="js/assignment/events/reporting.js"></script>

</body>

</html>