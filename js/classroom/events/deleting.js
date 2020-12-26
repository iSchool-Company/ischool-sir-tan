
$(document).ready(function () {

  $('[name="delete_confirm_button"]').click(function () {

    $('#delete_modal').modal('show');
    $('#loading_modal').modal('show');

    deleteClassroom(
      myId,
      classroomId
    );
  });
});

$(document).on('click', '[name="negative_button"]', function () {

  var rootDOM = $(this).parents('[id^="cr"]');
  var id = rootDOM.attr('id').substr(2);
  var status = rootDOM.find('[name="status"]').text();
  var message = '';
  var note = '';

  classroomId = id;

  if (myType === 'Student') {

    if (status === 'Pending') {

      message = 'Are you sure you want to cancel this current request?';
      deleteMessage = '<b class="text-success">Successful!</b> Request cancelled!';
      note = '<b>Note:</b> Once you cancel this request, you can still send request to join this classroom anytime.';
    } else {

      message = 'Are you sure you want to leave this classroom?';
      deleteMessage = '<b class="text-success">Successful!</b> Classroom left!';
      note = '<b>Note:</b> Once you leave this classroom, you can no longer receive notifications and go to this classroom.';
    }
  } else {

    message = 'Are you sure you want to delete this classroom?';
    deleteMessage = '<b class="text-success">Successful!</b> Classroom deleted!';
    note = '<b>Note:</b> Once you delete this classroom, you can no longer receive notifications and go to this classroom.';
  }

  $('#leave_modal [name="message"]').text(message);
  $('#leave_modal [name="note"]').html(note);
  $('#leave_modal').modal('show');
});