
function removeStudent(
  crId,
  tchrId,
  stdId
) {

  $.ajax({
    method: 'POST',
    url: 'database/student/remove.php',
    data: {
      classroom_id: crId,
      teacher_id: tchrId,
      user_id: stdId
    },
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response == 'successful') {

        setTimeout(function () {

          $('#prompt_modal [name="message"]').html('<b class="text-success">Successful!</b> Student removed!');
          $('#remove_modal').modal('hide');
          $('#loading_modal').modal('hide');
          $('#prompt_modal').modal('show');
        }, 500);
      }
    }
  });
}