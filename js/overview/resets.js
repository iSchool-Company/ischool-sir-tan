
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
  var content = rateForm.find('[name="content"]');

  clearResult(content);
  setRateValue('neutral');
}