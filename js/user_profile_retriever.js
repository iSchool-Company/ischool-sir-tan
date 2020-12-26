function retrieveUserRecord(userId) {

  var info;

  $.ajax({
    url: 'database/retrieve_user_record.php',
    data: { user_id: userId },
    async: false,
    success: function (data, status) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'found') {

        info = responseJSON.info;
      }
    }
  });

  return info;
}