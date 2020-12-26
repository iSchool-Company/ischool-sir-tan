
function checkInput(inputType) {

  var value = inputType.val();

  if (value === '') {

    var message = '';

    switch (inputType.attr('name')) {

      case 'class_name':
        message = 'Please provide the class name!';
        break;

      case 'subject_name':
        message = 'Please provide the subject name!';
        break;

      case 'date_range':
        message = 'Please provide when this classroom will end!';
        break;

      case 'description':
        message = 'Please provide description for this classroom!';
        break;
    }

    showResult(inputType, true, message);

    return true;
  } else {

    showResult(inputType, false, '');

    return false;
  }
}

function checkDate(inputType) {

  var value = inputType.val();

  if (!isValidDate(value)) {

    showResult(inputType, true, 'Please follow the format(mm/dd/yyyy)!');

    return true;
  } else {

    var difference = differenceDate(inputType.val());

    if (difference < 0) {

      showResult(inputType, true, 'Must be ahead from today!');

      return true;
    } else if (difference < 30) {

      showResult(inputType, true, 'Minimum of 30 days!');

      return true;
    } else {

      showResult(inputType, false, '');

      return false;
    }
  }
}

function showDetails(
  className,
  subjectName,
  dateRange
) {

  $('#details_form [name="classroom_name"]').text(className + ' - ' + subjectName);
  $('#details_form [name="class_name"]').text(className);
  $('#details_form [name="subject_name"]').text(subjectName);
  $('#details_form [name="date_range"]').text(dateRange);

  $('#details_modal').modal('show');
}

$(document).ready(function () {

  $('#add_form .form-control').blur(function () {

    var error = checkInput($(this));

    if (!error && $(this).attr('name') === 'date_range') {
      checkDate($(this));
    }
  });

  $('#add_form').submit(function (e) {

    e.preventDefault();

    var className = $('#add_form [name="class_name"]');
    var subjectName = $('#add_form [name="subject_name"]');
    var dateRange = $('#add_form [name="date_range"]');
    var description = $('#add_form [name="description"]');
    var addOk = true;

    addOk = checkInput(className) ? false : addOk;
    addOk = checkInput(subjectName) ? false : addOk;
    addOk = checkInput(description) ? false : addOk;


    if (!checkInput(dateRange)) {

      addOk = checkDate(dateRange) ? false : addOk;
    } else {

      addOk = false;
    }

    if (addOk) {

      $('#loading_modal').modal('show');

      createClassroom(
        myId,
        className.val(),
        subjectName.val(),
        dateRange.val(),
        description.val()
      );
    }
  });

  $('#details_modal [name="go_button"]').click(function () {
    window.location = 'classrooms_subject_overview.php';
  });
});