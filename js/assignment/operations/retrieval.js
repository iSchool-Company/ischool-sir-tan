
function retrieveIds(
  type,
  crId,
  usrId
) {

  $.ajax({
    url: 'database/assignment/retrieve/ids.php',
    data: {
      type: type,
      classroom_id: crId,
      user_id: usrId
    },
    success: function (data, status) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'found') {

        var ids = responseJSON.ids;

        fillIds(
          assignmentNode,
          'assmt',
          'assignment',
          ids
        );
      } else {
        resetPanel('assignment');
      }
    }
  });
}

function retrieveDisplay(
  type,
  assmtId,
  usrId,
  version,
  rootDOM
) {

  $.ajax({
    url: 'database/assignment/retrieve/display.php',
    data: {
      type: type,
      assignment_id: assmtId,
      user_id: usrId,
      version: version
    },
    success: function (data) {

      showDisplay(
        data,
        rootDOM
      );
    }
  });
}

function retrieveEditable(assmtId) {

  $.ajax({
    url: 'database/assignment/retrieve/editable.php',
    data: { assignment_id: assmtId },
    success: function (data) {

      showEditable(data);
    }
  });
}

function retrieveContent(
  type,
  assmtId,
  usrId,
  version,
  rootDOM
) {

  $.ajax({
    url: 'database/assignment/retrieve/content.php',
    data: {
      type: type,
      assignment_id: assmtId,
      user_id: usrId,
      version: version
    },
    success: function (data) {

      showContent(
        data,
        rootDOM
      );
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

function retrieveResultIds(
  sort,
  assmtId
) {

  $.ajax({
    url: 'database/assignment/retrieve/result_ids.php',
    data: {
      sort_by: sort,
      assignment_id: assmtId
    },
    success: function (data, status) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'found') {

        var ids = responseJSON.ids;

        fillIds(
          resultNode,
          'resassmt',
          'assignment_result',
          ids
        );
      } else {
        resetPanel('assignment_result');
      }
    }
  });
}

function retrieveResultDisplay(
  assmtsbId,
  rootDOM,
  i
) {

  $.ajax({
    url: 'database/assignment/retrieve/result_display.php',
    data: { submission_id: assmtsbId },
    success: function (data) {

      showResultDisplay(
        data,
        rootDOM,
        i
      );
    }
  });
}