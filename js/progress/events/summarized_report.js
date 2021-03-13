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

    setTimeout(renderCharts, 1000);
  });
});