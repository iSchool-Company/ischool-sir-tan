
function retrieveNotifs(
  usrId,
  method,
  refId
) {

  $.ajax({
    url: "database/notification/retrieve/display.php",
    data: {
      user_id: usrId,
      method: method,
      ref_id: refId
    },
    success: function (data) {

      showNotifications(
        method,
        data
      );
    }
  });
}