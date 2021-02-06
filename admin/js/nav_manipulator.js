var path = window.location.pathname;
var page = path.split("/").pop();

switch (page) {

  case 'home.php':
    $('#nav_home').addClass('active');
    break;

  case 'news.php':
    $('#nav_news').addClass('active');
    break;

  case 'admins.php':
    $('#nav_admins').addClass('active');
    break;

  case 'classrooms.php':
    $('#nav_classrooms').addClass('active');
    break;

  case 'reports.php':
    $('#nav_reports').addClass('active');
    break;

  default:
    $('#nav_home').addClass('active');
}

$(document).ready(function () {

  $('#nav_sign_out').click(function () {

    $.ajax({
      url: 'database/account/sign_out.php',
      success: function () {
        window.location = 'index.php';
      }
    });
  });
});