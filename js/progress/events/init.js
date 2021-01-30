
$(document).ready(function () {

  retrieveMaterials(
    classroomId
  );

  $('#detailed_print_button').click(function () {

    switch (activeTab) {

      case 'per_module':
        let materialId = $('#report_form [name="materials"]').val();
        window.open('classroom_detailed_material_report.php?material_id=' + materialId);
        break;
      case 'summary':
        window.open('classroom_summarized_material_report.php?classroom_id=' + classroomId);
        break;
    }
  });
});