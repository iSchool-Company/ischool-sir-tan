
function showClassrooms(classrooms) {

  var length = classrooms.length;

  var existingClassrooms = '';

  for (var i = 0; i < length; i++) {

    var classroomNodeTemp = classroomNode(
      classrooms[i].classroom_id,
      classrooms[i].class_name,
      classrooms[i].subject_name,
      classrooms[i].teacher_image,
      classrooms[i].teacher_name,
      classrooms[i].status,
      classrooms[i].status_color,
      classrooms[i].count,
      classrooms[i].date_created,
      classrooms[i].end_date,
      classrooms[i].time_remaining
    );

    if (i === 0) {

      if ($('#cr' + classrooms[i].classroom_id).length > 0) {

        if (
          $('#cr' + classrooms[i].classroom_id).attr('id').substr(2)
          ==
          $('[id^="cr"]').first().attr('id').substr(2)
        ) {

          updateClassroomNode(classrooms[i]);
        } else {

          $('#cr' + classrooms[i].classroom_id).remove();
          $('#classroom_panel').prepend(classroomNodeTemp);
          $('#cr' + classrooms[i].classroom_id).hide();
          $('#cr' + classrooms[i].classroom_id).fadeIn(1000);
          $('#cr' + classrooms[i].classroom_id).find('[data-toggle="tooltip"]').tooltip();
        }
      } else {

        $('#classroom_panel').prepend(classroomNodeTemp);
        $('#cr' + classrooms[i].classroom_id).hide();
        $('#cr' + classrooms[i].classroom_id).fadeIn(1000);
        $('#cr' + classrooms[i].classroom_id).find('[data-toggle="tooltip"]').tooltip();
      }
    } else {

      if ($('#cr' + classrooms[i].classroom_id).length > 0) {

        if (
          $('#cr' + classrooms[i].classroom_id).prev().attr('id').substr(2)
          ==
          classrooms[i - 1].classroom_id
        ) {

          updateClassroomNode(classrooms[i]);
        } else {

          $('#cr' + classrooms[i].classroom_id).remove();
          $('#cr' + classrooms[i - 1].classroom_id).after(classroomNodeTemp);
          $('#cr' + classrooms[i].classroom_id).hide();
          $('#cr' + classrooms[i].classroom_id).fadeIn(1000);
          $('#cr' + classrooms[i].classroom_id).find('[data-toggle="tooltip"]').tooltip();
        }
      } else {

        $('#cr' + classrooms[i - 1].classroom_id).after(classroomNodeTemp);
        $('#cr' + classrooms[i].classroom_id).hide();
        $('#cr' + classrooms[i].classroom_id).fadeIn(1000);
        $('#cr' + classrooms[i].classroom_id).find('[data-toggle="tooltip"]').tooltip();
      }
    }

    existingClassrooms += '#cr' + classrooms[i].classroom_id + (i < length - 1 ? ', ' : '');
  }

  $('[id^="cr"]').not(existingClassrooms).remove();
}

function updateClassroomNode(object) {

  var rootDOM = $('#cr' + object.classroom_id);
  var negativeButton = rootDOM.find('[name="negative_button"] > span');
  var classroomName = rootDOM.find('[name="classroom_name"]');
  var teacherImage = rootDOM.find('[name="teacher_image"]');
  var teacherName = rootDOM.find('[name="teacher_name"]');
  var endDate = rootDOM.find('[name="end_date"]');
  var timeRemaining = rootDOM.find('[name="time_remaining"]');
  var statusColor = rootDOM.find('[name="status_color"]');
  var status = rootDOM.find('[name="status"]');
  var stdNum = rootDOM.find('[name="stdnum"]');
  var annNum = rootDOM.find('[name="annnum"]');
  var assNum = rootDOM.find('[name="assnum"]');
  var qzNum = rootDOM.find('[name="qznum"]');
  var matNum = rootDOM.find('[name="matnum"]');
  var negativeFa = myType === 'Student' ? (object.status === 'Pending' ? 'fa-remove' : 'fa-sign-out') : 'fa-trash';

  if (!negativeButton.hasClass(negativeFa)) {
    rootDOM.remove();
  }

  if (classroomName.text() != (object.class_name + ' - ' + object.subject_name)) {
    classroomName.text(object.class_name + ' - ' + object.subject_name);
  }

  if (endDate.text() != object.end_date) {
    endDate.text(object.end_date);
  }

  if (timeRemaining.text() != object.time_remaining) {
    timeRemaining.text(object.time_remaining);
  }

  if (status.text() != object.status) {
    status.text(object.status);
  }

  if (statusColor.css('color') != object.status_color) {
    statusColor.css('color', object.status_color);
  }

  if (stdNum.text() != object.count.std) {
    stdNum.text(object.count.std);
  }

  if (annNum.text() != object.count.ann) {
    annNum.text(object.count.ann);
  }

  if (assNum.text() != object.count.ass) {
    assNum.text(object.count.ass);
  }

  if (qzNum.text() != object.count.qz) {
    qzNum.text(object.count.qz);
  }

  if (matNum.text() != object.count.mat) {
    matNum.text(object.count.mat);
  }
}

function showClassroomRequests(
  method,
  requests
) {

  var length = requests.length;

  for (var i = 0; i < length; i++) {

    var requestNodeTemp = requestNode(
      requests[i].csd_id,
      requests[i].classroom_id,
      requests[i].student_id,
      requests[i].student_image,
      requests[i].student_name,
      requests[i].student_username,
      requests[i].class_name,
      requests[i].subject_name
    );

    switch (method) {

      case 'newer':

        $('#request_panel').prepend(requestNodeTemp);
        break;

      case 'fresh':
      case 'later':

        $('#request_panel').append(requestNodeTemp);
        break;
    }

    $('#reqcr' + requests[i].csd_id).hide();
    $('#reqcr' + requests[i].csd_id).fadeIn(400);
  }

  if ((method === 'fresh' && length == 5) || (method === 'later' && length == 3)) {

    $('#request_load_more_button').show();
  }

  $('#request_loading_panel').hide();
}

function removeNotExisting() {

  var existingRequests = '';

  $.ajax({
    url: 'database/classroom/request/retrieve/existing.php',
    data: {
      first_id: crReqFirstId,
      last_id: crReqLastId,
      user_id: myId
    },
    success: function (data, status) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'found') {

        var existing = responseJSON.existing;
        var length = existing.length;

        for (var i = 0; i < length; i++) {

          existingRequests += '#reqcr' + existing[i];

          if (i < length - 1) {

            existingRequests += ', ';
          }
        }

        $('[id^="reqcr"]').not(existingRequests).fadeOut(500);

        setTimeout(function () {

          $('[id^="reqcr"]').not(existingRequests).remove();
        }, 500);
      } else {

        $('[id^="reqcr"]').remove();
      }
    }
  });
}

function showClassroomSearches(data) {

  var responseJSON = JSON.parse(data);
  var response = responseJSON.response;

  if (response === 'found') {

    var classrooms = responseJSON.classrooms;
    var length = classrooms.length;

    for (var i = 0; i < length; i++) {

      var searchNodeTemp = searchNode(
        classrooms[i].classroom_id,
        classrooms[i].teacher_image,
        classrooms[i].teacher_name,
        classrooms[i].class_name,
        classrooms[i].subject_name
      );

      $('#join_panel').append(searchNodeTemp);

      $('#classroom' + classrooms[i].classroom_id).hide();
      $('#classroom' + classrooms[i].classroom_id).fadeToggle(100);
    }
  } else {

    $('#empty_join_panel > p').text('No classroom matches your search.');
    $('#empty_join_panel').show();
  }
}