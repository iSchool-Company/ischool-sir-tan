
function showNotifications(
  way,
  data
) {

  var responseJSON = JSON.parse(data);
  var response = responseJSON.response;

  if (response === 'found') {

    var notifs = responseJSON.notifs;
    var length = notifs.length;

    $('#empty_notification_panel').hide();

    for (var i = 0; i < length; i++) {

      var fa = '';
      var message = '';

      switch (notifs[i].type) {

        case 'new_request':

          $('[value="new_request"]').parents('[value="' + notifs[i].source_id + '"]').next().remove();
          $('[value="new_request"]').parents('[value="' + notifs[i].source_id + '"]').remove();

          fa = 'fa-users';
          message = 'You have ' + notifs[i].count + ' new ' + (notifs[i].count == 1 ? 'request' : 'requests') + ' in ' + notifs[i].classroom + '.';
          break;

        case 'accept_request':
          fa = 'fa-check';
          message = notifs[i].name + ' accepted your request in ' + notifs[i].classroom + '.';
          break;

        case 'decline_request':
          fa = 'fa-remove';
          message = notifs[i].name + ' declined your request in ' + notifs[i].classroom + '.';
          break;

        case 'cr_delete':
          fa = 'fa-trash';
          message = notifs[i].name + ' deleted ' + notifs[i].classroom + '.';
          break;

        case 'cr_change_name':
          fa = 'fa-pencil-square-o';
          message = notifs[i].name + ' changed the name of ' + notifs[i].classroom + '.';
          break;

        case 'cr_change_date':
          fa = 'fa-pencil-square-o';
          message = notifs[i].name + ' changed the end date of ' + notifs[i].classroom + '.';
          break;

        case 'cr_change_desc':
          fa = 'fa-pencil-square-o';
          message = notifs[i].name + ' changed the description of ' + notifs[i].classroom + '.';
          break;

        case 'new_student':

          $('[value="' + notifs[i].classroom_id + '"]').parents('[value="new_student"]').parents('[id^="ntf"]').next().remove();
          $('[value="' + notifs[i].classroom_id + '"]').parents('[value="new_student"]').parents('[id^="ntf"]').remove();

          fa = 'fa-plus-circle';
          message = notifs[i].name + ' added ' + notifs[i].count + ' new ' + (notifs[i].count == 1 ? 'student' : 'students') + ' in ' + notifs[i].classroom + '.';
          break;

        case 'remove_student':
          fa = 'fa-remove';
          message = notifs[i].name + ' removed ' + notifs[i].other_name + ' in ' + notifs[i].classroom + '.';
          break;

        case 'added_student':
          fa = 'fa-plus-circle';
          message = notifs[i].name + ' added you to ' + notifs[i].classroom + '.';
          break;

        case 'left_student':
          fa = 'fa-sign-out';
          message = notifs[i].name + ' left ' + notifs[i].classroom + '.';
          break;

        case 'removed_student':
          fa = 'fa-remove';
          message = notifs[i].name + ' removed you from ' + notifs[i].classroom + '.';
          break;

        case 'new_announcement':
          fa = 'fa-bullhorn';
          message = notifs[i].name + ' posted a new announcement in ' + notifs[i].classroom + '.';
          break;

        case 'new_comment':

          $('[value="' + notifs[i].type + '"]').parents('[value="' + notifs[i].source_id + '"]').parents('[id^="ntf"]').next().remove();
          $('[value="' + notifs[i].type + '"]').parents('[value="' + notifs[i].source_id + '"]').parents('[id^="ntf"]').remove();

          fa = 'fa-comments';
          message = notifs[i].name + (notifs[i].count >= 1 ? ' and ' + notifs[i].count + (notifs[i].count > 1 ? ' others ' : ' other ') : '') + ' commented on a post in ' + notifs[i].classroom + '.';
          break;

        case 'new_reply':

          $('[value="' + notifs[i].type + '"]').parents('[value="' + notifs[i].source_id + '"]').parents('[id^="ntf"]').next().remove();
          $('[value="' + notifs[i].type + '"]').parents('[value="' + notifs[i].source_id + '"]').parents('[id^="ntf"]').remove();

          fa = 'fa-reply';
          message = notifs[i].name + (notifs[i].count >= 1 ? ' and ' + notifs[i].count + (notifs[i].count > 1 ? ' others ' : ' other ') : '') + ' replied on a comment posted in ' + notifs[i].classroom + '.';
          break;

        case 'new_ann_like':

          $('[value="' + notifs[i].type + '"]').parents('[value="' + notifs[i].source_id + '"]').parents('[id^="ntf"]').next().remove();
          $('[value="' + notifs[i].type + '"]').parents('[value="' + notifs[i].source_id + '"]').parents('[id^="ntf"]').remove();

          fa = 'fa-thumbs-up';
          message = notifs[i].name + (notifs[i].count >= 1 ? ' and ' + notifs[i].count + (notifs[i].count > 1 ? ' others ' : ' other ') : '') + ' liked a post in ' + notifs[i].classroom + '.';
          break;

        case 'new_com_like':

          $('[value="' + notifs[i].type + '"]').parents('[value="' + notifs[i].source_id + '"]').parents('[id^="ntf"]').next().remove();
          $('[value="' + notifs[i].type + '"]').parents('[value="' + notifs[i].source_id + '"]').parents('[id^="ntf"]').remove();

          fa = 'fa-thumbs-up';
          message = notifs[i].name + (notifs[i].count >= 1 ? ' and ' + notifs[i].count + (notifs[i].count > 1 ? ' others ' : ' other ') : '') + ' liked a comment in ' + notifs[i].classroom + '.';
          break;

        case 'new_rep_like':

          $('[value="' + notifs[i].type + '"]').parents('[value="' + notifs[i].source_id + '"]').parents('[id^="ntf"]').next().remove();
          $('[value="' + notifs[i].type + '"]').parents('[value="' + notifs[i].source_id + '"]').parents('[id^="ntf"]').remove();

          fa = 'fa-thumbs-up';
          message = notifs[i].name + (notifs[i].count >= 1 ? ' and ' + notifs[i].count + (notifs[i].count > 1 ? ' others ' : ' other ') : '') + ' liked a reply in ' + notifs[i].classroom + '.';
          break;

        case 'new_assignment':
          fa = 'fa-book';
          message = notifs[i].name + ' posted a new assignment:<i>' + notifs[i].title + '</i> in ' + notifs[i].classroom + '.';
          break;

        case 'cancel_assignment':
          fa = 'fa-remove';
          message = notifs[i].name + ' cancelled assignment:<i>' + notifs[i].title + '</i> in ' + notifs[i].classroom + '.';
          break;

        case 'delete_assignment':
          fa = 'fa-trash';
          message = notifs[i].name + ' deleted assignment:<i>' + notifs[i].title + '</i> in ' + notifs[i].classroom + '.';
          break;

        case 'submit_assignment':
          fa = 'fa-check';
          message = notifs[i].name + (notifs[i].count >= 1 ? ' and ' + notifs[i].count + (notifs[i].count > 1 ? ' other' : ' others') : '') + ' submitted assignment:<i>' + notifs[i].title + '</i> in ' + notifs[i].classroom + '.';
          break;

        case 'rate_assignment':
          fa = 'fa-pencil';
          message = notifs[i].name + ' graded your assignment:<i>' + notifs[i].title + '</i> in ' + notifs[i].classroom + '.';
          break;

        case 'resubmit_assignment':
          fa = 'fa-repeat';
          message = notifs[i].name + ' allowed you to resubmit assignment:<i>' + notifs[i].title + '</i> in ' + notifs[i].classroom + '.';
          break;

        case 'new_quiz':
          fa = 'fa-list-ul';
          message = notifs[i].name + ' posted a new quiz:<i>' + notifs[i].title + '</i> in ' + notifs[i].classroom + '.';
          break;

        case 'cancel_quiz':
          fa = 'fa-remove';
          message = notifs[i].name + ' cancelled quiz:<i>' + notifs[i].title + '</i> in ' + notifs[i].classroom + '.';
          break;

        case 'delete_quiz':
          fa = 'fa-trash';
          message = notifs[i].name + ' deleted quiz:<i>' + notifs[i].title + '</i> in ' + notifs[i].classroom + '.';
          break;

        case 'take_quiz':
          fa = 'fa-pencil-square-o';
          message = notifs[i].name + (notifs[i].count >= 1 ? ' and ' + notifs[i].count + (notifs[i].count > 1 ? ' other' : ' others') : '') + ' took quiz:<i>' + notifs[i].title + '</i> in ' + notifs[i].classroom + '.';
          break;

        case 'retake_quiz':
          fa = 'fa-repeat';
          message = notifs[i].name + ' allowed you to retake quiz:<i>' + notifs[i].title + '</i> in ' + notifs[i].classroom + '.';
          break;

        case 'new_material':
          fa = 'fa-upload';
          message = notifs[i].name + ' posted a new material in ' + notifs[i].classroom + '.';
          break;
      }

      var notifNodeTemp = notifNode(
        notifs[i].id,
        notifs[i].classroom_id,
        notifs[i].source_id,
        notifs[i].type,
        fa,
        message,
        notifs[i].date_time_did,
        notifs[i].seen
      );

      if (!notifs[i].seen) {
        notifNodeTemp.css('background-color', '#dfe3ee');
      }

      switch (way) {

        case 'newer':

          lastId = notifs[i].id;

          $('#notification_panel').prepend(notifNodeTemp);

          break;

        case 'fresh':

          if (firstId === 0) {
            firstId = notifs[length - 1].id;
            lastId = notifs[0].id;
          }

          $('#notification_panel').append(notifNodeTemp);

          break;

        case 'later':

          firstId = notifs[i].id;

          $('#notification_panel').append(notifNodeTemp);

          break;

      }

      $('#ntf' + notifs[i].id).hide();
      $('#ntf' + notifs[i].id).fadeIn(400);
    }
  }

  if (way == 'fresh') {
    if ($('#notification_panel').children('[id^="ntf"]').length == 5) {
      $('#load_more_button').show();
    } else {
      $('#load_more_button').hide();
    }
  }

  if (response === 'nothing' && way === 'later') {

    $('#load_more_button').html('You\'ve reached the oldest notification!');
  }
}