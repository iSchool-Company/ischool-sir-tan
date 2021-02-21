<!DOCTYPE html>
<?php
session_start();
?>
<html>

<head>

  <title>iSchool | Classroom Overview</title>

  <?php
  require 'meta.php';
  ?>

  <style>
    #teacher_image {
      width: 60px;
      height: 60px;
    }

    [data-target="#edit_modal"] {
      display: none;
    }

    .btn-link:hover,
    .btn-link:focus {
      background-color: transparent;
    }

    .btn-edit {
      font-size: 13px;
      font-weight: bolder;
      padding: 0;
    }

    #class_name_modal>.modal-dialog,
    #subject_name_modal>.modal-dialog,
    #end_date_modal>.modal-dialog {
      max-height: 250px;
    }

    #description_modal>.modal-dialog {
      max-height: 340px;
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
          <li id="classroom_name" class="active">

          </li>
        </ul>

        <div class="panel panel-default">

          <div class="panel-body">

            <h4>
              Instructor:
              <button class="btn btn-success" type="button" id="rate_button" data-toggle="modal" data-target="#rate_modal" style="display:none;">
                <span class="fa fa-star"></span> Rate
              </button>
            </h4>

            <div class="media" style="margin-bottom:20px;">
              <div class="media-left">
                <a href="#">
                  <img id="teacher_image" class="img-circle media-object" src="" alt="Not Available" />
                </a>
              </div>
              <div class="media-body">
                <p id="teacher_name"></p>
                <p id="teacher_username"></p>
              </div>
            </div>

            <p>
              <b>Class Name:</b>
              <button class="btn btn-link text-main-green btn-edit" type="button" data-toggle="modal" data-target="#class_name_modal" style="margin-top:-4px;display:none;">
                <span class="fa fa-pencil"></span> Edit
              </button>
            </p>
            <p id="class_name"></p>

            <p>
              <b>Subject Name:</b>
              <button class="btn btn-link text-main-green btn-edit" type="button" data-toggle="modal" data-target="#subject_name_modal" style="margin-top:-4px;display:none;">
                <span class="fa fa-pencil"></span> Edit
              </button>
            </p>
            <p id="subject_name"></p>

            <p>
              <b>End Date:</b>
              <button class="btn btn-link text-main-green btn-edit" type="button" data-toggle="modal" data-target="#end_date_modal" style="margin-top:-4px;display:none;">
                <span class="fa fa-pencil"></span> Edit
              </button>
            </p>
            <p id="date_end"></p>

            <hr />

            <p>
              <b>Classroom Description:</b>
              <button class="btn btn-link text-main-green btn-edit" type="button" data-toggle="modal" data-target="#description_modal" style="margin-top:-4px;display:none;">
                <span class="fa fa-pencil"></span> Edit
              </button>
            </p>
            <p id="description"></p>

          </div>

        </div>

      </div>

    </div>

  </div>

  <div id="class_name_modal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <button class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Class Name</h4>
        </div>

        <div class="modal-body">

          <form id="class_name_form" class="form-horizontal" role="form" autocomplete="off">

            <div class="form-group has-feedback">
              <label class="control-label col-md-4">Class Name:</label>
              <div class="col-md-7">
                <input class="form-control" name="class_name" type="text" placeholder="Enter class name..." />
                <span class="glyphicon form-control-feedback"></span>
                <span class="help-block"></span>
              </div>
            </div>

          </form>

        </div>

        <div class="modal-footer">
          <button class="btn btn-success" type="submit" form="class_name_form">
            <span class="fa fa-save"></span> Save
          </button>
          <button class="btn btn-danger" type="button" data-dismiss="modal">
            <span class="fa fa-remove"></span> Cancel
          </button>
        </div>

      </div>
    </div>
  </div>

  <div id="subject_name_modal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <button class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Subject Name</h4>
        </div>

        <div class="modal-body">

          <form id="subject_name_form" class="form-horizontal" role="form" autocomplete="off">

            <div class="form-group has-feedback">
              <label class="control-label col-md-4">Subject Name:</label>
              <div class="col-md-7">
                <input class="form-control" name="subject_name" type="text" placeholder="Enter subject name..." />
                <span class="glyphicon form-control-feedback"></span>
                <span class="help-block"></span>
              </div>
            </div>

          </form>

        </div>

        <div class="modal-footer">
          <button class="btn btn-success" type="submit" form="subject_name_form">
            <span class="fa fa-save"></span> Save
          </button>
          <button class="btn btn-danger" type="button" data-dismiss="modal">
            <span class="fa fa-remove"></span> Cancel
          </button>
        </div>

      </div>
    </div>
  </div>

  <div id="end_date_modal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <button class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit End Date</h4>
        </div>

        <div class="modal-body">

          <form id="end_date_form" class="form-horizontal" role="form" autocomplete="off">

            <div class="form-group has-feedback">
              <label class="control-label col-md-4">End Date:</label>
              <div class="col-md-7">
                <input class="form-control" name="end_date" type="text" />
                <span class="glyphicon form-control-feedback"></span>
                <span class="help-block"><b>Format:</b> mm/dd/yyyy</span>
              </div>
            </div>

          </form>

        </div>

        <div class="modal-footer">
          <button class="btn btn-success" type="submit" form="end_date_form">
            <span class="fa fa-save"></span> Save
          </button>
          <button class="btn btn-danger" type="button" data-dismiss="modal">
            <span class="fa fa-remove"></span> Cancel
          </button>
        </div>

      </div>
    </div>
  </div>

  <div id="description_modal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <button class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Description</h4>
        </div>

        <div class="modal-body">

          <form id="description_form" class="form-horizontal" role="form" autocomplete="off">

            <div class="form-group has-feedback">
              <label class="control-label col-md-4">Description:</label>
              <div class="col-md-7">
                <textarea class="form-control" name="description" placeholder="Enter description here..." rows="5"></textarea>
                <span class="glyphicon form-control-feedback"></span>
                <span class="help-block"></span>
              </div>
            </div>

          </form>

        </div>

        <div class="modal-footer">
          <button class="btn btn-success" type="submit" form="description_form">
            <span class="fa fa-save"></span> Save
          </button>
          <button class="btn btn-danger" type="button" data-dismiss="modal">
            <span class="fa fa-remove"></span> Cancel
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
          <h4 class="modal-title">Rate the Instructor</h4>
        </div>

        <div class="modal-body modal-body-full">

          <form id="rate_form" role="form" autocomplete="off">

            <div class="form-group has-feedback">
              <label class="col-sm-3 control-label">Instructor:</label>
              <div class="col-sm-9">
                <p id="rate_instructor_name" class="form-control-static"></p>
              </div>
            </div>

            <div class="form-group has-feedback">
              <label class="col-sm-3 control-label">Class:</label>
              <div class="col-sm-9">
                <p id="rate_class_name" class="form-control-static"></p>
              </div>
            </div>

            <div class="form-group has-feedback">
              <label class="col-sm-3 control-label">Subject:</label>
              <div class="col-sm-9">
                <p id="rate_subject_name" class="form-control-static"></p>
              </div>
            </div>

            <table class="table table-bordered table-condensed">
              <thead>
                <tr>
                  <th>Rate this module per category:</th>
                  <th class="text-center"><span class="fa fa-frown-o"></span></th>
                  <th class="text-center"><span class="fa fa-meh-o"></span></th>
                  <th class="text-center"><span class="fa fa-smile-o"></span></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td colspan="4"><b>A. TEACHER</b></td>
                </tr>
                <tr>
                  <td>&nbsp;&nbsp;Personality</td>
                  <td class="text-center"><input type="radio" name="rate_1" value="neg"></td>
                  <td class="text-center"><input id="rate_1_neu" type="radio" name="rate_1" value="neu" checked></td>
                  <td class="text-center"><input type="radio" name="rate_1" value="pos"></td>
                </tr>
                <tr>
                  <td>&nbsp;&nbsp;Composure</td>
                  <td class="text-center"><input type="radio" name="rate_2" value="neg"></td>
                  <td class="text-center"><input id="rate_2_neu" type="radio" name="rate_2" value="neu" checked></td>
                  <td class="text-center"><input type="radio" name="rate_2" value="pos"></td>
                </tr>
                <tr>
                  <td>&nbsp;&nbsp;Articulation and modulation of voice</td>
                  <td class="text-center"><input type="radio" name="rate_3" value="neg"></td>
                  <td class="text-center"><input id="rate_3_neu" type="radio" name="rate_3" value="neu" checked></td>
                  <td class="text-center"><input type="radio" name="rate_3" value="pos"></td>
                </tr>
                <tr>
                  <td>&nbsp;&nbsp;Mastery of the subject matter</td>
                  <td class="text-center"><input type="radio" name="rate_4" value="neg"></td>
                  <td class="text-center"><input id="rate_4_neu" type="radio" name="rate_4" value="neu" checked></td>
                  <td class="text-center"><input type="radio" name="rate_4" value="pos"></td>
                </tr>
                <tr>
                  <td colspan="4"><b>B. TEACHING PROCEDURE</b></td>
                </tr>
                <tr>
                  <td>&nbsp;&nbsp;Organization of lectures</td>
                  <td class="text-center"><input type="radio" name="rate_5" value="neg"></td>
                  <td class="text-center"><input id="rate_5_neu" type="radio" name="rate_5" value="neu" checked></td>
                  <td class="text-center"><input type="radio" name="rate_5" value="pos"></td>
                </tr>
                <tr>
                  <td>&nbsp;&nbsp;Ability to stimulate critical thinking</td>
                  <td class="text-center"><input type="radio" name="rate_6" value="neg"></td>
                  <td class="text-center"><input id="rate_6_neu" type="radio" name="rate_6" value="neu" checked></td>
                  <td class="text-center"><input type="radio" name="rate_6" value="pos"></td>
                </tr>
                <tr>
                  <td>&nbsp;&nbsp;Ability to motivate students</td>
                  <td class="text-center"><input type="radio" name="rate_7" value="neg"></td>
                  <td class="text-center"><input id="rate_7_neu" type="radio" name="rate_7" value="neu" checked></td>
                  <td class="text-center"><input type="radio" name="rate_7" value="pos"></td>
                </tr>
                <tr>
                  <td>&nbsp;&nbsp;Use of instructional materials</td>
                  <td class="text-center"><input type="radio" name="rate_8" value="neg"></td>
                  <td class="text-center"><input id="rate_8_neu" type="radio" name="rate_8" value="neu" checked></td>
                  <td class="text-center"><input type="radio" name="rate_8" value="pos"></td>
                </tr>
                <tr>
                  <td colspan="4"><b>C. STUDENTS</b></td>
                </tr>
                <tr>
                  <td>&nbsp;&nbsp;Rapport with teacher</td>
                  <td class="text-center"><input type="radio" name="rate_9" value="neg"></td>
                  <td class="text-center"><input id="rate_9_neu" type="radio" name="rate_9" value="neu" checked></td>
                  <td class="text-center"><input type="radio" name="rate_9" value="pos"></td>
                </tr>
                <tr>
                  <td>&nbsp;&nbsp;Discipline is manifested</td>
                  <td class="text-center"><input type="radio" name="rate_10" value="neg"></td>
                  <td class="text-center"><input id="rate_10_neu" type="radio" name="rate_10" value="neu" checked></td>
                  <td class="text-center"><input type="radio" name="rate_10" value="pos"></td>
                </tr>
                <tr>
                  <td>&nbsp;&nbsp;Participation in the discussion</td>
                  <td class="text-center"><input type="radio" name="rate_11" value="neg"></td>
                  <td class="text-center"><input id="rate_11_neu" type="radio" name="rate_11" value="neu" checked></td>
                  <td class="text-center"><input type="radio" name="rate_11" value="pos"></td>
                </tr>
              </tbody>
            </table>

            <div class="form-group has-feedback">
              <label class="control-label">Feedback Details:</label>
              <span class="inline-block pull-right">
                <a href="#" data-toggle="modal" data-target="#rate_guide_modal">how to write a good feedback</a>
              </span>
              <textarea class="form-control" rows="4" name="content" placeholder="What do you think of this material?"></textarea>
              <span class="glyphicon form-control-feedback"></span>
              <span class="help-block"></span>
            </div>

            <label>Please rate this instructor:</label>
            <div class="rate-picker">
              <div class="rate-button rate-negative">
                <span class="rate-icon fa fa-frown-o"></span>
                <br>
                <span>Sad</span>
              </div>
              <div class="rate-button rate-neutral active">
                <span class="rate-icon fa fa-meh-o"></span>
                <br>
                <span>Neutral</span>
              </div>
              <div class="rate-button rate-positive">
                <span class="rate-icon fa fa-smile-o"></span>
                <br>
                <span>Happy</span>
              </div>
            </div>

            <div class="clearfix"></div>

          </form>

        </div>

        <div class="modal-footer">
          <button class="btn btn-success" type="button" name="submit_button">
            <span class="fa fa-send"></span> Submit
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

  <div id="rate_guide_modal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-body modal-body-full">

          <h4>How to write a good feedback:</h4>

          <br>

          <p><strong>DO</strong></p>
          <ol>
            <li>Focus only on the Teacher.</li>
            <li>Base the evaluation on your personal experience.</li>
            <li>Tell us &quot;why&quot; you feel a certain way about it.</li>
          </ol>

          <br>

          <p><strong>DON'T</strong></p>
          <ol>
            <li>Include anything irrelevant to the Teacher&apos;s performance.</li>
            <li>Use vulgar, obscene, or discriminatory language.</li>
            <li>Share your classmate&apos;s thoughts or inputs.</li>
          </ol>

          <br>

          <p><em>Examples:</em></p>
          <ol>
            <li>Teacher Juan is great; he can explain the lessons well.</li>
            <li>I have no comment on Teacher Nancy.</li>
            <li>Teacher Drew is unsatisfactory; he is always absent.</li>
          </ol>

          <br>

          <div class="text-center">
            <button class="btn btn-success" type="button" data-dismiss="modal">Got it!</button>
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

  <div id="force_rate_modal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-body">
          <h1 class="text-center">Please rate your teacher now.</h1>
          <br>
          <br>
          <p class="text-center">
            <span class="fa fa-list" style="font-size: 150px;"></span>
          </p>
          <br>
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
  <script src="js/utilities/date.js"></script>
  <script src="js/utilities/viewport.js"></script>
  <script src="js/utilities/input.js"></script>

  <!-- Main Notification Worker -->
  <script src="js/notification/events/init.js"></script>
  <script src="js/notification/operations/retrieval.js"></script>

  <!-- Classroom Workers -->
  <script src="js/classroom_notification_manager.js"></script>
  <script src="js/classroom_breadcrumb_manager.js"></script>
  <script src="js/my_classroom_display_manager.js"></script>

  <!-- Classroom Overview Workers -->
  <script src="js/overview/variables.js"></script>
  <script src="js/overview/view.js"></script>
  <script src="js/overview/displays.js"></script>
  <script src="js/overview/resets.js"></script>
  <script src="js/overview/operations/retrieval.js"></script>
  <script src="js/overview/operations/manipulation.js"></script>
  <script src="js/overview/events/init.js"></script>
  <script src="js/overview/events/editing.js"></script>
  <script src="js/overview/events/rating.js"></script>

</body>

</html>