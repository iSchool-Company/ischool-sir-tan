
$(document).ready(function () {

  $('#publish_modal [name="confirm_button"]').click(function () {

    var dueDate = $('#publish_form [name="due_date"]');
    var dueTime = $('#publish_form [name="due_time"]');
    var ok = true;

    if (dueDate.val() === '') {

      showResult(
        dueDate,
        true,
        'Enter due date!'
      );

      ok = false;
    } else if (!isValidDate(dueDate.val())) {

      showResult(
        dueDate,
        true,
        'Invalid format(<b>mm/dd/yyyy</b>)!'
      );

      ok = false;
    } else if (differenceDate2(dueDate.val(), dueTime.val()) < 1) {

      showResult(
        dueDate,
        true,
        'Must be 1 hour ahead!'
      );

      ok = false;
    } else {

      showResult(
        dueDate,
        false,
        '<b>Format:</b> mm/dd/yyyy'
      );
    }

    if (ok || !publishNow) {

      $('#loading_modal').modal('show');

      publishAssignment(
        myId,
        classroomId,
        assignmentId,
        publishNow,
        dueDate.val(),
        dueTime.val()
      );
    }
  });

  $('#publish_form [name="due_date"], #publish_form [name="due_time"]').blur(function () {

    var dueDate = $('#publish_form [name="due_date"]');
    var dueTime = $('#publish_form [name="due_time"]');

    if (dueDate.val() === '') {

      showResult(
        dueDate,
        true,
        'Enter due date!'
      );
    } else if (!isValidDate(dueDate.val())) {

      showResult(
        dueDate,
        true,
        'Invalid format!'
      );
    } else if (differenceDate2(dueDate.val(), dueTime.val()) < 1) {

      showResult(
        dueDate,
        true,
        'Must be 1 hour ahead!'
      );
    } else {

      showResult(
        dueDate,
        false,
        ''
      );
    }
  });

  $('#publish_form [name="due_time"]').change(function () {

    $(this).blur();
  });

  $('#assignment_content_panel [name="publish_button"]').click(function () {

    var rootDOM = $('#assignment_content_panel');
    var publishModal = $('#publish_modal');

    publishNow = $(this).text().trim() === 'Publish';

    if (publishNow) {

      publishModal.find('.modal-title').text('Publish Assignment');
      publishModal.find('#publish_form').show();
      publishModal.find('#publish_message').hide();
      publishModal.find('[name="confirm_button"]').html('<span class="fa fa-eye"></span> Publish');
    } else {

      publishModal.find('.modal-title').text('Unpublish Assignment');
      publishModal.find('#publish_form').hide();
      publishModal.find('#publish_message').show();
      publishModal.find('[name="confirm_button"]').html('<span class="fa fa-eye-slash"></span> Unpublish');
    }
  });
});

$(document).on('click', '[id^="assmt"] [name="publish_button"]', function () {

  var rootDOM = $(this).parents('[id^="assmt"]');
  var publishModal = $('#publish_modal');
  var id = rootDOM.attr('id').substr(5);

  assignmentId = id;
  publishNow = $(this).text().trim() === 'Publish';

  if (publishNow) {

    publishModal.find('.modal-title').text('Publish Assignment');
    publishModal.find('#publish_form').show();
    publishModal.find('#publish_message').hide();
    publishModal.find('[name="confirm_button"]').html('<span class="fa fa-eye"></span> Publish');
  } else {

    publishModal.find('.modal-title').text('Unpublish Assignment');
    publishModal.find('#publish_form').hide();
    publishModal.find('#publish_message').show();
    publishModal.find('[name="confirm_button"]').html('<span class="fa fa-eye-slash"></span> Unpublish');
  }
});