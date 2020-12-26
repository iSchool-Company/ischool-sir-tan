
function retrieveNotifCount(usrId) {

  $.ajax({
    url: 'database/notification/retrieve/count.php',
    data: { user_id: usrId },
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'found') {

        var notifCount = $('#nav_notification_count');
        var notifCountNum = $('#nav_notification_count, #nav_notification_count_2');
        var messCount = $('#nav_message_count');
        var messCountNum = $('#nav_message_count, #nav_message_count_2');
        var count = responseJSON.count;

        if (messCount.text() != count.mess && page != 'messages.php') {

          messCountNum.animate({
            fontSize: '+=2px'
          }, 200).animate({
            fontSize: '-=2px'
          }, 200);

          if (count.mess == 0) {

            messCountNum.text('');
          } else {

            messCountNum.text(count.mess);

            if (firstDone) {

              var audio = new Audio('sounds/mes.mp3');
              audio.play();
            }
          }
        }

        if (notifCount.text() != count.notif && page != 'notifications.php') {

          notifCountNum.animate({
            fontSize: '+=2px'
          }, 200).animate({
            fontSize: '-=2px'
          }, 200);

          if (count.notif == 0) {

            notifCountNum.text('');
          } else {

            notifCountNum.text(count.notif);

            if (firstDone) {

              var audio = new Audio('sounds/notif.mp3');
              audio.play();
            }
          }
        }
      } else {

        notifCountNum.text('');
      }
    }
  });
}