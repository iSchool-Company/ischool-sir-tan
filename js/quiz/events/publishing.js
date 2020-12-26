
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

      publishQuiz(
        myId,
        classroomId,
        quizId,
        publishNow,
        dueDate.val(),
        dueTime.val()
      );
    }
  });

  $('#manage_button [name="publish_button"]').click(function () {

    var publishModal = $('#publish_modal');

    publish = $(this).text().trim() === 'Publish';

    if (publish) {

      publishModal.find('.modal-title').text('Publish Quiz');
      publishModal.find('#publish_form').show();
      publishModal.find('#publish_message').hide();
      publishModal.find('[name="confirm_button"]').html('<span class="fa fa-eye"></span> Publish');
    } else {

      publishModal.find('.modal-title').text('Unpublish Quiz');
      publishModal.find('#publish_form').hide();
      publishModal.find('#publish_message').show();
      publishModal.find('[name="confirm_button"]').html('<span class="fa fa-eye-slash"></span> Unpublish');
    }
  });
});

$(document).on('click', '[id^="qz"] [name="publish_button"]', function () {

  var rootDOM = $(this).parents('[id^="qz"]');
  var id = rootDOM.attr('id').substr(2);
  var publishModal = $('#publish_modal');

  quizId = id;
  publishNow = $(this).text().trim() === 'Publish';

  if (publishNow) {

    publishModal.find('.modal-title').text('Publish Quiz');
    publishModal.find('#publish_form').show();
    publishModal.find('#publish_message').hide();
    publishModal.find('[name="confirm_button"]').html('<span class="fa fa-eye"></span> Publish');
  } else {

    publishModal.find('.modal-title').text('Unpublish Quiz');
    publishModal.find('#publish_form').hide();
    publishModal.find('#publish_message').show();
    publishModal.find('[name="confirm_button"]').html('<span class="fa fa-eye-slash"></span> Unpublish');
  }
});