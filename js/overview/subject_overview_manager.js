
function clearEditModal() {

  $('#class_name_modal').val('');
  $('#subject_name_modal').val('');
  $('#data_range_modal').val('');
  $('#description_modal').val('');
}

function updateClassroom(className, subjectName, dateRange, description) {
  $.ajax({
    method: 'post',
    url: 'database/update_classroom_details.php',
    data: {
      user_id: myId,
      classroom_id: classroomId,
      class_name: className,
      subject_name: subjectName,
      date_end: dateRange,
      description: description
    },
    success: function (data, status) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response == 'successful') {
        $('#prompt_modal').modal('show');
      }
    }
  });
}

$(document).ready(function () {

  $('#edit_modal').on('shown.bs.modal', function () {

    showEditModal();
  });

  $('#edit_modal').on('hidden.bs.modal', function () {

    clearEditModal();
    clearResult($('#class_name_modal'));
    clearResult($('#subject_name_modal'));
    clearResult($('#date_range_modal'));
    clearResult($('#description_modal'));
  });

});