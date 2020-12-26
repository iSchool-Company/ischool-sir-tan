
function retrieveStudents(
  usrId,
  crId,
  srch
) {

  $.ajax({
    url: 'database/student/retrieve/display.php',
    async: false,
    data: {
      user_id: usrId,
      classroom_id: crId,
      search: srch
    },
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'found') {

        var students = responseJSON.students;

        $('#empty_student_panel').hide();

        showStudents(students);
      } else {

        $('[id^="std"]').remove();

        if (searching && srch != '') {
          $('#empty_student_panel > p').text('No student matches your search.');
        } else {
          $('#empty_student_panel > p').html('Add a student and you can start discussions. <span class="fa fa-plus-circle"></span>');
        }

        $('#empty_student_panel').show();
      }
    }
  });
}