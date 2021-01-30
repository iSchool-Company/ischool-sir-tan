
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
  var rate6Neu = rateForm.find('#rate_6_neu');
  var rate7Neu = rateForm.find('#rate_7_neu');
  var rate8Neu = rateForm.find('#rate_8_neu');
  var rate9Neu = rateForm.find('#rate_9_neu');
  var rate10Neu = rateForm.find('#rate_10_neu');
  var rate11Neu = rateForm.find('#rate_11_neu');
  var content = rateForm.find('[name="content"]');

  clearResult(content);
  rate1Neu.prop('checked', true);
  rate2Neu.prop('checked', true);
  rate3Neu.prop('checked', true);
  rate4Neu.prop('checked', true);
  rate5Neu.prop('checked', true);
  rate6Neu.prop('checked', true);
  rate7Neu.prop('checked', true);
  rate8Neu.prop('checked', true);
  rate9Neu.prop('checked', true);
  rate10Neu.prop('checked', true);
  rate11Neu.prop('checked', true);
  setRateValue('neutral');
}