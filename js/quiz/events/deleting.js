
$(document).ready(function () {

  $('#delete_modal [name="confirm_button"]').click(function () {

    $('#delete_modal').modal('hide');
    $('#loading_modal').modal('show');

    deleteQuiz(
      myId,
      classroomId,
      quizId
    );
  });
});

$(document).on('click', '[id^="qz"] [name="delete_button"]', function () {

  var rootDOM = $(this).parents('[id^="qz"]');
  var id = rootDOM.attr('id').substr(2);

  quizId = id;
});