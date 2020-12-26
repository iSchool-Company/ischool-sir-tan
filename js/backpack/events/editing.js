
$(document).ready(function () {

  $('#edit_modal [name="file_name_r"]').blur(function () {

    var elem = $(this);

    if (elem.val() === '') {

      showResult(elem, true, 'Please provide the file name!');
      submitOk = false;
    } else {

      showResult(elem, false, '');
    }
  });

  $('#edit_form [name="file"]').click(function () {

    $('#edit_form [name="file_r"]').click();
  });

  $('#edit_form [name="file_r"]').change(function (e) {

    var elem = $(this);
    var file = elem.val();
    var fileName = file.split('\\').pop();

    if (!validFile(elem, file)) {

      $('#edit_form [name="file_msg"]').text('Unsupported format!');
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
        fileName + ' <a href="#" name="file_remove"><span class="fa fa-remove"></span></a> '
      );

      showResult(elem, false, '');

      if (editHasFile) {

        editFileDirty = true;
      }
    }
  });

  $('#edit_modal [name="confirm_button"]').click(function () {

    var submitOk = true;
    var fileName = $('#edit_form [name="file_name_r"]');
    var file = $('#edit_form [name="file_r"]');

    if (fileName.val() === '') {

      showResult(fileName, true, 'Please provide the file name!');
      submitOk = false;
    } else {

      showResult(fileName, false, '');
    }

    if (file.val() === '' && editFileDirty) {

      showResult(file, true, 'Please choose a file!');
      submitOk = false;
    } else {

      showResult(file, false, '');
    }

    if (submitOk) {

      $('#loading_modal').modal('show');

      updateBackpack(
        myId,
        backpackId,
        fileName.val(),
        file[0].files[0],
        editFileDirty
      );
    }
  });
});

$(document).on('click', '[id^="bckpck"] [name="edit_button"]', function () {

  var rootDOM = $(this).parents('[id^="bckpck"]');
  var id = rootDOM.attr('id').substr(6);

  backpackId = id;

  retrieveEditable(backpackId);
});

$(document).on('click', '#edit_form [name="file_remove"]', function () {

  resetFileChooser('edit');

  if (editHasFile) {

    editFileDirty = true;
  }
});