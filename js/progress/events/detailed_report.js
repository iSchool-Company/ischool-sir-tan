
$(document).ready(function () {

  let materialSelect = $('#report_form [name="materials"]');

  materialSelect.on('change', function () {
    resetDetailedReport();
    retrieveDetailedReview(materialSelect.val(), classroomId);
  });

  $('#detailed_print_button').click(function () {

    let materialId = $('#report_form [name="materials"]').val();

    window.open('classroom_detailed_material_report.php?material_id=' + materialId);
  });
});