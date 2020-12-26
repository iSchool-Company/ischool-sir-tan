var path = window.location.pathname;
var page = path.split("/").pop();

switch (page) {

  case 'home.php':
    $('#nav_home').addClass('active');
    $('#nav_home_2').addClass('active');
    break;

  case 'messages.php':
    $('#nav_messages').addClass('active');
    $('#nav_messages_2').addClass('active');
    break;

  case 'notifications.php':
    $('#nav_notifications').addClass('active');
    $('#nav_notifications_2').addClass('active');
    break;

  case 'my_classrooms.php':
    $('#nav_my_classrooms').addClass('active');
    $('#nav_my_classrooms_2').addClass('active');
    break;

  case 'backpack.php':
    $('#nav_backpack').addClass('active');
    $('#nav_backpack_2').addClass('active');
    break;

  case 'classrooms_subject_overview.php':
    $('#nav_subject_overview').addClass('active');
    $('#nav_subject_overview_2').addClass('active');
    break;

  case 'classrooms_my_classmates.php':
    $('#nav_my_classmates').addClass('active');
    $('#nav_my_classmates_2').addClass('active');
    break;

  case 'classrooms_announcements.php':
    $('#nav_announcements').addClass('active');
    $('#nav_announcements_2').addClass('active');
    break;

  case 'classrooms_assignments.php':
    $('#nav_assignments').addClass('active');
    $('#nav_assignments_2').addClass('active');
    break;

  case 'classrooms_quizzes.php':
    $('#nav_quizzes').addClass('active');
    $('#nav_quizzes_2').addClass('active');
    break;

  case 'classrooms_materials.php':
    $('#nav_materials').addClass('active');
    $('#nav_materials_2').addClass('active');
    break;

  case 'classrooms_my_progress.php':
    $('#nav_my_progress').addClass('active');
    $('#nav_my_progress_2').addClass('active');
    break;

  case 'my_profile.php':
    $('#nav_my_profile').addClass('active');
    $('#nav_my_profile_2').addClass('active');
    break;

  case 'activity_log.php':
    $('#nav_activity_log').parents('li').first().addClass('active');
    $('#nav_activity_log_2').addClass('active');
    break;

  default:
    $('#nav_home').addClass('active');
    $('#nav_home_2').addClass('active');
}

$(document).ready(function () {

  $('#nav_sign_out, #nav_sign_out_2').click(function () {

    $.ajax({
      url: 'database/accounts/sign_out.php',
      success: function () {
        window.location = 'index.php';
      }
    });
  });
});