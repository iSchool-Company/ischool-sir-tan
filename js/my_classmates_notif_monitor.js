

function retrieveNewStudentNotif() {

  $.ajax({
    url: 'database/retrieve_student_notif.php',
    data: {
      user_id: myId,
      classroom_id: classroomId
    },
    success: function (data, status) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response == 'found') {

        var students = responseJSON.students;
        var length = students.length;

        for (var i = 0; i < length; i++) {

          $('#students' + students[i] + ' .label').text('New');
        }
      }
    }
  });
}