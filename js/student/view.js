
$(document).ready(function () {

  if (myType === 'Student') {

    $('#add_button').remove();

    $('#empty_assignment_panel > p').html(
      'Doesn\'t have classmate yet. <span class="fa fa-user"></span>'
    );
  } else {

    $('#add_button').show();
  }

  if (crStatus === 'archived') {

    $('#add_button').remove();
  }
});