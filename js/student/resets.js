
function resetAddModal() {

  $('#search_form [name="search"]').val('');
  $('#search_panel').empty();
  $('#empty_search_panel').html(
    'Search a student and you can start adding them. <span class="fa fa-user"></span>'
  );
  $('#empty_search_panel').show();

  searcTemp = '';
}

$(document).ready(function () {

  $('#add_modal').on('hidden.bs.modal', function () {

    resetAddModal();
  });
});