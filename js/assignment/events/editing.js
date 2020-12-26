
$(document).ready(function () {

  $('#edit_form [name="file"]').click(function () {

    $('#edit_form [name="file_r"]').click();
  });

  $('#edit_form [name="file_r"]').change(function (e) {

    var elem = $(this);
    var file = elem.val();
    var fileName = file.split('\\').pop();

    if (!validFile(elem, file)) {

      $('#edit_form [name="file_msg"]').text('.docx, .pdf, .txt, .ppt files only!');
      $('#edit_form [name="file_name"]').text('');
      elem.val('');
    } else if (getFileSize(elem) > 5 * 1024) {

      $('#edit_form [name="file_msg"]').text('Maximum of 5MB per upload!');
      $('#edit_form [name="file_name"]').text('');
      elem.val('');
    } else {

      $('#edit_form [name="file"]').text('Change');
      $('#edit_form [name="file_msg"]').text('');
      $('#edit_form [name="file_name"]').html(
        fileName + ' <a href="#" name="file_remove"><span class="fa fa-remove text-main-red"></span></a> '
      );

      if (editHasFile) {

        editFileDirty = true;
      }
    }
  });

  $('#edit_modal [name="confirm_button"]').click(function () {

    var editForm = $('#edit_form');
    var title = editForm.find('[name="title"]');
    var description = editForm.find('[name="description"]');
    var file = editForm.find('[name="file_r"]')[0].files[0];
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

    if (ok) {

      $('#loading_modal').modal('show');

      updateAssignment(
        myId,
        classroomId,
        assignmentId,
        title.val(),
        description.val(),
        editFileDirty,
        file
      );
    }
  });

  $('#edit_form [name="title"]').blur(function () {

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

  $('#edit_form [name="description"]').blur(function () {

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

  $('#assignment_content_panel [name="edit_button"]').click(function () {

    retrieveEditable(assignmentId);
  });
});

$(document).on('click', '[id^="assmt"] [name="edit_button"]', function () {

  var rootDOM = $(this).parents('[id^="assmt"]');
  var id = rootDOM.attr('id').substr(5);

  assignmentId = id;

  retrieveEditable(assignmentId);
});

$(document).on('click', '#edit_form [name="file_remove"]', function () {

  $('#edit_form [name="file"]').text('Choose File');
  $('#edit_form [name="file_msg"]').text('No file chosen');
  $('#edit_form [name="file_name"]').text('');
  $('#edit_form [name="file_r"]').val('');

  if (editHasFile) {

    editFileDirty = true;
  }
});