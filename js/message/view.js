
$(document).ready(function () {

  if (myType === 'Student') {

    $('[href="#new_gc_modal"]').remove();
  } else if (myType === 'Teacher') {

    $('[href="#new_gc_modal"]').show();
  }
});