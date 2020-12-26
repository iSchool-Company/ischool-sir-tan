
$(document).ready(function () {

  $('#edit_modal [name="confirm_button"]').click(function () {

    var editForm = $('#edit_form');
    var title = editForm.find('[name="title"]');
    var description = editForm.find('[name="description"]');
    var type = editForm.find('[name="type"]');
    var duration = editForm.find('[name="duration"]');
    var changed = quizType != type.val();

    updateQuiz(
      myId,
      classroomId,
      quizId,
      title.val(),
      description.val(),
      type.val(),
      duration.val(),
      changed
    );
  });

  $('#manage_button [name="edit_button"]').click(function () {

    retrieveQuizEditable(quizId);
  });
});

$(document).on('click', '[id^="qz"] [name="edit_button"]', function () {

  var rootDOM = $(this).parents('[id^="qz"]');
  var id = rootDOM.attr('id').substr(2);

  quizId = id;

  retrieveQuizEditable(quizId);
});