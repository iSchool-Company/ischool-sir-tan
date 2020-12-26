
function showClassroomDetails(data) {

  var responseJSON = JSON.parse(data);
  var response = responseJSON.response;

  if (response == 'found') {

    var info = responseJSON.info;

    if ($('#teacher_image').attr('src') !== info.teacher_image) {

      $('#teacher_image').attr('src', info.teacher_image);
    }

    if ($('#teacher_name').text() !== info.teacher_name) {

      $('#teacher_name').text(info.teacher_name);
    }

    if ($('#teacher_username').text() !== '@' + info.teacher_username) {

      $('#teacher_username').text('@' + info.teacher_username);
    }

    if ($('#class_name').text() !== info.class_name) {

      $('#class_name').text(info.class_name);
    }

    if ($('#subject_name').text() !== info.subject_name) {

      $('#subject_name').text(info.subject_name);
    }

    if ($('#date_end').text() !== info.date_end) {

      $('#date_end').text(info.date_end);
    }

    if ($('#description').text() !== info.description) {

      $('#description').text(info.description)
    }

    details = info;
  }
}