
function updateNotifs(
  usrId,
  lstId
) {

  $.ajax({
    method: 'post',
    url: "database/notification/update.php",
    data: {
      user_id: usrId,
      last_id: lstId
    }
  });
}