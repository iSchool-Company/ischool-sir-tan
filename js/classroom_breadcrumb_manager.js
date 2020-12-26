
$(document).ready(function () {

  showClassroomBC();

  setInterval(showClassroomBC, 5000);
});

function showClassroomBC() {

  $.ajax({
    url: 'database/classroom/retrieve/name.php',
    data: { classroom_id: classroomId },
    success: function (data, status) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'found') {

        var info = responseJSON.info;

        if (crStatus !== info.status) {

          crStatus = info.status;

          if (crStatus === 'archived') {

            $('body').css('background-color', '#c0c0c0');

            switch (page) {

              case 'classrooms_subject_overview.php':

                $('[data-target="#class_name_modal"]').remove();
                $('[data-target="#subject_name_modal"]').remove();
                $('[data-target="#description_modal"]').remove();

                break;

              case 'classrooms_my_classmates.php':

                $('#add_button').remove();

                break;

              case 'classrooms_announcements.php':

                $('#announcement_form').remove();

                break;

              case 'classrooms_assignments.php':

                $('#add_assignment').remove();
                $('#manage_button').remove();

                break;

              case 'classrooms_quizzes.php':

                $('[data-target="#add_modal"]').remove();
                $('#manage_button').remove();
                $('#add_question_button').remove();

                break;

              case 'classrooms_materials.php':

                $('[data-target="#add_modal"]').remove();

                break;
            }
          }
        }

        if (
          $('#classroom_name').text()
          !=
          (info.class_name + ' - ' + info.subject_name + (crStatus === 'archived' ? '(Archived)' : ''))
        ) {
          $('#classroom_name').text(info.class_name + ' - ' + info.subject_name + (crStatus === 'archived' ? '(Archived)' : ''));
        }

      }
    }
  });
}