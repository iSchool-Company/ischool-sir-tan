const barChartOptions = {
  seriesBarDistance: 10,
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
      labelInterpolationFnc: function (value) {
        return value[0];
      }
    }
  }]
];

var app = angular.module('mainApp', []);

app.controller('reportsCtrl', function ($scope, $http) {

  $scope.summaryFinished = false;

  $scope.retrieveClassrooms = () => {

    $http.get('database/classrooms/retrieve/display.php')
      .then(function (response) {

        let data = response.data;

        if (data.response === 'found') {

          $scope.classrooms = data.classrooms;

          if ($scope.classrooms.length > 0) {
            $scope.forTeacherSelected = $scope.classrooms[0];
            $scope.retrieveDetails($scope.forTeacherSelected);
          }
        }
      });
  };

  $scope.retrieveDetails = (classroom) => {

    $http.get('database/reports/retrieve/detailed_report.php?classroom_id=' + classroom.id)
      .then(function (response) {

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
        } else {
          $scope.detailedReport = {};
        }
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

  $scope.printDetailed = () => {

    let url = 'detailed_report.php?classroomId=' + $scope.forTeacherSelected.id;

    window.open(url);
  };

  $scope.percentageText = (percentage) => {

    if (percentage == 0) {
      return '';
    }

    return percentage + '%';
  };

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

    if ($scope.activeTab == 'summary') {
      $scope.renderCharts();
    }
  };

  $scope.renderCharts = () => {

    if (!$scope.summaryFinished) {
      return;
    }

    barChartOptions.high = Math.ceil(max / 5) * 5;

    let barChartDiv = $('#summary_bar');

    barLabels.forEach((label, i) => {

      let barId = 'bar' + i;
      let chartDiv = $('<div id="' + barId + '"></div>');

      barChartDiv.append(chartDiv);

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
  }

  $scope.activeTab = 'per_module';

  $('#per_teacher>a').on('shown.bs.tab', function (event) {
    $scope.activeTab = 'per_teacher';
  });

  $('#summary>a').on('shown.bs.tab', function (event) {
    $scope.activeTab = 'summary';
    $scope.renderCharts();
  });

  $('#detailed>a').on('shown.bs.tab', function (event) {
    $scope.activeTab = 'detailed';
  });

  $scope.retrieveClassrooms();
  $scope.retrieveSummary();
});