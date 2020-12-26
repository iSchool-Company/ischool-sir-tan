
$(document).ready(function () {

  $('#quiz_result_sort_by').change(function () {

    sortBy = $(this).val();

    $('#quiz_result_panel').empty();
  });

  $('#retake_modal [name="confirm_button"]').click(function () {

    var retakeForm = $('#retake_form');
    var dueDate = retakeForm.find('[name="due_date"]');
    var dueTime = retakeForm.find('[name="due_time"]');
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

      retakeQuiz(
        myId,
        classroomId,
        submissionId,
        dueDate.val(),
        dueTime.val()
      );
    }
  });
});

$(document).on('click', '[id^="resqz"] [name="retake_button"]', function () {

  var rootDOM = $(this).parents('[id^="resqz"]');
  var id = rootDOM.attr('id').substr(5);

  submissionId = id;
});