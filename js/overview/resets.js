
function clearEditModal(modal) {

  modal.find('[name]').val('');
  clearResult(modal.find('[name]'));
}

$(document).ready(function () {

  $('[id$="_modal"]').on('hidden.bs.modal', function () {

    clearEditModal($(this));
  });
});