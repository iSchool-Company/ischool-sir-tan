
$(document).ready(function () {

  $('#assignment_back_button, #ass_bc').click(function () {

    assignmentId = 0;

    changeMode(
      'main',
      'ass',
      'Assignment',
      'assignment'
    );

    resetContent();
  });
});

$(document).on('click', '[id^="assmt"] [name="title"]', function () {

  var rootDOM = $(this).parents('[id^="assmt"]');
  var id = rootDOM.attr('id').substr(5);

  assignmentId = id;

  changeMode(
    'content',
    'ass',
    'Assignment',
    'assignment'
  );
});