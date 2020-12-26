
$(document).ready(function () {

  $('#add_modal [name="file_name_r"]').blur(function () {

    var elem = $(this);

    if (elem.val() === '') {

      showResult(elem, true, 'Please provide the file name!');
      submitOk = false;
    } else {

      showResult(elem, false, '');
    }
  });

  $('#add_form [name="file"]').click(function () {

    $('#add_form [name="file_r"]').click();
  });

  $('#add_form [name="file_r"]').change(function (e) {

    var elem = $(this);
    var file = elem.val();
    var fileName = file.split('\\').pop();

    if (!validFile(elem, file)) {

      $('#add_form [name="file_msg"]').text('Unsupported format!');
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
        fileName + ' <a href="#" name="file_remove"><span class="fa fa-remove"></span></a> '
      );

      showResult(elem, false, '');
    }
  });

  $('#add_modal [name="confirm_button"]').click(function () {

    var submitOk = true;
    var fileName = $('#add_form [name="file_name_r"]');
    var file = $('#add_form [name="file_r"]');

    if (fileName.val() === '') {

      showResult(fileName, true, 'Please provide the file name!');
      submitOk = false;
    } else {

      showResult(fileName, false, '');
    }

    if (file.val() === '') {

      showResult(file, true, 'Please choose a file!');
      submitOk = false;
    } else {

      showResult(file, false, '');
    }

    if (submitOk) {

      $('#loading_modal').modal('show');

      addBackpack(
        myId,
        fileName.val(),
        file[0].files[0]
      );
    }
  });
});

$(document).on('click', '#add_form [name="file_remove"]', function () {

  resetFileChooser('add');
});