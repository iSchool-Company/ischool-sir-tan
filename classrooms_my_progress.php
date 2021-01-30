<!DOCTYPE html>
<?php
session_start();
?>
<html>

<head>

  <title>iSchool | Reports</title>

  <?php
  require 'meta.php';
  ?>
  <link rel="stylesheet" href="../frameworks/Chartist 0.11.0/chartist.min.css">
  <script src="../frameworks/Chartist 0.11.0/chartist.min.js"></script>

  <style>
    .rate-picker {
      width: calc(90% - 350px);
      margin-left: 350px;
    }

    .rate-button:hover {
      cursor: default;
    }

    .rate-button>.rate-icon {
      font-size: 48px;
    }

    .rate-count {
      display: inline-block;
      margin: 0;
    }

    .criteria-table {
      width: 90%;
    }

    .criteria-table td {
      padding: 10px;
    }

    .criteria-table .progress {
      margin: 0;
    }

    .progress-bar-negative {
      background-color: #f44336 !important;
    }

    .progress-bar-neutral {
      background-color: #62757f !important;
    }

    .progress-bar-positive {
      background-color: #4caf50 !important;
    }

    .legend-item {
      display: inline-block;
      width: 24px;
      height: 24px;
      border-radius: 5px;
    }

    .ct-series-a .ct-bar,
    .ct-series-a .ct-line,
    .ct-series-a .ct-point,
    .ct-series-a .ct-slice-donut {
      stroke: #f44336;
    }

    .ct-series-b .ct-bar,
    .ct-series-b .ct-line,
    .ct-series-b .ct-point,
    .ct-series-b .ct-slice-donut {
      stroke: #62757f;
    }

    .ct-series-c .ct-bar,
    .ct-series-c .ct-line,
    .ct-series-c .ct-point,
    .ct-series-c .ct-slice-donut {
      stroke: #4caf50;
    }
  </style>

</head>

