
function resetFileChooser(name) {

  $('#' + name + '_form [name="file"]').text('Choose File');
  $('#' + name + '_form [name="file_msg"]').text('No file chosen');
  $('#' + name + '_form [name="file_name"]').text('');
  $('#' + name + '_form [name="file_r"]').val('');
}

function resetAddModal() {

  resetFileChooser('add');

  $('#add_modal [name="file_name_r"]').val('');

  clearResult($('#add_modal [name="file_name_r"]'));
  clearResult($('#add_modal [name="file_r"]'));
}

function resetEditModal() {

  resetFileChooser('edit');

  $('#edit_modal [name="file_name_r"]').val('');

  clearResult($('#edit_modal [name="file_name_r"]'));
  clearResult($('#edit_modal [name="file_r"]'));

  editHasFile = false;
  editFileDirty = false;
}

function resetPinModal() {

  $('#pin_form [name="classrooms"]').empty();
  $('#pin_modal [name="confirm_button"]').attr('disabled', false);
}

$(document).ready(function () {

  $('#add_modal').on('hidden.bs.modal', function () {

    resetAddModal();
  });

  $('#edit_modal').on('hidden.bs.modal', function () {

    resetEditModal();
  });

  $('#pin_modal').on('hidden.bs.modal', function () {

    resetPinModal();
  });
});