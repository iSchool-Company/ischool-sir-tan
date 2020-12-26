
$(document).ready(function () {

  $('#request_modal').on('shown.bs.modal', function () {

    retrieveClassroomRequests('fresh');

    crReqRetriever = setInterval(function () {

      retrieveClassroomRequests('newer');
    }, 1000);
  });

  $('#request_load_more_button').click(function () {

    loadingDone = false;

    $('#request_load_more_button').hide();
    $('#request_loading_panel').show();

    setTimeout(function () {

      retrieveClassroomRequests('later');
      loadingDone = true;
    }, 500);
  });
});

$(document).on('click', '[name="accept_button"]', function () {

  var acceptButton = $(this);
  var rootDOM = $(this).parents('[id^="reqcr"]');
  var declineButton = rootDOM.find('[name="decline_button"]');
  var loading = rootDOM.find('[name="loading"]');
  var classroomId = rootDOM.find('[name="classroom"]').attr('value');
  var studentId = rootDOM.find('[name="student"]').attr('value');
  var studentName = rootDOM.find('[name="student"]').text();

  acceptButton.hide();
  declineButton.hide();
  declineButton.after(spinnerSmall2());

  setTimeout(function () {

    updateStudentStatus(
      rootDOM,
      'positive',
      classroomId,
      studentId,
      studentName
    );
  }, 500);
});

$(document).on('click', '[name="decline_button"]', function () {

  var declineButton = $(this);
  var rootDOM = $(this).parents('[id^="reqcr"]');
  var acceptButton = rootDOM.find('[name="accept_button"]');
  var loading = rootDOM.find('[name="loading"]');
  var classroomId = rootDOM.find('[name="classroom"]').attr('value');
  var studentId = rootDOM.find('[name="student"]').attr('value');
  var studentName = rootDOM.find('[name="student"]').text();

  acceptButton.hide();
  declineButton.hide();
  declineButton.after(spinnerSmall2());

  setTimeout(function () {

    updateStudentStatus(
      rootDOM,
      'negative',
      classroomId,
      studentId,
      studentName
    );
  }, 500);
});