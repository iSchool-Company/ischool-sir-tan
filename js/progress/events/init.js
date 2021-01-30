
$(document).ready(function () {

  retrieveMaterials(
    classroomId
  );

  $('#detailed_print_button').click(function () {

    let materialId;

    switch (activeTab) {

      case 'per_module':
        materialId = $('#report_form [name="materials"]').val();
        window.open('classroom_detailed_material_report.php?material_id=' + materialId);
        break;
      case 'summary':
        window.open('classroom_summarized_material_report.php?classroom_id=' + classroomId);
        break;
      case 'detailed':
        materialId = $('#report_form [name="materials"]').val();
        window.open('classroom_feedback_report.php?material_id=' + materialId);
        break;
    }
  });
});