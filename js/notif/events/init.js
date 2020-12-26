
$(document).ready(function () {

  retrieveNotifs(
    myId,
    'fresh'
  );

  setInterval(function () {

    retrieveNotifs(
      myId,
      'newer',
      lastId
    );

    updateNotifs(
      myId,
      lastId
    );
  }, 2000);

  $('#load_more_button').click(function () {

    retrieveNotifs(
      myId,
      'later',
      firstId
    );
  });
});

$(document).on('click', '[id^="ntf"]', function () {

  var rootDOM = $(this);
  var id = rootDOM.attr('id').substr(3);
  var src = rootDOM.attr('value');
  var cr = rootDOM.find('a').attr('value');
  var code = rootDOM.children('div').attr('value');

  $.ajax({
    method: 'post',
    url: "database/notification/session.php",
    data: {
      notif_id: id,
      source_id: src,
      notif_cr: cr,
      notif_code: code
    },
    success: function (data) {

      switch (code) {

        case 'new_request':
        case 'accept_request':
        case 'decline_request':
        case 'added_student':
        case 'removed_student':
        case 'cr_delete':
          window.location = 'my_classrooms.php';
          break;

        case 'cr_change_name':
        case 'cr_change_date':
        case 'cr_change_desc':
          window.location = 'classrooms_subject_overview.php';
          break;

        case 'new_student':
        case 'remove_student':
        case 'left_student':
          window.location = 'classrooms_my_classmates.php';
          break;

        case 'new_announcement':
        case 'new_comment':
        case 'new_reply':
        case 'new_ann_like':
        case 'new_com_like':
        case 'new_rep_like':
          window.location = 'classrooms_announcements.php';
          break;

        case 'new_assignment':
        case 'cancel_assignment':
        case 'delete_assignment':
        case 'submit_assignment':
        case 'rate_assignment':
        case 'resubmit_assignment':
          window.location = 'classrooms_assignments.php';
          break;

        case 'new_quiz':
        case 'cancel_quiz':
        case 'delete_quiz':
        case 'take_quiz':
        case 'retake_quiz':
          window.location = 'classrooms_quizzes.php';
          break;

        case 'new_material':
          window.location = 'classrooms_materials.php';
          break;
      }
    }
  });
});