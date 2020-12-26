
$(document).ready(function () {

  $('#delete_modal [name="confirm_button"]').click(function () {

    $('#loading_modal').modal('show');

    deleteAssignment(
      myId,
      classroomId,
      assignmentId
    );
  });
});

$(document).on('click', '[id^="assmt"] [name="delete_button"]', function () {

  var rootDOM = $(this).parents('[id^="assmt"]');
  var id = rootDOM.attr('id').substr(5);

  assignmentId = id;
});