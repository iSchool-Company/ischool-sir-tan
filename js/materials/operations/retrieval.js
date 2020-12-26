
function retrieveIds(
  usrId,
  crId
) {

  $.ajax({
    url: 'database/materials/retrieve/ids.php',
    data: {
      user_id: usrId,
      classroom_id: crId
    },
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'found') {

        var ids = responseJSON.ids;

        fillIds(
          materialsNode,
          'mtrl',
          'materials',
          ids
        );

        showIfEver($('#materials_panel').prev());
        showIfEver($('#materials_panel'));
      } else {
        resetPanel('materials');
      }
    }
  });
}

function retrieveDisplay(
  mtrlId,
  version,
  rootDOM,
  i
) {

  $.ajax({
    url: 'database/materials/retrieve/display.php',
    data: {
      materials_id: mtrlId,
      version: version
    },
    success: function (data) {

      showDisplay(
        data,
        rootDOM,
        i
      );
    }
  });
}

function retrieveEditable(mtrlId) {

  $.ajax({
    url: 'database/materials/retrieve/editable.php',
    data: {
      materials_id: mtrlId
    },
    success: function (data) {

      showEditable(data);
    }
  });
}

function retrieveClassrooms(
  usrId,
  crId
) {

  $.ajax({
    url: 'database/classroom/retrieve/names.php',
    data: {
      user_id: usrId,
      classroom_id: crId
    },
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'found') {

        var classrooms = responseJSON.classrooms;

        showClassrooms(classrooms);

        $('#pin_modal [name="confirm_button"]').attr('disabled', false);
      } else {

        $('#pin_form [name="classrooms"]').append('<option>No Other Classroom Yet</option>');
        $('#pin_modal [name="confirm_button"]').attr('disabled', true);
      }
    }
  });
}
