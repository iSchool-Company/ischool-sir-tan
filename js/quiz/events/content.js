
$(document).ready(function () {

  $('#quiz_back_button, #quiz_bc').click(function () {

    quizId = 0;

    changeMode(
      'main',
      'quiz',
      'Quizzes',
      'quiz'
    );

    resetContent();
  });
});

$(document).on('click', '[id^="qz"] [name="title"]', function () {

  var rootDOM = $(this).parents('[id^="qz"]');
  var id = rootDOM.attr('id').substr(2);

  quizId = id;

  changeMode(
    'content',
    'quiz',
    'Quizzes',
    'quiz'
  );
});