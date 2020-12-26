
$(document).ready(function () {

  $('#delete_modal [name="confirm_button"]').click(function () {

    $('#loading_modal').modal('show');

    deleteMaterials(
      myId,
      classroomId,
      materialsId
    );
  });
});

$(document).on('click', '[id^="mtrl"] [name="remove_button"]', function () {

  var rootDOM = $(this).parents('[id^="mtrl"]');
  var id = rootDOM.attr('id').substr(4);

  materialsId = id;
});