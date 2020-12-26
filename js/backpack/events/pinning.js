
$(document).ready(function () {

  $('#pin_modal [name="confirm_button"]').click(function () {

    var pinId = $('#pin_form [name="classrooms"]').val();
    var crName = $('#pin_form [name="classrooms"] option:selected').text();

    $('#loading_modal').modal('show');

    pinBackpack(
      myId,
      pinId,
      backpackId,
      crName
    );
  });
});

$(document).on('click', '[id^="bckpck"] [name="pin_button"]', function () {

  var rootDOM = $(this).parents('[id^="bckpck"]');
  var id = rootDOM.attr('id').substr(6);

  backpackId = id;

  retrieveClassrooms(
    myId,
    0
  );
});