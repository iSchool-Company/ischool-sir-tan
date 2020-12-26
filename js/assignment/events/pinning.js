
$(document).ready(function () {

  $('#pin_modal [name="confirm_button"]').click(function () {

    var pinId = $('#pin_form [name="classrooms"]').val();
    var crName = $('#pin_form [name="classrooms"] option:selected').text();

    $('#loading_modal').modal('show');

    pinAssignment(
      myId,
      classroomId,
      pinId,
      assignmentId,
      crName
    );
  });


  $('#assignment_content_panel [name="pin_button"]').click(function () {

    retrieveClassrooms(
      myId,
      classroomId
    );
  });
});

$(document).on('click', '[id^="assmt"] [name="pin_button"]', function () {

  var rootDOM = $(this).parents('[id^="assmt"]');
  var id = rootDOM.attr('id').substr(5);

  assignmentId = id;

  retrieveClassrooms(
    myId,
    classroomId
  );
});