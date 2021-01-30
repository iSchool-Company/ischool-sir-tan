
$(document).ready(function () {

  let materialSelect = $('#report_form [name="materials"]');

  materialSelect.on('change', function () {
    resetDetailedReport();
    retrieveDetailedReview(materialSelect.val(), classroomId);
  });

  $('#per_module>a').on('shown.bs.tab', function (event) {
    activeTab = 'per_module';
  });
});