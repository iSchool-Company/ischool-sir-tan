
$(document).ready(function () {

  if (myType === 'Student') {
    $('#nav_my_progress').remove();
    $('#nav_my_progress_2').remove();
    $('#nav_my_classmates_text').text('My Classmates');
    $('#nav_my_classmates_text_2').text('My Classmates');
  } else {
    $('#nav_my_progress').remove();
    $('#nav_my_progress_2').remove();
    $('#nav_my_classmates_text').text('My Students');
    $('#nav_my_classmates_text_2').text('My Students');
  }
});