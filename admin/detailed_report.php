<!DOCTYPE html>
<?php
session_start();
?>
<html>

<head>

  <title>iSchool | Report Print</title>

  <link rel="icon" href="../pictures/modules/logo.png">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
  <link href="../../frameworks/Font Awesome 4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link href="../../frameworks/Bootstrap 3.3.7/css/bootstrap.min.css" rel="stylesheet">
  <script src="../../frameworks/JQuery 3.1.1/jquery.min.js"></script>
  <script src="../../frameworks/Bootstrap 3.3.7/js/bootstrap.min.js"></script>
  <script src="../../frameworks/AngularJS v1.8.2/angular.min.js"></script>
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/navbar.css">
  <link rel="stylesheet" href="css/sidebar.css">
  <link rel="stylesheet" href="css/form.css">

  <style>
    #main {
      margin: 50px 25px;
    }

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
      width: 100%;
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

  <div id="main" class="panel panel-default" style="border-radius: 0;">

    <div class="panel-body">

      <div style="margin-top:20px;">

        <div class="row">

          <div class="col-sm-6">
            <p><b>Teacher's Name:</b> {{ detailedReport.instructor }}</p>
            <p><b>Classroom:</b> {{ detailedReport.classroom }}</p>
          </div>

          <div class="col-sm-6">
            <p><b>Total Respondents:</b> <b ng-class="{'text-success' : (detailedReport.total < (detailedReport.respondents / 2)), 'text-danger' : (detailedReport.total >= (detailedReport.respondents / 2))}">{{ detailedReport.respondents == null ? 0 : detailedReport.respondents }}</b> out of {{ detailedReport.total }} students</p>
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

  </div>

  <div id="loading_modal" class="modal fade" style="margin-top:72px;" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">

        <div class="modal-body">
          <div class="text-center">
            <img src="../pictures/modules/loading2.gif" style="width:50px;">
            <h4>Please Wait.....</h4>
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

  <script>
    var app = angular.module('mainApp', []);

    $('#loading_modal').modal();

    app.controller('reportsCtrl', function($scope, $http) {

      $scope.retrieveDetails = () => {

        let classroomId = decodeURIComponent($.urlParam('classroomId'));

        $http.get('database/reports/retrieve/detailed_report.php?classroom_id=' + classroomId)
          .then(function(response) {

            let data = response.data;

            if (data.response === 'found') {

              let info = data.info;
              let respondents = info.respondents;

              info.rate_1 = $scope.convertToPercentage(info.rate_1, respondents);
              info.rate_2 = $scope.convertToPercentage(info.rate_2, respondents);
              info.rate_3 = $scope.convertToPercentage(info.rate_3, respondents);
              info.rate_4 = $scope.convertToPercentage(info.rate_4, respondents);
              info.rate_5 = $scope.convertToPercentage(info.rate_5, respondents);
              info.rate_6 = $scope.convertToPercentage(info.rate_6, respondents);
              info.rate_7 = $scope.convertToPercentage(info.rate_7, respondents);
              info.rate_8 = $scope.convertToPercentage(info.rate_8, respondents);
              info.rate_9 = $scope.convertToPercentage(info.rate_9, respondents);
              info.rate_10 = $scope.convertToPercentage(info.rate_10, respondents);
              info.rate_11 = $scope.convertToPercentage(info.rate_11, respondents);

              info.sentiment_analysis = $scope.convertToPercentage(info.sentiment_analysis, respondents);

              $scope.detailedReport = info;

              setTimeout(function() {
                window.print();
              }, 1500);
            } else {
              $scope.detailedReport = {};
            }

            $('#loading_modal').modal('hide');
          });
      };

      $scope.convertToPercentage = (rate, respondents) => {

        if (respondents == 0) {
          return {
            neg: 0,
            pos: 0,
            neu: 0
          };
        }

        let neg = rate.neg;
        let pos = rate.pos;
        let negPercentage = Math.round((neg / respondents) * 100);
        let posPercentage = Math.round((pos / respondents) * 100);
        let neuPercentage = 100 - negPercentage - posPercentage;

        return {
          neg: negPercentage,
          pos: posPercentage,
          neu: neuPercentage
        };
      };

      $scope.percentageText = (percentage) => {

        if (percentage == 0) {
          return '';
        }

        return percentage + '%';
      };

      $scope.retrieveDetails();
    });

    $.urlParam = function(name) {
      var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
      return results[1] || 0;
    }
  </script>

</body>

</html>