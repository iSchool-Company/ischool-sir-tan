const barChartOptions = {
  seriesBarDistance: 10,
  fullWidth: true,
  chartPadding: {
    left: 50,
    right: 50
  }
};

const lineChartOptions = {
  fullWidth: true,
  chartPadding: {
    left: 50,
    right: 50
  }
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

$(document).ready(function () {

  retrieveSummarizedReview(classroomId);

  $('#summary>a').on('shown.bs.tab', function (event) {

    activeTab = 'summary';

    setTimeout(function () {

      var data = {
        labels: chartLabels,
        series: chartSeries
      };

      // Creation Proper
      new Chartist.Bar('#summary_bar', data, barChartOptions, responsiveOptions);
      new Chartist.Line('#summary_line', data, lineChartOptions, responsiveOptions);
    }, 1000);
  });
});