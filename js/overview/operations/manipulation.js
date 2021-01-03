
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

function rateInstructor(
  usrId,
  crId,
  content,
  rateValue
) {

  var formData = new FormData();

  formData.append('user_id', usrId);
  formData.append('classroom_id', crId);
  formData.append('content', content);
  formData.append('rate_value', rateValue);

  $.ajax({
    method: 'post',
    url: 'database/classroom/rate.php',
    data: formData,
    processData: false,
    contentType: false,
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'successful') {

        setTimeout(function () {

          $('#prompt_modal [name="message"]').html('<b class="text-success">Successful!</b> Instructor has been rated!');
          $('#rate_modal').modal('hide');
          $('#loading_modal').modal('hide');
          $('#prompt_modal').modal('show');
        }, 500);
      } else if (response === 'existing') {

        $('#prompt_modal [name="message"]').html('<b class="text-warning">Oops!</b> Instructor has already been rated!');
        $('#loading_modal').modal('hide');
        $('#prompt_modal').modal('show');
      } else {

        setTimeout(function () {

          $('#prompt_modal [name="message"]').html('<b class="text-warning">Oops!</b> Something went wrong!');
          $('#loading_modal').modal('hide');
          $('#prompt_modal').modal('show');
        }, 500);
      }
    }
  });
}