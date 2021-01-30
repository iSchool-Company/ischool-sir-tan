
$(document).ready(function () {

  let materialSelect = $('#feedback_form [name="materials"]');

  materialSelect.on('change', function () {
    resetFeedbacks();
    retrieveFeedbacks(materialSelect.val(), classroomId);
  });

  $('#detailed>a').on('shown.bs.tab', function (event) {
    activeTab = 'detailed';
  });
});