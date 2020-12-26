
function retrieveClassroomNotif() {

  $.ajax({
    url: 'database/notification/retrieve/classroom.php',
    data: {
      classroom_id: classroomId,
      user_id: myId
    },
    success: function (data, status) {

      var responseJSON = JSON.parse(data);

      var info = responseJSON.info;
      var rightPlace = true;
      var count = 0;

      if (myType == 'Student') {

        rightPlace = page != 'classrooms_my_classmates.php';
        count =
          parseInt(info.new_student)
          -
          (isNaN(parseInt(info.left_student)) ? 0 : parseInt(info.left_student))
          -
          (isNaN(parseInt(info.remove_student)) ? 0 : parseInt(info.remove_student));

        if (info.new_student != null && rightPlace) {

          $('#nav_my_classmates > .badge, #nav_my_classmates_2 .badge').text(count);
        } else {

          $('#nav_my_classmates > .badge, #nav_my_classmates_2 .badge').text('');
        }

        rightPlace = page != 'classrooms_announcements.php';
        count = parseInt(info.new_announcement);

        if (info.new_announcement != null && rightPlace) {

          $('#nav_announcements > .badge, #nav_announcements_2 .badge').text(count);
        } else {

          $('#nav_announcements > .badge, #nav_announcements_2 .badge').text('');
        }

        rightPlace = page != 'classrooms_assignments.php';
        count =
          parseInt(info.new_assignment)
          -
          (isNaN(parseInt(info.cancel_assignment)) ? 0 : parseInt(info.cancel_assignment))
          -
          (isNaN(parseInt(info.delete_assignment)) ? 0 : parseInt(info.delete_assignment));

        if (info.new_assignment != null && rightPlace) {

          $('#nav_assignments > .badge, #nav_assignments_2 .badge').text(count);
        } else {

          $('#nav_assignments > .badge, #nav_assignments_2 .badge').text('');
        }

        rightPlace = page != 'classrooms_quizzes.php';
        count =
          parseInt(info.new_quiz)
          -
          (isNaN(parseInt(info.cancel_quiz)) ? 0 : parseInt(info.cancel_quiz))
          -
          (isNaN(parseInt(info.delete_quiz)) ? 0 : parseInt(info.delete_quiz));

        if (info.new_quiz != null && rightPlace) {

          $('#nav_quizzes > .badge, #nav_quizzes_2 .badge').text(count);
        } else {

          $('#nav_quizzes > .badge, #nav_quizzes_2 .badge').text('');
        }

        rightPlace = page != 'classrooms_materials.php';
        count = parseInt(info.new_material);

        if (info.new_material != null && rightPlace) {

          $('#nav_materials > .badge, #nav_materials_2 .badge').text(count);
        } else {

          $('#nav_materials > .badge, #nav_materials_2 .badge').text('');
        }
      }
    }
  });
}

$(document).ready(function () {

  //retrieveClassroomNotif();

  //setInterval(retrieveClassroomNotif, 2000);
});