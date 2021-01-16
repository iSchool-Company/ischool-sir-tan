
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
  var rate1Neu = rateForm.find('#rate_1_neu');
  var rate2Neu = rateForm.find('#rate_2_neu');
  var rate3Neu = rateForm.find('#rate_3_neu');
  var rate4Neu = rateForm.find('#rate_4_neu');
  var rate5Neu = rateForm.find('#rate_5_neu');
  var content = rateForm.find('[name="content"]');
  var anonymous = rateForm.find('[name="anonymous"]');
  var anonymousSpan = $('#anonymous');

  materialSelect.empty();
  rate1Neu.prop('checked', true);
  rate2Neu.prop('checked', true);
  rate3Neu.prop('checked', true);
  rate4Neu.prop('checked', true);
  rate5Neu.prop('checked', true);
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