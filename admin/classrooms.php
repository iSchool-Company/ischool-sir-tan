<!DOCTYPE html>
<?php
session_start();
?>
<html>

<head>

  <title>iSchool | Classrooms</title>

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

</head>

<body ng-app="mainApp" ng-controller="classroomsCtrl" ng-cloak>

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
          Classrooms
        </li>

      </ul>

      <div class="row">

        <div class="col-md-12">

          <div class="panel panel-default">

            <div class="panel-body">

              <table class="table table-bordered table-condensed">

                <thead>
                  <tr>
                    <td>ID</td>
                    <td>Instructor</td>
                    <td>Class Name</td>
                    <td>Subject Code</td>
                    <td>End Date</td>
                    <td>Classroom Description</td>
                    <td style="width: 150px"></td>
                  </tr>
                </thead>

                <tbody id="classrooms_body">
                  <tr ng-repeat="c in classrooms">
                    <td>{{ c.id }}</td>
                    <td>{{ c.instructor }}</td>
                    <td>{{ c.className }}</td>
                    <td>{{ c.subjectName }}</td>
                    <td>{{ c.dateEnd }}</td>
                    <td>{{ c.description }}</td>
                    <td class="text-center">
                      <button class="btn btn-danger btn-sm" ng-if="c.isReviewOpen" ng-click="setForEval(c.id, 0)">
                        Unset for Evaluation
                      </button>
                      <button class="btn btn-success btn-sm" ng-if="!c.isReviewOpen" ng-click="setForEval(c.id, 1)">
                        Set for Evaluation
                      </button>
                    </td>
                  </tr>
                </tbody>

              </table>

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

  <script>
    var app = angular.module('mainApp', []);

    app.controller('classroomsCtrl', function($scope, $http) {

      $scope.retrieveClassrooms = () => {

        $http.get('database/classrooms/retrieve/display.php')
          .then(function(response) {

            let data = response.data;

            if (data.response === 'found') {
              $scope.classrooms = data.classrooms;
            }
          });
      };
      $scope.setForEval = (classroomId, isSet) => {

        $http({
          method: 'POST',
          url: 'database/classrooms/set_for_eval.php',
          data: $.param({
            classroomId: classroomId,
            isSet: isSet
          }),
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
          }
        }).then(function(response) {
          console.log(response);
          $scope.retrieveClassrooms();
        })
      };

      $scope.retrieveClassrooms();
    });
  </script>

</body>

</html>