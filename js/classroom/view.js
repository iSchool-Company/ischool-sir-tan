
$(document).ready(function () {

  if (myType === 'Student') {

    $('[href="#join_modal"]').show();
    $('[href="#add_modal"]').remove();
    $('[href="#request_modal"]').remove();
  } else if (myType === 'Teacher') {

    $('[href="#join_modal"]').remove();
    $('[href="#add_modal"]').show();
    $('[href="#request_modal"]').show();
  }
});