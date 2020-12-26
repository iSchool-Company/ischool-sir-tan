
$(document).ready(function () {

  $('#add_form [name="file"]').click(function () {

    $('#add_form [name="file_r"]').click();
  });

  $('#add_form [name="publish"]').change(function () {

    var dueDate = $('#add_form [name="due_date_fg"]');
    var dueDateR = $('#add_form [name="due_date"]');

    if ($(this).is(':checked')) {

      showIfEver(dueDate);
    } else {

      hideIfEver(dueDate);
      clearResult(dueDateR);
    }
  });

  $('#add_form [name="file_r"]').change(function (e) {

    var elem = $(this);
    var file = elem.val();
    var fileName = file.split('\\').pop();

    if (!validFile(elem, file)) {

      $('#add_form [name="file_msg"]').text('.docx, .pdf, .txt, .ppt files only!');
      $('#add_form [name="file_name"]').text('');
      elem.val('');
    } else if (getFileSize(elem) > 5 * 1024) {

      $('#add_form [name="file_msg"]').text('Maximum of 5MB per upload!');
      $('#add_form [name="file_name"]').text('');
      elem.val('');
    } else {

      $('#add_form [name="file"]').text('Change');
      $('#add_form [name="file_msg"]').text('');
      $('#add_form [name="file_name"]').html(
        fileName + ' <a href="#" name="file_remove"><span class="fa fa-remove text-main-red"></span></a> '
      );
    }
  });

  $('#add_modal [name="confirm_button"]').click(function () {

    var title = $('#add_form [name="title"]');
    var description = $('#add_form [name="description"]');
    var file = $('#add_form [name="file_r"]')[0].files[0];
    var publish = $('#add_form [name="publish"]');
    var dueDate = $('#add_form [name="due_date"]');
    var dueTime = $('#add_form [name="due_time"]');
    var ok = true;

    if (title.val() === '') {

      showResult(
        title,
        true,
        'Enter a title!'
      );

      ok = false;
    } else {

      showResult(
        title,
        false,
        ''
      );
    }

    if (description.val() === '') {

      showResult(
        description,
        true,
        'Include a description!'
      );

      ok = false;
    } else {

      showResult(
        description,
        false,
        ''
      );
    }

    if (publish.is(':checked')) {

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
    }

    if (ok) {

      $('#loading_modal').modal('show');

      createAssignment(
        myId,
        classroomId,
        title.val(),
        description.val(),
        file,
        publish.is(':checked'),
        dueDate.val(),
        dueTime.val()
      );
    }
  });

  $('#add_form [name="title"]').blur(function () {

    var elem = $(this);

    if (elem.val() === '') {

      showResult(
        elem,
        true,
        'Enter a title!'
      );
    } else {

      showResult(
        elem,
        false,
        ''
      );
    }
  });

  $('#add_form [name="description"]').blur(function () {

    var elem = $(this);

    if (elem.val() === '') {

      showResult(
        elem,
        true,
        'Include a desription!'
      );
    } else {

      showResult(
        elem,
        false,
        ''
      );
    }
  });

  $('#add_form [name="due_date"], #add_form [name="due_time"]').blur(function () {

    var dueDate = $('#add_form [name="due_date"]');
    var dueTime = $('#add_form [name="due_time"]');

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

  $('#add_form [name="due_time"]').change(function () {

    $(this).blur();
  });
});

$(document).on('click', '#add_form [name="file_remove"]', function () {

  $('#add_form [name="file"]').text('Choose File');
  $('#add_form [name="file_msg"]').text('No file chosen');
  $('#add_form [name="file_name"]').text('');
  $('#add_form [name="file_r"]').val('');
});