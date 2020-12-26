
$(document).ready(function () {

  if (myType === 'Student') {

    $('#add_assignment').remove();
    $('#manage_button').remove();
    $('#submit_button').show();
    $('[data-target="#submissions_modal"]').remove();
    $('#add_modal').remove();
    $('#publish_modal').remove();
    $('#edit_modal').remove();
    $('#delete_modal').remove();
    $('#pin_modal').remove();
    $('#rate_modal').remove();
    $('#resubmit_modal').remove();
    $('#submissions_modal').remove();

    $('#empty_assignment_panel > p').html(
      'Wait for your teacher to post an assignment. <span class="fa fa-user"></span>'
    );
  } else {

    $('#add_assignment').show();
    $('#manage_button').show();
    $('#submit_button').remove();
    $('[data-target="#submissions_modal"]').show();
    $('#submit_modal').remove();
  }
});