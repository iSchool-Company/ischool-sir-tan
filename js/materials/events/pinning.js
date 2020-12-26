
$(document).ready(function () {

  $('#pin_modal [name="confirm_button"]').click(function () {

    var pinId = $('#pin_form [name="classrooms"]').val();
    var crName = $('#pin_form [name="classrooms"] option:selected').text();

    $('#loading_modal').modal('show');

    pinMaterials(
      myId,
      classroomId,
      pinId,
      materialsId,
      crName
    );
  });
});

$(document).on('click', '[id^="mtrl"] [name="pin_button"]', function () {

  var rootDOM = $(this).parents('[id^="mtrl"]');
  var id = rootDOM.attr('id').substr(4);

  materialsId = id;

  retrieveClassrooms(
    myId,
    classroomId
  );
});