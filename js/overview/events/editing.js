
$(document).ready(function () {

  $('[data-target="#class_name_modal"]').click(function () {

    $('#class_name_form [name="class_name"]').val(details.class_name);
  });

  $('[data-target="#subject_name_modal"]').click(function () {

    $('#subject_name_form [name="subject_name"]').val(details.subject_name);
  });

  $('[data-target="#end_date_modal"]').click(function () {

    $('#end_date_form [name="end_date"]').val(details.date_end_modal);
  });

  $('[data-target="#description_modal"]').click(function () {

    $('#description_form [name="description"]').val(details.description);
  });

  $('#class_name_form [name="class_name"]').blur(function () {

    var input = $(this);
    var value = input.val();

    if (value == '') {

      showResult(input, true, 'Please provide a class name!');
    } else {

      showResult(input, false, '');
    }
  });

  $('#subject_name_form [name="subject_name"]').blur(function () {

    var input = $(this);
    var value = input.val();

    if (value == '') {

      showResult(input, true, 'Please provide a subject name!');
    } else {

      showResult(input, false, '');
    }

  });

  $('#end_date_form [name="end_date"]').blur(function () {

    var input = $(this);
    var value = input.val();

    if (value == '') {

      showResult(input, true, 'Please provide a date end!');
    } else if (!isValidDate(value)) {

      showResult(input, true, 'Please follow the format(mm/dd/yyyy)!');
    } else if (differenceDate(value) < 30) {

      showResult(input, true, 'Minimum of 30 days!');
    } else {

      showResult(input, false, '');
    }
  });

  $('#description_form [name="description"]').blur(function () {

    var input = $(this);
    var value = input.val();

    if (value == '') {

      showResult(input, true, 'Please provide a subject description');
    } else {

      showResult(input, false, '');
    }
  });

  $('#class_name_form').submit(function (e) {

    e.preventDefault();

    var submitOk = true;
    var className = $('#class_name_form [name="class_name"]');

    if (className.val() == '') {
      submitOk = false;
      showResult(className, true, 'Please provide a class name!');
    } else {
      showResult(className, false, '');
    }

    if (submitOk) {

      $('#loading_modal').modal('show');

      updateClassroom(
        myId,
        classroomId,
        'class',
        className.val()
      );
    }
  });

  $('#subject_name_form').submit(function (e) {

    e.preventDefault();

    var submitOk = true;
    var subjectName = $('#subject_name_form [name="subject_name"]');

    if (subjectName.val() == '') {
      submitOk = false;
      showResult(subjectName, true, 'Please provide a subject name!');
    } else {
      showResult(subjectName, false, '');
    }

    if (submitOk) {

      $('#loading_modal').modal('show');

      updateClassroom(
        myId,
        classroomId,
        'subject',
        subjectName.val()
      );
    }
  });

  $('#end_date_form').submit(function (e) {

    e.preventDefault();

    var submitOk = true;
    var endDate = $('#end_date_form [name="end_date"]');

    if (endDate.val() == '') {
      submitOk = false;
      showResult(endDate, true, 'Please provide an end date!');
    } else if (!isValidDate(endDate.val())) {
      submitOk = false;
      showResult(endDate, true, 'Please follow the format(mm/dd/yyyy)!');
    } else if (differenceDate(endDate.val()) < 30) {
      submitOk = false;
      showResult(endDate, true, 'Minimum of 30 days!');
    } else {
      showResult(endDate, false, '');
    }

    if (submitOk) {

      $('#loading_modal').modal('show');

      updateClassroom(
        myId,
        classroomId,
        'end_date',
        endDate.val()
      );
    }
  });

  $('#description_form').submit(function (e) {

    e.preventDefault();

    var submitOk = true;
    var description = $('#description_form [name="description"]');

    if (description.val() == '') {
      submitOk = false;
      showResult(description, true, 'Please provide a description!');
    } else {
      showResult(description, false, '');
    }

    if (submitOk) {

      $('#loading_modal').modal('show');

      updateClassroom(
        myId,
        classroomId,
        'description',
        description.val()
      );
    }
  });
});