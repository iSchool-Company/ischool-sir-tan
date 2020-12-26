
$(document).ready(function () {

  if (myType === 'Student') {

    $('#gc_dropdown').remove();
    $('#gc_empty_panel > h4').text('No current group chat.');
  } else {

    $('#gc_dropdown').show();
  }
});