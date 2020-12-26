
function createClassroom(
  id,
  className,
  subjectName,
  dateRange,
  description
) {

  $.ajax({
    method: 'POST',
    url: 'database/classroom/create.php',
    data: {
      user_id: id,
      class_name: className,
      subject_name: subjectName,
      description: description,
      date_end: dateRange
    },
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'successful') {

        setTimeout(function () {

          $('#add_modal').modal('hide');
          $('#loading_modal').modal('hide');

          showDetails(
            className,
            subjectName,
            dateRange
          );
        }, 500);
      }
    }
  });
}

function deleteClassroom(
  id,
  crId
) {

  var url = '';
  var data = {};

  if (myType === 'Student') {

    url = 'database/classroom/leave.php';
    data = {
      user_id: id,
      classroom_id: crId
    };
  } else {

    url = 'database/classroom/delete.php';
    data = {
      user_id: id,
      classroom_id: crId
    };
  }

  $.ajax({
    method: 'POST',
    url: url,
    data: data,
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'successful') {

        setTimeout(function () {

          $('#prompt_modal [name="message"]').html(deleteMessage);
          $('#loading_modal').modal('hide');
          $('#prompt_modal').modal('show');

          $('#cr' + deleteId).fadeToggle(1000);

          classroomId = 0;
          deleteMessage = '';
        }, 500);
      }
    }
  });
}

function updateStudentStatus(
  rootDOM,
  action,
  crId,
  stdId,
  stdName
) {

  var message = '';

  if (action === 'positive') {

    message = 'You have just accepted ' + stdName + '!';
  } else {

    message = 'You have just declined ' + stdName + '!';
  }

  $.ajax({
    method: 'post',
    url: 'database/classroom/request/update.php',
    data: {
      action: action,
      classroom_id: crId,
      user_id: stdId,
      teacher_id: myId
    },
    success: function (data, status) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'successful') {

        rootDOM.find('hr').prevAll().remove();
        rootDOM.prepend('<h4 class="text-center">' + message + '</h4>');

        setTimeout(function () {

          rootDOM.fadeOut(1000);
        }, 1000);

        setTimeout(function () {

          rootDOM.remove();
        }, 2000);
      }
    }
  });
}

function joinClassroom(
  id,
  crId,
  rootDOM,
  originalButton
) {

  $.ajax({
    method: 'POST',
    url: 'database/classroom/join.php',
    data: {
      user_id: id,
      classroom_id: crId
    },
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'successful') {

        rootDOM.find('hr').prevAll().remove();
        rootDOM.prepend('<h4 class="text-center">You have just sent a request!</h4>');

        setTimeout(function () {

          rootDOM.fadeOut(1000);
        }, 1500);

        setTimeout(function () {

          rootDOM.next().remove();
        }, 2000);

        setTimeout(function () {

          var search = $('#join_form [name="search_bar"]').val();

          rootDOM.remove();

          $('#join_panel').empty();

          searchClassroom(
            myId,
            search
          );
        }, 2500);
      }
    }
  });
}

function sessionClassroom(crId) {

  $.ajax({
    method: 'POST',
    url: 'database/classroom/session.php',
    data: { classroom_id: crId },
    success: function () {

      window.location = 'classrooms_subject_overview.php';
    }
  });
}