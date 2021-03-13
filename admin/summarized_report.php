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
  <link rel="stylesheet" href="../../frameworks/Chartist 0.11.0/chartist.min.css">
  <script src="../../frameworks/Chartist 0.11.0/chartist.min.js"></script>
  <link rel="stylesheet" href="../../frameworks/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css">
  <script src="../../frameworks/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js"></script>
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/navbar.css">
  <link rel="stylesheet" href="css/sidebar.css">
  <link rel="stylesheet" href="css/form.css">

  <style>
    #main {
      margin: 25px;
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

      <div>

        <div class="text-center">
          <img src="../pictures/modules/logo_banner.png" style="width: 150px;">
        </div>

        <br>
        <hr>
        <br>

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
    const barChartOptions = {
      seriesBarDistance: 25,
      fullWidth: true,
      chartPadding: {
        left: 50,
        right: 50
      },
      plugins: [
        Chartist.plugins.tooltip()
      ]
    };

    const responsiveOptions = [
      ['screen and (max-width: 640px)', {
        axisX: {
          labelInterpolationFnc: function(value) {
            return value[0];
          }
        }
      }]
    ];

    var app = angular.module('mainApp', []);

    $('#loading_modal').modal();

    app.controller('reportsCtrl', function($scope, $http) {

      $scope.summaryFinished = false;

      $scope.retrieveSummary = () => {

        $http.get('database/reports/retrieve/summary.php').then((response) => {

          $scope.summaryFinished = true;

          $scope.showSummarizedReport(response.data.info);
        });
      };

      let lineLabels = [
        'Average Sentiments for the Entire College'
      ];
      let lineSeries = [
        [0],
        [0],
        [0]
      ];
      let barLabels = [];
      let barSeries = [];
      let max = 0;
      let lineRate = {
        neg: 0,
        neu: 0,
        pos: 0
      };

      $scope.showSummarizedReport = (data) => {

        data.classrooms.forEach((mat, i) => {

          lineRate.neg += mat.neg;
          lineRate.neu += mat.neu;
          lineRate.pos += mat.pos;

          let part = Math.floor(i / 6);

          let currBarLabels = barLabels[part];
          let currBarSeries = barSeries[part];

          if (currBarLabels == null) {
            barLabels[part] = [];
            currBarLabels = barLabels[part];
          }

          if (currBarSeries == null) {
            barSeries[part] = [
              [],
              [],
              []
            ];
            currBarSeries = barSeries[part];
          }

          currBarLabels.push(mat.instructor + '(' + mat.classroom + ')');

          currBarSeries[0].push(mat.neg);
          currBarSeries[1].push(mat.neu);
          currBarSeries[2].push(mat.pos);

          max = Math.max(max, mat.neg);
          max = Math.max(max, mat.neu);
          max = Math.max(max, mat.pos);
        });

        let lineTotal = data.classrooms.length;

        lineSeries[0][0] = Math.round(lineRate.neg / lineTotal);
        lineSeries[1][0] = Math.round(lineRate.neu / lineTotal);
        lineSeries[2][0] = Math.round(lineRate.pos / lineTotal);

        let size = data.classrooms.length;
        let remainder = size % 6;
        remainder = remainder === 0 ? 0 : 6 - remainder;

        // fill the gap
        for (let index = 0; index < remainder; index++) {

          let lastIndex = Math.floor(size / 6);
          let currBarLabels = barLabels[lastIndex];
          let currBarSeries = barSeries[lastIndex];

          currBarLabels.push('');

          currBarSeries[0].push(0);
          currBarSeries[1].push(0);
          currBarSeries[2].push(0);
        }

        $scope.renderCharts();
      };

      $scope.renderCharts = () => {

        barChartOptions.high = Math.ceil(max / 5) * 5;

        let barChartDiv = $('#summary_bar');

        barLabels.forEach((label, i) => {

          let barId = 'bar' + i;
          let chartDiv = $('<div id="' + barId + '"></div>');

          barChartDiv.append(chartDiv);
          barChartDiv.append('<div class="clearfix"></div>');

          var data = {
            labels: label,
            series: barSeries[i]
          };

          // Creation Proper
          new Chartist.Bar('#' + barId, data, barChartOptions, responsiveOptions);
        });

        if (lineLabels.length == 0) {
          return;
        }

        var data = {
          labels: lineLabels,
          series: lineSeries
        };

        new Chartist.Bar('#summary_line', data, barChartOptions, responsiveOptions);

        $('#loading_modal').modal('hide');

        setTimeout(function() {
          window.print();
        }, 1500);
      };

      $scope.retrieveSummary();
    });

    $.urlParam = function(name) {
      var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
      return results[1] || 0;
    }
  </script>

</body>

</html>