<body>

  <?php
  require 'classroom_header.php';
  ?>

  <div class=" container-fluid">

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
            Reports
          </li>
        </ul>

        <div class="panel panel-default">
          <div class="panel-body">

            <ul class="nav nav-tabs" style="display:block;">

              <li>
                <a>
                  <span class="text-main-black"><b>Generate by:</b></span>
                </a>
              </li>

              <li id="per_module">
                <a data-toggle="tab" href="#per_module_content">
                  <span class="text-main-black">Per Module</span>
                </a>
              </li>

              <li id="summary">
                <a data-toggle="tab" href="#summary_content">
                  <span class="text-main-black">Summary for Modules</span>
                </a>
              </li>

              <li class="active" id="detailed">
                <a data-toggle="tab" href="#detailed_content">
                  <span class="text-main-black">Student Feedbacks</span>
                </a>
              </li>

            </ul>

            <div class="tab-content">

              <div id="per_module_content" class="tab-pane fade in">

                <div style="margin-top:20px;">

                  <form id="report_form" class="form-horizontal" role="form" autocomplete="off">

                    <div class="row">

                      <div class="col-sm-6">
                        <div class="form-group has-feedback">
                          <label class="col-sm-5 control-label">Choose a Material:</label>
                          <div class="col-sm-7">
                            <select class="form-control" name="materials"></select>
                          </div>
                        </div>
                      </div>

                    </div>

                  </form>

                  <hr>

                  <div class="row">

                    <div class="col-sm-6">
                      <p><b>Material Name:</b> <span id="detailed_material_name"></span></p>
                    </div>

                    <div class="col-sm-6">
                      <p><b>Total Respondents:</b> <b id="detailed_respondents_count">0</b> out of <span id="detailed_total_count">0</span> students</p>
                    </div>

                  </div>

                  <hr>

                  <h4><b>Overall Rate for this Material:</b></h4>

                  <div>
                    <div class="rate-picker">
                      <div class="row">
                        <div class="col-xs-4">
                          <div class="rate-button rate-negative static">
                            <span class="rate-icon fa fa-frown-o"></span>
                            <br>
                            <h3 class="rate-count"><b id="detailed_rate_neg">0</b></h3>
                          </div>
                        </div>
                        <div class="col-xs-4">
                          <div class="rate-button rate-neutral static">
                            <span class="rate-icon fa fa-meh-o"></span>
                            <br>
                            <h3 class="rate-count"><b id="detailed_rate_neu">0</b></h3>
                          </div>
                        </div>
                        <div class="col-xs-4">
                          <div class="rate-button rate-positive static">
                            <span class="rate-icon fa fa-smile-o"></span>
                            <br>
                            <h3 class="rate-count"><b id="detailed_rate_pos">0</b></h3>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <hr>

                  <h4><b>Rating per Category for this Material:</b></h4>

                  <table class="criteria-table">

                    <tbody>

                      <tr>
                        <td style="width:350px;">Objectives are clearly stated</td>
                        <td>
                          <div class="progress">
                            <div id="detailed_rate_1_neg" class="progress-bar progress-bar-negative" role="progressbar" style="width:0%"></div>
                            <div id="detailed_rate_1_neu" class="progress-bar progress-bar-neutral" role="progressbar" style="width:0%"></div>
                            <div id="detailed_rate_1_pos" class="progress-bar progress-bar-positive" role="progressbar" style="width:0%"></div>
                          </div>
                        </td>
                      </tr>

                      <tr>
                        <td style="width:350px;">Content is aligned with course</td>
                        <td>
                          <div class="progress">
                            <div id="detailed_rate_2_neg" class="progress-bar progress-bar-negative" role="progressbar" style="width:0%"></div>
                            <div id="detailed_rate_2_neu" class="progress-bar progress-bar-neutral" role="progressbar" style="width:0%"></div>
                            <div id="detailed_rate_2_pos" class="progress-bar progress-bar-positive" role="progressbar" style="width:0%"></div>
                          </div>
                        </td>
                      </tr>

                      <tr>
                        <td style="width:350px;">Content is well organized</td>
                        <td>
                          <div class="progress">
                            <div id="detailed_rate_3_neg" class="progress-bar progress-bar-negative" role="progressbar" style="width:0%"></div>
                            <div id="detailed_rate_3_neu" class="progress-bar progress-bar-neutral" role="progressbar" style="width:0%"></div>
                            <div id="detailed_rate_3_pos" class="progress-bar progress-bar-positive" role="progressbar" style="width:0%"></div>
                          </div>
                        </td>
                      </tr>

                      <tr>
                        <td style="width:350px;">Instructions are clearly stated</td>
                        <td>
                          <div class="progress">
                            <div id="detailed_rate_4_neg" class="progress-bar progress-bar-negative" role="progressbar" style="width:0%"></div>
                            <div id="detailed_rate_4_neu" class="progress-bar progress-bar-neutral" role="progressbar" style="width:0%"></div>
                            <div id="detailed_rate_4_pos" class="progress-bar progress-bar-positive" role="progressbar" style="width:0%"></div>
                          </div>
                        </td>
                      </tr>

                      <tr>
                        <td style="width:350px;">Activities are aligned with content</td>
                        <td>
                          <div class="progress">
                            <div id="detailed_rate_5_neg" class="progress-bar progress-bar-negative" role="progressbar" style="width:0%"></div>
                            <div id="detailed_rate_5_neu" class="progress-bar progress-bar-neutral" role="progressbar" style="width:0%"></div>
                            <div id="detailed_rate_5_pos" class="progress-bar progress-bar-positive" role="progressbar" style="width:0%"></div>
                          </div>
                        </td>
                      </tr>

                    </tbody>

                  </table>

                  <hr>

                  <h4><b>Sentiment Analysis Based on Feedback:</b></h4>

                  <table class="criteria-table">

                    <tbody>

                      <tr>
                        <td style="width:350px;">Negative</td>
                        <td>
                          <div id="detailed_sentiment_analysis_neg" class="progress" style="width:0%">
                            <div class="progress-bar progress-bar-negative" role="progressbar" style="width:100%"></div>
                          </div>
                        </td>
                      </tr>

                      <tr>
                        <td style="width:350px;">Neutral</td>
                        <td>
                          <div id="detailed_sentiment_analysis_neu" class="progress" style="width:0%">
                            <div class="progress-bar progress-bar-neutral" role="progressbar" style="width:100%"></div>
                          </div>
                        </td>
                      </tr>

                      <tr>
                        <td style="width:350px;">Positive</td>
                        <td>
                          <div id="detailed_sentiment_analysis_pos" class="progress" style="width:0%">
                            <div class="progress-bar progress-bar-positive" role="progressbar" style="width:100%"></div>
                          </div>
                        </td>
                      </tr>

                    </tbody>

                  </table>

                  <hr>

                  <p class="text-right" style="width:90%;">
                    Legends:
                    &nbsp;
                    <span class="legend-item progress-bar-negative"></span>
                    Negative
                    &nbsp;
                    <span class="legend-item progress-bar-neutral"></span>
                    Neutral
                    &nbsp;
                    <span class="legend-item progress-bar-positive"></span>
                    Positive
                  </p>

                </div>

              </div>

              <div id="summary_content" class="tab-pane fade in">

                <div style="margin-top:20px;">

                  <br>
                  <br>
                  <div id="summary_bar"></div>
                  <br>
                  <br>
                  <div id="summary_line"></div>
                  <br>
                  <br>

                </div>

              </div>

              <div id="detailed_content" class="tab-pane fade in active">

                <div style="margin-top:20px;">

                  <form id="feedback_form" class="form-horizontal" role="form" autocomplete="off">

                    <div class="row">

                      <div class="col-sm-6">
                        <div class="form-group has-feedback">
                          <label class="col-sm-5 control-label">Choose a Material:</label>
                          <div class="col-sm-7">
                            <select class="form-control" name="materials"></select>
                          </div>
                        </div>
                      </div>

                    </div>

                  </form>

                  <hr>

                  <div class="row">

                    <div class="col-sm-6">
                      <p><b>Material Name:</b> <span id="feedback_material_name"></span></p>
                    </div>

                    <div class="col-sm-6">
                      <p><b>Total Respondents:</b> <b id="feedback_respondents_count">0</b> out of <span id="feedback_total_count">0</span> students</p>
                    </div>

                  </div>

                  <hr>

                  <table class="table table-bordered table-condensed">
                    <tbody>
                      <tr>
                        <td style="width: 200px">Sad</td>
                        <td id="negative_feedbacks"></td>
                      </tr>
                      <tr>
                        <td>Neutral</td>
                        <td id="neutral_feedbacks"></td>
                      </tr>
                      <tr>
                        <td>Happy</td>
                        <td id="positive_feedbacks"></td>
                      </tr>
                    </tbody>
                  </table>

                </div>

              </div>

            </div>

            <div class="pull-right">
              <button id="detailed_print_button" class="btn btn-success" type="button">
                <span class="fa fa-print"></span> Print
              </button>
            </div>
            <div class="clearfix"></div>

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

    <!-- Classroom Workers -->
    <script src="js/classroom_notification_manager.js"></script>
    <script src="js/classroom_breadcrumb_manager.js"></script>
    <script src="js/my_classroom_display_manager.js"></script>

    <!-- Materials Workers -->
    <script src="js/progress/variables.js"></script>
    <script src="js/progress/nodes.js"></script>
    <script src="js/progress/displays.js"></script>
    <script src="js/progress/resets.js"></script>
    <script src="js/progress/display_manager.js"></script>
    <script src="js/progress/operations/retrieval.js"></script>
    <script src="js/progress/events/init.js"></script>
    <script src="js/progress/events/detailed_report.js"></script>
    <script src="js/progress/events/summarized_report.js"></script>
    <script src="js/progress/events/feedback_report.js"></script>

</body>

</html>