
$(document).ready(function () {

  $('#delete_modal [name="confirm_button"]').click(function () {

    $('#loading_modal').modal('show');

    deleteBackpack(
      myId,
      backpackId
    );
  });
});

$(document).on('click', '[id^="bckpck"] [name="remove_button"]', function () {

  var rootDOM = $(this).parents('[id^="bckpck"]');
  var id = rootDOM.attr('id').substr(6);

  backpackId = id;
});