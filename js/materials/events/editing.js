
$(document).ready(function () {

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

      if (editHasFile) {

        editFileDirty = true;
      }
    }
  });

  $('#edit_modal [name="confirm_button"]').click(function () {

    var topic = $('#edit_form [name="topic"]');
    var file = $('#edit_form [name="file_r"]')[0].files[0];

    $('#loading_modal').modal('show');

    updateMaterials(
      myId,
      classroomId,
      materialsId,
      topic.val(),
      file,
      editFileDirty
    );
  });
});

$(document).on('click', '[id^="mtrl"] [name="edit_button"]', function () {

  var rootDOM = $(this).parents('[id^="mtrl"]');
  var id = rootDOM.attr('id').substr(4);

  materialsId = id;

  retrieveEditable(materialsId);
});

$(document).on('click', '#edit_form [name="file_remove"]', function () {

  resetFileChooser('edit');

  if (editHasFile) {

    editFileDirty = true;
  }
});