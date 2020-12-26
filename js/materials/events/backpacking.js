
$(document).on('click', '[id^="mtrl"] [name="backpack_button"]', function () {

  var rootDOM = $(this).parents('[id^="mtrl"]');
  var id = rootDOM.attr('id').substr(4);

  materialsId = id;

  $('#loading_modal').modal('show');

  backpackMaterials(
    myId,
    classroomId,
    materialsId
  );
});