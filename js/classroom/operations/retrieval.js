
function retrieveClassrooms(
  type,
  id
) {

  $.ajax({
    url: 'database/classroom/retrieve/display.php',
    data: {
      user_type: type,
      user_id: id
    },
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'found') {

        var classrooms = responseJSON.classrooms;

        showClassrooms(classrooms);

        hideIfEver($('#empty_classroom_panel'));
      } else {

        $('[id^="cr"]').remove();

        showIfEver($('#empty_classroom_panel'));
      }
    }
  });
};

function retrieveClassroomRequests(method) {

  var data = {};

  switch (method) {

    case 'fresh':

      data = {
        method: method,
        user_id: myId
      };
      break;

    case 'later':

      data = {
        method: method,
        user_id: myId,
        ref_id: crReqFirstId
      };
      break;

    case 'newer':

      data = {
        method: method,
        user_id: myId,
        ref_id: crReqLastId
      };
      break;
  }

  $.ajax({
    url: 'database/classroom/request/retrieve/display.php',
    data: data,
    success: function (data, status) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'found') {

        var requests = responseJSON.requests;

        showClassroomRequests(
          method,
          requests
        );

        if (method === 'fresh') {

          crReqFirstId = requests[requests.length - 1].csd_id;
          crReqLastId = requests[0].csd_id;
        } else if (method === 'later') {

          crReqFirstId = requests[requests.length - 1].csd_id;
        } else if (method === 'newer') {

          crReqLastId = requests[requests.length - 1].csd_id;
        }

        if (loadingDone) {

          removeNotExisting();
        }
      } else {
        $('#request_loading_panel').hide();

        if (loadingDone) {

          removeNotExisting();
        }
      }

      if ($('#request_panel').children().length == 0) {

        $('#empty_request_panel').show();
      } else {

        $('#empty_request_panel').hide();
      }
    }
  });
}

function searchClassroom(
  id,
  search
) {

  $.ajax({
    url: 'database/classroom/search.php',
    data: {
      user_id: id,
      search: search
    },
    success: function (data) {

      showClassroomSearches(data);
    }
  });
}