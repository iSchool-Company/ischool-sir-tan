
$(document).ready(function () {

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

      showResult(
        elem,
        false,
        ''
      );
    }
  });

  $('#add_modal [name="confirm_button"]').click(function () {

    var fileName = $('#add_form [name="topic"]');
    var file = $('#add_form [name="file_r"]');
    var ok = true;

    if (fileName.val() === '') {

      showResult(
        fileName,
        true,
        'Enter a file name!'
      );

      ok = false;
    } else {

      showResult(
        fileName,
        false,
        ''
      );
    }

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

      addMaterials(
        myId,
        classroomId,
        fileName.val(),
        file[0].files[0]
      );
    }
  });
});

$(document).on('click', '#add_form [name="file_remove"]', function () {

  resetFileChooser('add');
});