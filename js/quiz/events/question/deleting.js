
$(document).ready(function () {

  $('#delete_question_modal [name="confirm_button"]').click(function () {

    deleteQuestion(
      myId,
      classroomId,
      questionId
    );
  });
});

$(document).on('click', '[id^="qstn"] [name="q_delete_button"]', function () {

  var rootDOM = $(this).parents('[id^="qstn"]');
  var id = rootDOM.attr('id').substr(4);

  questionId = id;
});