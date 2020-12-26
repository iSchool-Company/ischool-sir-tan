
$(document).ready(function () {

  $('#assignment_result_sort_by').change(function () {

    sortBy = $(this).val();

    $('#assignment_result_panel').empty();
  });

  $('#rate_modal [name="confirm_button"]').click(function () {

    var grade = $('#rate_form [name="grade"]');
    var ok = true;

    if (!(grade.val() >= 50 && grade.val() <= 100)) {

      showResult(
        grade,
        true,
        'Grade must be in percent(50-100)'
      );

      ok = false;
    } else {

      showResult(
        grade,
        false,
        'Grade must be in percent(50-100)'
      );
    }

    if (ok) {

      rateAssignment(
        myId,
        classroomId,
        submissionId,
        grade.val()
      );
    }
  });

  $('#resubmit_modal [name="confirm_button"]').click(function () {

    var dueDate = $('#resubmit_form [name="due_date"]');
    var dueTime = $('#resubmit_form [name="due_time"]');
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

    if (ok) {

      resubmitAssignment(
        myId,
        classroomId,
        submissionId,
        dueDate.val(),
        dueTime.val()
      );
    }
  });
});

$(document).on('click', '[id^="resassmt"] [name="rate_button"]', function () {

  var rootDOM = $(this).parents('[id^="resassmt"]');
  var id = rootDOM.attr('id').substr(8);
  var name = rootDOM.find('[name="name"]').text();

  submissionId = id;

  $('#rate_modal [name="student_name"]').text(name);
});

$(document).on('click', '[id^="resassmt"] [name="resubmit_button"]', function () {

  var rootDOM = $(this).parents('[id^="resassmt"]');
  var id = rootDOM.attr('id').substr(8);

  submissionId = id;
});