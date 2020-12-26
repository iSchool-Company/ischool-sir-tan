
$(document).ready(function () {

  $('#remove_modal [name="confirm_button"]').click(function () {

    $('#loading_modal').modal('show');

    removeStudent(
      classroomId,
      myId,
      deleteId
    );
  });
});

$(document).on('click', '[name="delete_button"]', function () {

  var rootDOM = $(this).parents('[id^="std"]');

  deleteId = rootDOM.attr('id').substr(3);
});