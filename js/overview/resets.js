
function clearEditModal(modal) {

  modal.find('[name]').val('');
  clearResult(modal.find('[name]'));
}

$(document).ready(function () {

  $('[id$="_modal"]').on('hidden.bs.modal', function () {

    clearEditModal($(this));
  });

  $('#rate_modal').on('hidden.bs.modal', function () {

    resetRateModal();
  });
});

function resetRateModal() {

  var rateForm = $('#rate_form');
  var rate1Neu = rateForm.find('#rate_1_neu');
  var rate2Neu = rateForm.find('#rate_2_neu');
  var rate3Neu = rateForm.find('#rate_3_neu');
  var rate4Neu = rateForm.find('#rate_4_neu');
  var rate5Neu = rateForm.find('#rate_5_neu');
  var content = rateForm.find('[name="content"]');

  clearResult(content);
  rate1Neu.prop('checked', true);
  rate2Neu.prop('checked', true);
  rate3Neu.prop('checked', true);
  rate4Neu.prop('checked', true);
  rate5Neu.prop('checked', true);
  setRateValue('neutral');
}