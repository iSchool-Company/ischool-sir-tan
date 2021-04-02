<!DOCTYPE html>
<?php
session_start();
?>
<html>

<head>

  <title>LMS | Report Print</title>

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
      margin: 25px;
    }
  </style>

</head>

<body ng-app="mainApp" ng-controller="reportsCtrl" ng-cloak>

  <div id="main" class="panel panel-default" style="border-radius: 0;">

    <div class="panel-body">

      <div style="margin-top:0px;">

        <div class="text-center">
          <img src="../pictures/modules/logo_banner.png" style="width: 150px;">
        </div>

        <br>
        <hr>
        <br>

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

      $scope.retrieveFeedbacks = (classroom) => {

        let classroomId = decodeURIComponent($.urlParam('classroomId'));

        $scope.feedbackInfo = null;

        $http.get('database/reports/retrieve/feedbacks.php?classroom_id=' + classroomId)
          .then(function(response) {

            let data = response.data;
            let status = data.response;

            if (status == 'found') {

              $scope.feedbackInfo = data.info;

              setTimeout(function() {
                window.print();
              }, 1500);
            } else {
              $scope.feedbackInfo = {};
            }

            $('#loading_modal').modal('hide');
          });
      };

      $scope.retrieveFeedbacks();
    });

    $.urlParam = function(name) {
      var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
      return results[1] || 0;
    }
  </script>

</body>

</html>