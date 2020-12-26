
function retrieveIds(usrId) {

  $.ajax({
    url: 'database/backpack/retrieve/ids.php',
    data: { user_id: usrId },
    success: function (data, status) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'found') {

        var ids = responseJSON.ids;

        fillIds(
          backpackNode,
          'bckpck',
          'backpack',
          ids
        );

        showIfEver($('#backpack_panel').prev());
        showIfEver($('#backpack_panel'));
      } else {
        resetPanel('backpack');
      }
    }
  });
}

function retrieveDisplay(
  bckpckId,
  version,
  rootDOM,
  i
) {

  $.ajax({
    url: 'database/backpack/retrieve/display.php',
    data: {
      backpack_id: bckpckId,
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

function retrieveEditable(bckpckId) {

  $.ajax({
    url: 'database/backpack/retrieve/editable.php',
    data: {
      backpack_id: bckpckId
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

        $('#pin_form [name="classrooms"]').append('<option>No Classroom Yet</option>');
        $('#pin_modal [name="confirm_button"]').attr('disabled', true);
      }
    }
  });
}