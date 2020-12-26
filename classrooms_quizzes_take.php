<!DOCTYPE html>
<?php
session_start();
?>
<html>

<head>

  <title>iSchool | Quizzes</title>

  <?php
  require 'meta.php';
  ?>

  <style>
    .table>tbody>tr>td {
      border-top: 0;
      width: 50%;
    }

    .question-section {
      margin-left: 110px;
      margin-right: 110px;
    }

    #mc_chc,
    #tf_chc,
    i_chc {
      margin-left: 130px;
      margin-right: 130px;
      display: none;
    }

    @media screen and (max-width: 768px) {

      .col-md-12 {
        padding: 15px 10px;
      }

      .question-section {
        margin-left: 5px;
        margin-right: 5px;
      }

      #mc_chc,
      #tf_chc,
      i_chc {
        margin-left: 10px;
        margin-right: 10px;
        display: none;
      }

    }
  </style>

</head>

<body>

  <div class="container-fluid">

    <div class="row">

      <div class="col-md-12 col-xs-12">

        <div class="panel panel-default" style="margin-top:20px;">

          <div class="panel-body">

            <button id="submit_button" class="btn btn-success pull-right" type="button" data-toggle="modal" data-target="#submit_modal" style="display:none;">
              <span class="fa fa-check"></span> Submit
            </button>

            <div id="exam_panel" style="display:none;">

              <h4 id="title"></h4>

              <hr />

              <p class="text-main-red pull-right" style="display:inline-block;">
                Time Remaining: <b id="time"></b>
              </p>

              <h5 id="exam_type" style="display:inline-block; margin-top:0;"></h5>

              <div class="clearfix"></div>

              <div id="progress" class="progress" style="width:100%;">
                <div class="progress-bar progress-bar-striped active" style="width:0%; background-color:#008f95;">
                  <span class="hidden-sm hidden-xs">Question</span> <span id="current_item"></span> of <span id="overall"></span>
                </div>
              </div>

              <p class="question-section">
                <span id="qstn_num"></span>)
                <b id="qstn_value"></b>
              </p>

              <form id="mc_chc">

              </form>

              <form id="tf_chc">
                <div class="radio">
                  <label>
                    <input type="radio" name="chc" value="True">True
                  </label>
                </div>
                <div class="radio">
                  <label>
                    <input type="radio" name="chc" value="False">False
                  </label>
                </div>
              </form>

              <form id="i_chc" style="display:none;">
                <input class="form-control" type="text" name="chc" placeholder="Enter answer here..." style="width:300px;">
              </form>

              <a id="next_button" href="#">
                <span class="fa fa-chevron-circle-right text-main-green pull-right" style="font-size:50px;"></span>
              </a>

            </div>

            <div id="countdown_panel">
              <h3 class="text-center">Get Ready!</h3>
              <h2 class="text-center" id="countdown_h2">3</h2>
            </div>

          </div>

        </div>

      </div>

    </div>

  </div>

  <div id="submit_modal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header bg-danger">
          <button class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title text-danger">Warning!</h4>
        </div>

        <div class="modal-body">
          <p class="lead text-center">Are you sure you want to submit this quiz?</p>
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

  <div id="result_modal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <button class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Congratulations!</h4>
        </div>

        <div class="modal-body">

          <p class="lead text-center">You have successfully answered all the questions!</p>

          <table class="table">

            <tbody>
              <tr>
                <td class="text-right">Quiz:</td>
                <td class="text-left"><b id="result_quiz_text"></b></td>
              </tr>

              <tr>
                <td class="text-right">Score:</td>
                <td class="text-left"><b id="result_score_text"></b></td>
              </tr>

              <tr>
                <td class="text-right">Remarks:</td>
                <td class="text-left"><b id="result_remarks_text"></b></td>
              </tr>
            </tbody>

          </table>
        </div>

        <div class="modal-footer">
          <button class="btn btn-success" type="button" name="confirm_button">
            <span class="fa fa-thumbs-up"></span> OK
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
    var quizId = <?php echo isset($_SESSION['quiz_id']) ? $_SESSION['quiz_id'] : '0' ?>;
    <?php unset($_SESSION['quiz_id']); ?>
  </script>

  <!-- Main Workers -->
  <script src="js/main_routing.js"></script>

  <!-- Exam Workers -->
  <script src="js/exam/variables.js"></script>
  <script src="js/exam/nodes.js"></script>
  <script src="js/exam/display_manager.js"></script>
  <script src="js/exam/operation_manager.js"></script>
  <script src="js/exam/interaction_manager.js"></script>

</body>

</html>