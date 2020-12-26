$(document).ready(function () {

  if (myType === 'Student') {

    $('#announcement_form').remove();
  } else {

    $('#announcement_form').show();
  }
});