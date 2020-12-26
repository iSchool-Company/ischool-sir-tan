
function updateClassroom(
  usrId,
  crId,
  part,
  value
) {

  $.ajax({
    method: 'post',
    url: 'database/overview/update.php',
    data: {
      user_id: usrId,
      classroom_id: crId,
      part: part,
      value: value
    },
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response == 'successful') {

        setTimeout(function () {

          var message = '';
          var modal = '';

          switch (part) {

            case 'class':
              message = '<b class="text-success">Successful!</b> Class name edited!';
              modal = $('#class_name_modal');
              break;

            case 'subject':
              message = '<b class="text-success">Successful!</b> Subject name edited!';
              modal = $('#subject_name_modal');
              break;

            case 'end_date':

              message = '<b class="text-success">Successful!</b> End date edited!';
              modal = $('#end_date_modal');

              setTimeout(function () {
                window.location = 'classrooms_subject_overview.php';
              }, 2000);

              break;

            case 'description':
              message = '<b class="text-success">Successful!</b> Description edited!';
              modal = $('#description_modal');
              break;
          }

          $('#prompt_modal [name="message"]').html(message);
          modal.modal('hide');
          $('#loading_modal').modal('hide');
          $('#prompt_modal').modal('show');
        }, 500);
      }
    }
  });
}