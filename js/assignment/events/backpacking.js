
$(document).ready(function () {

  $('#assignment_content_panel [name="backpack_button"]').click(function () {

    $('#loading_modal').modal('show');

    backpackAssignment(
      myId,
      classroomId,
      assignmentId
    );
  });
});

$(document).on('click', '[id^="assmt"] [name="backpack_button"]', function () {

  var rootDOM = $(this).parents('[id^="assmt"]');
  var id = rootDOM.attr('id').substr(5);

  assignmentId = id;

  $('#loading_modal').modal('show');

  backpackAssignment(
    myId,
    classroomId,
    assignmentId
  );
});

$(document).on('click', '[id^="resassmt"] [name="backpack_button"]', function () {

  var rootDOM = $(this).parents('[id^="resassmt"]');
  var id = rootDOM.attr('id').substr(8);

  submissionId = id;

  $('#loading_modal').modal('show');

  backpackResult(
    myId,
    classroomId,
    submissionId
  );
});