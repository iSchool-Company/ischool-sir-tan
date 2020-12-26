$(document).ready(function () {

  if (myType === 'Teacher') {

    $('[data-target="#class_name_modal"]').show();
    $('[data-target="#subject_name_modal"]').show();
    $('[data-target="#end_date_modal"]').show();
    $('[data-target="#description_modal"]').show();
  } else {

    $('[data-target="#class_name_modal"]').remove();
    $('[data-target="#subject_name_modal"]').remove();
    $('[data-target="#end_date_modal"]').remove();
    $('[data-target="#description_modal"]').remove();
  }
});