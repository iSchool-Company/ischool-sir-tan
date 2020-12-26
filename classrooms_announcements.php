<!DOCTYPE html>
<?php
session_start();
?>
<html>

<head>

  <title>iSchool | Announcements</title>

  <?php
  require 'meta.php';
  ?>

  <style>
    #announcement_form {
      display: none;
      margin-top: 20px;
    }

    #announcement_form [name="cancel_button"] {
      display: none;
    }

    [name="button_float"] {
      float: right;
    }

    [id^="anns"] .media {
      margin-top: 0;
    }

    [name="ann_content"],
    [name="com_content"],
    [name="rep_content"] {
      white-space: pre-line;
    }

    [name="ann_content"] {
      max-height: 50px;
      overflow: hidden;
    }

    .announcement-image>.img-circle {
      width: 50px;
      height: 50px;
    }

    #announcement_content {
      min-height: 350px;
    }

    .announcement-content>div {
      padding-left: 0;
    }

    .announcement-content-text {
      padding: 0;
      padding-left: 5px;
    }

    .btn-group {
      margin-top: 10px;
    }

    .btn-like-comment,
    .btn-like-comment:focus,
    .btn-like-comment:hover {
      background-color: #f7f7f7;
      border: 2px solid #008f95;
      border-radius: 25px;
      color: #008f95;
      font-weight: bolder;
    }

    .btn-like-comment.active,
    .btn-like-comment.active:hover,
    .btn-like-comment.active:focus {
      background-color: #008f95;
      border: 2px solid #008f95;
      border-radius: 25px;
      color: #f7f7f7;
      font-weight: bolder;
    }

    [name="ann_like_button"] .badge,
    [name="ann_comment_button"] .badge {
      color: #f7f7f7;
      background-color: #008f95;
      font-size: 10px;
      padding: 3px 5px;
    }

    .btn-like-comment.active .badge,
    .btn-like-comment.active:hover .badge,
    .btn-like-comment.active:focus .badge {
      color: #008f95;
      background-color: #f7f7f7;
      font-size: 10px;
      padding: 3px 5px;
    }

    .btn-group>[name="ann_like_button"],
    [name="ann_comment_button"] {
      padding: 4px 9px;
    }

    [name="ann_like_button"]>[name="ann_like"],
    [name="comment"] {
      font-size: 10px;
    }

    [id^="rep_form"]>.form-group {
      margin: 5px -15px;
    }

    [id^="coms"],
    [id^="reps"] {
      margin-top: 5px;
      border-left: 1px solid #d3d3d3;
    }

    [name="comment_button"],
    [name="reply_button"],
    [name="comment_button"]:hover,
    [name="reply_button"]:hover,
    [name="comment_button"]:focus,
    [name="reply_button"]:focus,
    [name="comment_button"]:active:focus,
    [name="reply_button"]:active:focus {
      border-radius: 0 25px 25px 0;
    }

    [id^="coms"],
    [id^="reps"] {
      padding: 5px;
      margin: 5px;
    }

    [name="com_image"],
    [name="rep_image"] {
      width: 40px;
      height: 40px;
    }

    [name="com_like"],
    [name="reply"],
    [name="rep_like"] {
      font-size: 9px;
      margin-top: -4px;
      padding: 3px 5px;
      background-color: #008f95;
    }

    #manage_dropdown {
      float: right;
    }

    #manage_dropdown>button {
      text-decoration: none;
    }

    @media screen and (max-width: 768px) {

      #announcement_form {
        margin: 15px 15px;
      }

      #announcement_panel .panel-body {
        padding: 15px 10px;
      }

      #manage_dropdown>.btn-link {
        padding: 0;
        border: none;
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
            Announcements
          </li>
        </ul>

        <div class="panel panel-default">

          <div class="panel-body">

            <form id="announcement_form" class="form-horizontal" autocomplete="off">

              <div class="form-group has-feedback">
                <div class="col-md-10 col-md-offset-1">
                  <textarea class="form-control" name="post_textarea" placeholder="What's happening?" rows="5"></textarea>
                  <span class="glyphicon form-control-feedback"></span>
                  <span class="help-block"></span>
                </div>
              </div>

              <div class="form-group">
                <div class="col-md-11">
                  <div name="button_float">
                    <button class="btn btn-success" name="post_button" type="submit">
                      <span class="fa fa-send"></span> Post
                    </button>
                    <button class="btn btn-danger" name="cancel_button" type="reset">
                      <span class="fa fa-remove"></span> Cancel
                    </button>
                  </div>
                </div>
              </div>

              <hr />

            </form>

            <div id="announcement_panel">

            </div>

            <button id="load_more_button" class="btn btn-link btn-block text-main-green" type="button">
              Load More
            </button>

          </div>

        </div>

      </div>

    </div>

  </div>

  <div id="edit_modal" class="modal fade">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

        <div class="modal-header">
          <button class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Announcement</h4>
        </div>

        <div class="modal-body">

          <form id="edit_form" class="form-horizontal" role="form" autocomplete="off">

            <div class="form-group">
              <label class="control-label col-md-3" for="announcement_content">Announcement Content:</label>
              <div class="col-md-9">
                <textarea id="announcement_content" class="form-control" name="announcement_content" placeholder="Enter announcement content here..." rows="5"></textarea>
              </div>
            </div>

          </form>

        </div>

        <div class="modal-footer">
          <button class="btn btn-success" name="save_button" type="button" data-dismiss="modal">
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
          <p class="lead text-center" name="delete_message">Are you sure you want to delete this announcement?</p>
          <small>
            <strong>Note:</strong> Once you delete this announcement, you cannot undo it but you can still post new annoucement.
          </small>
        </div>

        <div class="modal-footer">
          <button class="btn btn-success" name="confirm_button" type="button" data-dismiss="modal">
            <span class="fa fa-check"></span> Yes
          </button>
          <button class="btn btn-danger" type="button" data-dismiss="modal">
            <span class="fa fa-remove"></span> No
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

  <!-- Main Notification Worker -->
  <script src="js/notification/events/init.js"></script>
  <script src="js/notification/operations/retrieval.js"></script>

  <!-- Utilities -->
  <script src="js/utilities/input.js"></script>

  <!-- Classroom Workers -->
  <script src="js/classroom_notification_manager.js"></script>
  <script src="js/classroom_breadcrumb_manager.js"></script>
  <script src="js/my_classroom_display_manager.js"></script>

  <!-- Announcement Workers -->
  <script src="js/announcement/view.js"></script>
  <script src="js/announcement/displays.js"></script>
  <script src="js/announcement/operations.js"></script>

</body>

</html>