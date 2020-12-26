
function resetAddModal() {

  $('#add_modal [name]').val('');

  clearResult($('#add_modal [name]'));
  clearResult($('#add_modal [name="date_range"]'), '<b>Format:</b> mm/dd/yyyy');
}

function resetLeaveModal() {

  $('#leave_modal [name="message"]').text('');
  $('#leave_modal [name="note"]').html('');

  deleteId = 0;
}

function resetJoinModal() {

  recentSearch = '';

  $('#join_form [name="search_bar"]').val('');
  $('#join_panel').empty();
  $('#empty_join_panel > p').text('Search a classroom and you can start joining on it.');
  showIfEver($('#empty_join_panel'));
}

function resetClassroomRequestModal() {

  $('#request_panel').empty();

  crReqFirstId = 0;
  crReqLastId = 0;

  clearInterval(crReqRetriever);
}

$(document).ready(function () {

  $('#add_modal').on('hidden.bs.modal', function () {

    resetAddModal();
  });

  $('#leave_modal').on('hidden.bs.modal', function () {

    resetLeaveModal();
  });

  $('#join_modal').on('hidden.bs.modal', function () {

    resetJoinModal();
  });

  $('#request_modal').on('hidden.bs.modal', function () {

    resetClassroomRequestModal();
  });
});