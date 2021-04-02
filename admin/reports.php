<!DOCTYPE html>
<?php
session_start();
?>
<html>

<head>

  <title>LMS | Reports</title>

  <link rel="icon" href="../pictures/modules/logo.png">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
  <link href="../../frameworks/Font Awesome 4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link href="../../frameworks/Bootstrap 3.3.7/css/bootstrap.min.css" rel="stylesheet">
  <script src="../../frameworks/JQuery 3.1.1/jquery.min.js"></script>
  <script src="../../frameworks/Bootstrap 3.3.7/js/bootstrap.min.js"></script>
  <script src="../../frameworks/AngularJS v1.8.2/angular.min.js"></script>
  <link rel="stylesheet" href="../../frameworks/Chartist 0.11.0/chartist.min.css">
  <script src="../../frameworks/Chartist 0.11.0/chartist.min.js"></script>
  <link rel="stylesheet" href="../../frameworks/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css">
  <script src="../../frameworks/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js"></script>
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/navbar.css">
  <link rel="stylesheet" href="css/sidebar.css">
  <link rel="stylesheet" href="css/form.css">

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

<body ng-app="mainApp" ng-controller="reportsCtrl" ng-cloak>

  <?php
  require 'main_header.php';
  ?>

  <div class="container-fluid main-container-fluid">

    <br /><br />

    <?php
    require 'main_sidebar.php';
    ?>

    <br />

    <div class="col-md-11">

      <ul class="breadcrumb">

        <li class="active">
          Reports
        </li>

      </ul>

      <div class="row">

        <div class="col-md-12">

          <div class="panel panel-default">

            <div class="panel-body">

              <ul class="nav nav-tabs" style="display:block;">

                <li>
                  <a>
                    <span class="text-main-black"><b>Generate by:</b></span>
                  </a>
                </li>

                <li id="per_teacher" class="active">
                  <a data-toggle="tab" href="#per_teacher_content">
                    <span class="text-main-black">Per Teacher</span>
                  </a>
                </li>

                <li id="summary">
                  <a data-toggle="tab" href="#summary_content">
                    <span class="text-main-black">Summary for Teachers</span>
                  </a>
                </li>

                <li id="detailed">
                  <a data-toggle="tab" href="#detailed_content">
                    <span class="text-main-black">Student Feedbacks</span>
                  </a>
                </li>

              </ul>

              <div class="tab-content">

                <div id="per_teacher_content" class="tab-pane fade in active">

                  <div style="margin-top:20px;">

                    <form id="report_form" class="form-horizontal" role="form" autocomplete="off">

                      <div class="row">

                        <div class="col-sm-6">
                          <div class="form-group has-feedback">
                            <label class="col-sm-5 control-label">Choose a Teacher:</label>
                            <div class="col-sm-7">
                              <select class="form-control" ng-options="c as (c.instructor + ' - ' + c.className + ' ' + c.subjectName) for c in classrooms" ng-model="forTeacherSelected" ng-change="retrieveDetails(forTeacherSelected)" ng-disabled="detailedReport.instructor == null"></select>
                            </div>
                          </div>
                        </div>

                      </div>

                    </form>

                    <hr>

                    <p class="text-center" ng-if="detailedReport.instructor == null">
                      <br>
                      <img src="../pictures/modules/loading2.gif" style="width:50px;">
                    </p>

                    <div ng-if="detailedReport.instructor != null">

                      <div class="row">

                        <div class="col-sm-6">
                          <p><b>Teacher's Name:</b> {{ detailedReport.instructor }}</p>
                          <p><b>Classroom:</b> {{ detailedReport.classroom }}</p>
                        </div>

                        <div class="col-sm-6">
                          <p><b>Total Respondents:</b> <b ng-class="{'text-success' : (detailedReport.respondents >= (detailedReport.total / 2)), 'text-danger' : (detailedReport.respondents < (detailedReport.total / 2))}">{{ detailedReport.respondents == null ? 0 : detailedReport.respondents }}</b> out of {{ detailedReport.total }} students</p>
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
                                <h3 class="rate-count"><b>{{ detailedReport.overall_rate.neg }}</b></h3>
                              </div>
                            </div>
                            <div class="col-xs-4">
                              <div class="rate-button rate-neutral static">
                                <span class="rate-icon fa fa-meh-o"></span>
                                <br>
                                <h3 class="rate-count"><b>{{ detailedReport.overall_rate.neu }}</b></h3>
                              </div>
                            </div>
                            <div class="col-xs-4">
                              <div class="rate-button rate-positive static">
                                <span class="rate-icon fa fa-smile-o"></span>
                                <br>
                                <h3 class="rate-count"><b>{{ detailedReport.overall_rate.pos }}</b></h3>
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
                            <td colspan="2"><b>A. TEACHER</b></td>
                          </tr>

                          <tr>
                            <td style="width:350px;">&nbsp;&nbsp;Personality</td>
                            <td>
                              <div class="progress">
                                <div class="progress-bar progress-bar-negative" role="progressbar" ng-style="{ width : (detailedReport.rate_1.neg + '%') }">{{ percentageText(detailedReport.rate_1.neg) }}</div>
                                <div class="progress-bar progress-bar-neutral" role="progressbar" ng-style="{ width : (detailedReport.rate_1.neu + '%') }">{{ percentageText(detailedReport.rate_1.neu) }}</div>
                                <div class="progress-bar progress-bar-positive" role="progressbar" ng-style="{ width : (detailedReport.rate_1.pos + '%') }">{{ percentageText(detailedReport.rate_1.pos) }}</div>
                              </div>
                            </td>
                          </tr>

                          <tr>
                            <td style="width:350px;">&nbsp;&nbsp;Composure</td>
                            <td>
                              <div class="progress">
                                <div class="progress-bar progress-bar-negative" role="progressbar" ng-style="{ width : (detailedReport.rate_2.neg + '%') }">{{ percentageText(detailedReport.rate_2.neg) }}</div>
                                <div class="progress-bar progress-bar-neutral" role="progressbar" ng-style="{ width : (detailedReport.rate_2.neu + '%') }">{{ percentageText(detailedReport.rate_2.neu) }}</div>
                                <div class="progress-bar progress-bar-positive" role="progressbar" ng-style="{ width : (detailedReport.rate_2.pos + '%') }">{{ percentageText(detailedReport.rate_2.pos) }}</div>
                              </div>
                            </td>
                          </tr>

                          <tr>
                            <td style="width:350px;">&nbsp;&nbsp;Articulation and modulation of voice</td>
                            <td>
                              <div class="progress">
                                <div class="progress-bar progress-bar-negative" role="progressbar" ng-style="{ width : (detailedReport.rate_3.neg + '%') }">{{ percentageText(detailedReport.rate_3.neg) }}</div>
                                <div class="progress-bar progress-bar-neutral" role="progressbar" ng-style="{ width : (detailedReport.rate_3.neu + '%') }">{{ percentageText(detailedReport.rate_3.neu) }}</div>
                                <div class="progress-bar progress-bar-positive" role="progressbar" ng-style="{ width : (detailedReport.rate_3.pos + '%') }">{{ percentageText(detailedReport.rate_3.pos) }}</div>
                              </div>
                            </td>
                          </tr>

                          <tr>
                            <td style="width:350px;">&nbsp;&nbsp;Mastery of the subject matter</td>
                            <td>
                              <div class="progress">
                                <div class="progress-bar progress-bar-negative" role="progressbar" ng-style="{ width : (detailedReport.rate_4.neg + '%') }">{{ percentageText(detailedReport.rate_4.neg) }}</div>
                                <div class="progress-bar progress-bar-neutral" role="progressbar" ng-style="{ width : (detailedReport.rate_4.neu + '%') }">{{ percentageText(detailedReport.rate_4.neu) }}</div>
                                <div class="progress-bar progress-bar-positive" role="progressbar" ng-style="{ width : (detailedReport.rate_4.pos + '%') }">{{ percentageText(detailedReport.rate_4.pos) }}</div>
                              </div>
                            </td>
                          </tr>

                          <tr>
                            <td colspan="2"><b>B. TEACHING PROCEDURE</b></td>
                          </tr>

                          <tr>
                            <td style="width:350px;">&nbsp;&nbsp;Organization of lectures</td>
                            <td>
                              <div class="progress">
                                <div class="progress-bar progress-bar-negative" role="progressbar" ng-style="{ width : (detailedReport.rate_5.neg + '%') }">{{ percentageText(detailedReport.rate_5.neg) }}</div>
                                <div class="progress-bar progress-bar-neutral" role="progressbar" ng-style="{ width : (detailedReport.rate_5.neu + '%') }">{{ percentageText(detailedReport.rate_5.neu) }}</div>
                                <div class="progress-bar progress-bar-positive" role="progressbar" ng-style="{ width : (detailedReport.rate_5.pos + '%') }">{{ percentageText(detailedReport.rate_5.pos) }}</div>
                              </div>
                            </td>
                          </tr>

                          <tr>
                            <td style="width:350px;">&nbsp;&nbsp;Ability to stimulate critical thinking</td>
                            <td>
                              <div class="progress">
                                <div class="progress-bar progress-bar-negative" role="progressbar" ng-style="{ width : (detailedReport.rate_6.neg + '%') }">{{ percentageText(detailedReport.rate_6.neg) }}</div>
                                <div class="progress-bar progress-bar-neutral" role="progressbar" ng-style="{ width : (detailedReport.rate_6.neu + '%') }">{{ percentageText(detailedReport.rate_6.neu) }}</div>
                                <div class="progress-bar progress-bar-positive" role="progressbar" ng-style="{ width : (detailedReport.rate_6.pos + '%') }">{{ percentageText(detailedReport.rate_6.pos) }}</div>
                              </div>
                            </td>
                          </tr>

                          <tr>
                            <td style="width:350px;">&nbsp;&nbsp;Ability to motivate students</td>
                            <td>
                              <div class="progress">
                                <div class="progress-bar progress-bar-negative" role="progressbar" ng-style="{ width : (detailedReport.rate_7.neg + '%') }">{{ percentageText(detailedReport.rate_7.neg) }}</div>
                                <div class="progress-bar progress-bar-neutral" role="progressbar" ng-style="{ width : (detailedReport.rate_7.neu + '%') }">{{ percentageText(detailedReport.rate_7.neu) }}</div>
                                <div class="progress-bar progress-bar-positive" role="progressbar" ng-style="{ width : (detailedReport.rate_7.pos + '%') }">{{ percentageText(detailedReport.rate_7.pos) }}</div>
                              </div>
                            </td>
                          </tr>

                          <tr>
                            <td style="width:350px;">&nbsp;&nbsp;Use of instructional materials</td>
                            <td>
                              <div class="progress">
                                <div class="progress-bar progress-bar-negative" role="progressbar" ng-style="{ width : (detailedReport.rate_8.neg + '%') }">{{ percentageText(detailedReport.rate_8.neg) }}</div>
                                <div class="progress-bar progress-bar-neutral" role="progressbar" ng-style="{ width : (detailedReport.rate_8.neu + '%') }">{{ percentageText(detailedReport.rate_8.neu) }}</div>
                                <div class="progress-bar progress-bar-positive" role="progressbar" ng-style="{ width : (detailedReport.rate_8.pos + '%') }">{{ percentageText(detailedReport.rate_8.pos) }}</div>
                              </div>
                            </td>
                          </tr>

                          <tr>
                            <td colspan="2"><b>C. STUDENTS</b></td>
                          </tr>

                          <tr>
                            <td style="width:350px;">&nbsp;&nbsp;Rapport with teacher</td>
                            <td>
                              <div class="progress">
                                <div class="progress-bar progress-bar-negative" role="progressbar" ng-style="{ width : (detailedReport.rate_9.neg + '%') }">{{ percentageText(detailedReport.rate_9.neg) }}</div>
                                <div class="progress-bar progress-bar-neutral" role="progressbar" ng-style="{ width : (detailedReport.rate_9.neu + '%') }">{{ percentageText(detailedReport.rate_9.neu) }}</div>
                                <div class="progress-bar progress-bar-positive" role="progressbar" ng-style="{ width : (detailedReport.rate_9.pos + '%') }">{{ percentageText(detailedReport.rate_9.pos) }}</div>
                              </div>
                            </td>
                          </tr>

                          <tr>
                            <td style="width:350px;">&nbsp;&nbsp;Discipline is manifested</td>
                            <td>
                              <div class="progress">
                                <div class="progress-bar progress-bar-negative" role="progressbar" ng-style="{ width : (detailedReport.rate_10.neg + '%') }">{{ percentageText(detailedReport.rate_10.neg) }}</div>
                                <div class="progress-bar progress-bar-neutral" role="progressbar" ng-style="{ width : (detailedReport.rate_10.neu + '%') }">{{ percentageText(detailedReport.rate_10.neu) }}</div>
                                <div class="progress-bar progress-bar-positive" role="progressbar" ng-style="{ width : (detailedReport.rate_10.pos + '%') }">{{ percentageText(detailedReport.rate_10.pos) }}</div>
                              </div>
                            </td>
                          </tr>

                          <tr>
                            <td style="width:350px;">&nbsp;&nbsp;Participation in the discussion</td>
                            <td>
                              <div class="progress">
                                <div class="progress-bar progress-bar-negative" role="progressbar" ng-style="{ width : (detailedReport.rate_11.neg + '%') }">{{ percentageText(detailedReport.rate_11.neg) }}</div>
                                <div class="progress-bar progress-bar-neutral" role="progressbar" ng-style="{ width : (detailedReport.rate_11.neu + '%') }">{{ percentageText(detailedReport.rate_11.neu) }}</div>
                                <div class="progress-bar progress-bar-positive" role="progressbar" ng-style="{ width : (detailedReport.rate_11.pos + '%') }">{{ percentageText(detailedReport.rate_11.pos) }}</div>
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
                              <div class="progress" ng-style="{ width : (detailedReport.sentiment_analysis.neg + '%') }">
                                <div class="progress-bar progress-bar-negative" role="progressbar" style="width:100%">{{ detailedReport.sentiment_analysis.neg + '%' }}</div>
                              </div>
                            </td>
                          </tr>

                          <tr>
                            <td style="width:350px;">Neutral</td>
                            <td>
                              <div class="progress" ng-style="{ width : (detailedReport.sentiment_analysis.neu + '%') }">
                                <div class="progress-bar progress-bar-neutral" role="progressbar" style="width:100%">{{ detailedReport.sentiment_analysis.neu + '%' }}</div>
                              </div>
                            </td>
                          </tr>

                          <tr>
                            <td style="width:350px;">Positive</td>
                            <td>
                              <div class="progress" ng-style="{ width : (detailedReport.sentiment_analysis.pos + '%') }">
                                <div class="progress-bar progress-bar-positive" role="progressbar" style="width:100%">{{ detailedReport.sentiment_analysis.pos + '%' }}</div>
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

                  <div class="pull-right">
                    <button class="btn btn-success" type="button" ng-click="printDetailed()">
                      <span class="fa fa-print"></span> Print
                    </button>
                  </div>
                  <div class="clearfix"></div>

                </div>

                <div id="summary_content" class="tab-pane fade in">

                  <div style="margin-top:20px;">

                    <h4 class="text-center" ng-if="!summaryFinished">Retrieving data please wait...</h4>

                    <br>
                    <br>
                    <div id="summary_bar"></div>
                    <br>
                    <br>
                    <div id="summary_line"></div>
                    <br>
                    <br>

                  </div>

                  <div class="pull-right">
                    <button class="btn btn-success" type="button" ng-click="printSummarized()">
                      <span class="fa fa-print"></span> Print
                    </button>
                  </div>
                  <div class="clearfix"></div>

                </div>

                <div id="detailed_content" class="tab-pane fade in">

                  <div style="margin-top:20px;">

                    <form id="feedback_form" class="form-horizontal" role="form" autocomplete="off">

                      <div class="row">

                        <div class="col-sm-6">
                          <div class="form-group has-feedback">
                            <label class="col-sm-5 control-label">Choose a Teacher:</label>
                            <div class="col-sm-7">
                              <select class="form-control" ng-options="c as (c.instructor + ' - ' + c.className + ' ' + c.subjectName) for c in classrooms" ng-model="feedbackSelected" ng-change="retrieveFeedbacks(feedbackSelected)" ng-disabled="feedbackInfo.instructor == null"></select>
                            </div>
                          </div>
                        </div>

                      </div>

                    </form>

                    <hr>

                    <p class="text-center" ng-if="feedbackInfo.instructor == null">
                      <br>
                      <img src="../pictures/modules/loading2.gif" style="width:50px;">
                    </p>

                    <div ng-if="feedbackInfo.instructor != null">

                      <div class="row">

                        <div class="col-sm-6">
                          <p><b>Teacher's Name:</b> {{ feedbackInfo.instructor }}</p>
                          <p><b>Classroom:</b> {{ feedbackInfo.classroom }}</p>
                        </div>

                        <div class="col-sm-6">
                          <p><b>Total Respondents:</b> <b ng-class="{'text-success' : (feedbackInfo.respondents >= (feedbackInfo.total / 2)), 'text-danger' : (feedbackInfo.respondents < (feedbackInfo.total / 2))}">{{ feedbackInfo.respondents == null ? 0 : feedbackInfo.respondents }}</b> out of {{ feedbackInfo.total }} students</p>
                        </div>

                      </div>

                      <hr>

                      <table class="table table-bordered table-condensed">
                        <tbody>
                          <tr>
                            <td style="width: 200px">Sad</td>
                            <td ng-if="feedbackInfo.feedbacks.neg.length == 0">No Data...</td>
                            <td ng-else>
                              <span ng-repeat="feedback in feedbackInfo.feedbacks.neg">
                                <b>{{ feedback.displayName }}</b>
                                <br>
                                {{ feedback.content }}
                                <br>
                              </span>
                            </td>
                          </tr>
                          <tr>
                            <td>Neutral</td>
                            <td ng-if="feedbackInfo.feedbacks.neu.length == 0">No Data...</td>
                            <td ng-else>
                              <span ng-repeat="feedback in feedbackInfo.feedbacks.neu">
                                <b>{{ feedback.displayName }}</b>
                                <br>
                                {{ feedback.content }}
                                <br>
                              </span>
                            </td>
                          </tr>
                          <tr>
                            <td>Happy</td>
                            <td ng-if="feedbackInfo.feedbacks.pos.length == 0">No Data...</td>
                            <td ng-else>
                              <span ng-repeat="feedback in feedbackInfo.feedbacks.pos">
                                <b>{{ feedback.displayName }}</b>
                                <br>
                                {{ feedback.content }}
                                <br>
                              </span>
                            </td>
                          </tr>
                        </tbody>
                      </table>

                    </div>

                  </div>

                  <div class="pull-right">
                    <button class="btn btn-success" type="button" ng-click="printFeedbacks()">
                      <span class="fa fa-print"></span> Print
                    </button>
                  </div>
                  <div class="clearfix"></div>

                </div>

              </div>

            </div>

          </div>

        </div>

      </div>

    </div>

  </div>

  <script>
    $(document).ready(function() {
      $('[data-toggle="tooltip"]').tooltip();
    });
  </script>

  <script>
    var myId = <?php echo isset($_SESSION['id']) ? $_SESSION['id'] : '0' ?>;
  </script>

  <script src="js/nav_manipulator.js"></script>
  <script src="js/main_routing.js"></script>

  <script src="js/reports/main.js"></script>

</body>

</html>