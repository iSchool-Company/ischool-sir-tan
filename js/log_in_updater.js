
$(document).ready(function () {

  updateLogIn();
  setInterval(updateLogIn, 30000);
});

function updateLogIn() {

  $.ajax({
    method: 'post',
    url: 'database/update_log_in.php',
    data: {
      user_id: myId,
      log_in_id: myLogInId
    }
  });
}