
$(document).ready(function () {

  if (myType === 'Student') {

    $('[data-target="#add_modal"]').remove();
  } else {

    $('[data-target="#add_modal"]').show();
  }
});