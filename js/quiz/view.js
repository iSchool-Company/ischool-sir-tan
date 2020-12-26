
$(document).ready(function () {

  if (myType === 'Student') {

    $('[data-target="#add_modal"]').remove();
    $('[data-target="#result_modal"]').remove();
    $('#manage_button').remove();
    $('#add_question_button').remove();
    $('#bottom_question_panel').remove();
    $('#manage_question_panel').remove();
  } else {

    $('#take_now_button').remove();
    $('[data-target="#add_modal"]').show();
    $('[data-target="#result_modal"]').show();
    $('#manage_button').show();
    $('#add_question_button').show();
    $('#bottom_question_panel').show();
    $('#manage_question_panel').show();
  }
});