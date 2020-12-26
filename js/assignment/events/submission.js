
$(document).ready(function () {

  $('#submit_form [name="file"]').click(function () {

    $('#submit_form [name="file_r"]').click();
  });

  $('#submit_form [name="file_r"]').change(function (e) {

    var elem = $(this);
    var file = elem.val();
    var fileName = file.split('\\').pop();

    if (!validFile(elem, file)) {

      $('#submit_form [name="file_msg"]').text('.docx, .pdf, .txt, .ppt files only!');
      $('#submit_form [name="file_name"]').text('');
      elem.val('');
    } else if (getFileSize(elem) > 5 * 1024) {

      $('#submit_form [name="file_msg"]').text('Maximum of 5MB per upload!');
      $('#submit_form [name="file_name"]').text('');
      elem.val('');
    } else {

      $('#submit_form [name="file"]').text('Change');
      $('#submit_form [name="file_msg"]').text('');
      $('#submit_form [name="file_name"]').html(
        fileName + ' <a href="#" name="file_remove"><span class="fa fa-remove"></span></a> '
      );

      showResult(
        elem,
        false,
        ''
      );
    }
  });

  $('#submit_modal [name="confirm_button"]').click(function () {

    var file = $('#submit_form [name="file_r"]');
    var ok = true;

    if (file.val() === '') {

      showResult(
        file,
        true,
        'Choose a file!'
      );

      ok = false;
    } else {

      showResult(
        file,
        false,
        ''
      );
    }

    if (ok) {

      $('#loading_modal').modal('show');

      submitAssignment(
        myId,
        classroomId,
        assignmentId,
        file[0].files[0]
      );
    }
  });
});

$(document).on('click', '#submit_form [name="file_remove"]', function () {

  $('#submit_form [name="file"]').text('Choose File');
  $('#submit_form [name="file_msg"]').text('No file chosen');
  $('#submit_form [name="file_name"]').text('');
  $('#submit_form [name="file_r"]').val('');
});