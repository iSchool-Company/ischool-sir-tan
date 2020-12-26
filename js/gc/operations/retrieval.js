
function checkName(
  usrId,
  name
) {

  $.ajax({
    url: "database/gc/check.php",
    data: {
      user_id: usrId,
      name: name
    },
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;
      var nameInput = $('#new_gc_form [name="name"]');

      if (response === 'existing') {

        showResult(
          nameInput,
          true,
          'Group Name already exists!'
        );
      } else {

        showResult(
          nameInput,
          false,
          'Group Name available!'
        );
      }
    }
  });
}

function retrieveGCSearch(
  usrId,
  search,
  classrooms,
  students
) {

  $.ajax({
    url: 'database/gc/search.php',
    data: {
      user_id: usrId,
      search: search,
      member_classrooms: classrooms,
      member_students: students
    },
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'found') {

        var recipients = responseJSON.recipients;

        showGCSearch(recipients);
      } else {

        $('#new_gc_prompt').text('No result matches your search!');
        $('#new_gc_prompt').show();
      }
    }
  });
}

function retrieveGc(
  usrId,
  lstId
) {

  $.ajax({
    url: "database/gc/retrieve/messages.php",
    data: {
      user_id: usrId,
      last_id: lstId
    },
    success: function (data) {

      showGc(data);
    }
  });
}

function loadMoreGc(
  usrId,
  lstId
) {

  $.ajax({
    url: "database/gc/retrieve/messages.php",
    data: {
      user_id: usrId,
      last_id: lstId,
      req_id: lstId
    },
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'found') {

        lastId = responseJSON.last_id;

        if (!responseJSON.has_next) {

          $('#gc_loading_panel').remove();
          $('#load_more_gc_button').text('No more messages!');
        }
      } else {

        $('#gc_loading_panel').remove();
        $('#load_more_gc_button').text('No more messages!');
      }
    }
  });
}

function retrieveGcConvo(way) {

  var data = {};

  switch (way) {

    case 'later':

      data = {
        method: way,
        user_id: myId,
        group_chat_id: gcId,
        ref_id: convoGcFirstId
      };

      $('#gc_convo_loading_panel').show();

      break;

    case 'fresh':

      data = {
        method: way,
        user_id: myId,
        group_chat_id: gcId
      };

      $('#gc_convo_loading_panel').show();

      break;

    case 'newer':

      data = {
        method: way,
        user_id: myId,
        group_chat_id: gcId,
        ref_id: convoGcLastId
      };
      break;
  }

  $.ajax({
    url: "database/gc/retrieve/convo.php",
    data: data,
    success: function (data) {

      setTimeout(function () {

        showGcConvo(
          way,
          data
        );
      }, 500);
    }
  });
}