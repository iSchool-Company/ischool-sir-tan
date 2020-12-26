
$(document).ready(function () {

  $('#pin_modal [name="confirm_button"]').click(function () {

    var pinId = $('#pin_form [name="classrooms"]').val();
    var crName = $('#pin_form [name="classrooms"] option:selected').text();

    $('#loading_modal').modal('show');

    pinQuiz(
      myId,
      classroomId,
      pinId,
      quizId,
      crName
    );
  });

  $('#manage_button [name="pin_button"]').click(function () {

    retrieveClassrooms(
      myId,
      classroomId
    );
  });
});

$(document).on('click', '[id^="qz"] [name="pin_button"]', function () {

  var rootDOM = $(this).parents('[id^="qz"]');
  var id = rootDOM.attr('id').substr(2);

  quizId = id;

  retrieveClassrooms(
    myId,
    classroomId
  );
});