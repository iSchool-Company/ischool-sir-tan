
function resetAddModal() {

  var addForm = $('#add_form');
  var topic = addForm.find('[name="topic"]');
  var file = addForm.find('[name="file"]');
  var fileR = addForm.find('[name="file_r"]');
  var fileMsg = addForm.find('[name="file_msg"]');
  var fileName = addForm.find('[name="file_name"]');

  topic.val();
  file.text('Choose File');
  fileR.val('');
  fileMsg.text('No file chosen');
  fileName.text('');

  clearResult(topic);
  clearResult(fileR);
}

function resetRateModal() {

  var rateForm = $('#rate_form');
  var materialSelect = rateForm.find('[name="materials"]');
  var content = rateForm.find('[name="content"]');
  var anonymous = rateForm.find('[name="anonymous"]');
  var anonymousSpan = $('#anonymous');

  materialSelect.empty();
  clearResult(content);
  setRateValue('neutral');
  anonymous.prop('checked', true);
  anonymousSpan.text('anonymous');
}

function resetFileChooser(name) {

  $('#' + name + '_form [name="file"]').text('Choose File');
  $('#' + name + '_form [name="file_msg"]').text('No file chosen');
  $('#' + name + '_form [name="file_name"]').text('');
  $('#' + name + '_form [name="file_r"]').val('');
}

$(document).ready(function () {

  $('#add_modal').on('hidden.bs.modal', function () {

    resetAddModal();
  });

  $('#rate_modal').on('hidden.bs.modal', function () {

    resetRateModal();
  });
});