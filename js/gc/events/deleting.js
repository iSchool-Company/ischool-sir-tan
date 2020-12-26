
$(document).ready(function () {

  $('#delete_gc_modal [name="confirm_button"]').click(function () {

    $('#loading_modal').modal('show');

    deleteGc(
      myId,
      gcId
    );
  });
});

$(document).on('click', '[id^="gcht"] [name="delete_button"]', function () {

  var rootDOM = $(this).parents('[id^="gcht"]');

  gcId = rootDOM.attr('id').substr(4);
});