
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
  rate1,
  rate2,
  rate3,
  rate4,
  rate5,
  rate6,
  rate7,
  rate8,
  rate9,
  rate10,
  rate11,
  content,
  rateValue
) {

  var formData = new FormData();

  formData.append('user_id', usrId);
  formData.append('classroom_id', crId);
  formData.append('rate_1', rate1);
  formData.append('rate_2', rate2);
  formData.append('rate_3', rate3);
  formData.append('rate_4', rate4);
  formData.append('rate_5', rate5);
  formData.append('rate_6', rate6);
  formData.append('rate_7', rate7);
  formData.append('rate_8', rate8);
  formData.append('rate_9', rate9);
  formData.append('rate_10', rate10);
  formData.append('rate_11', rate11);
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