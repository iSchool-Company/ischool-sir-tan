
function addMaterials(
  usrId,
  crId,
  fileName,
  file
) {

  var formData = new FormData();

  formData.append('user_id', usrId);
  formData.append('classroom_id', crId);
  formData.append('file_name', fileName);
  formData.append('file', file);

  $.ajax({
    method: 'post',
    url: 'database/materials/add.php',
    data: formData,
    processData: false,
    contentType: false,
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'successful') {

        setTimeout(function () {

          $('#prompt_modal [name="message"]').html('<b class="text-success">Successful!</b> Materials added!');
          $('#add_modal').modal('hide');
          $('#loading_modal').modal('hide');
          $('#prompt_modal').modal('show');
        }, 500);
      } else {

        setTimeout(function () {

          $('#prompt_modal [name="message"]').html('<b class="text-warning">Oops!</b> File name already exists!');
          $('#loading_modal').modal('hide');
          $('#prompt_modal').modal('show');
        }, 500);
      }
    }
  });
}

function deleteMaterials(
  usrId,
  crId,
  mtrlId
) {

  var formData = new FormData();

  formData.append('user_id', usrId);
  formData.append('classroom_id', crId);
  formData.append('materials_id', mtrlId);

  $.ajax({
    method: 'post',
    url: 'database/materials/delete.php',
    data: formData,
    processData: false,
    contentType: false,
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'successful') {

        setTimeout(function () {

          $('#prompt_modal [name="message"]').html('<b class="text-success">Successful!</b> File deleted!');
          $('#delete_modal').modal('hide');
          $('#loading_modal').modal('hide');
          $('#prompt_modal').modal('show');
        }, 500);
      }
    }
  });
}

function updateMaterials(
  usrId,
  crId,
  mtrlId,
  topic,
  file,
  changed
) {

  var formData = new FormData();

  formData.append('user_id', usrId);
  formData.append('classroom_id', crId);
  formData.append('materials_id', mtrlId);
  formData.append('topic', topic);
  formData.append('file', file);
  formData.append('changed', changed);

  $.ajax({
    method: 'post',
    url: 'database/materials/update.php',
    data: formData,
    processData: false,
    contentType: false,
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'successful') {

        setTimeout(function () {

          $('#prompt_modal [name="message"]').html('<b class="text-success">Successful!</b> Materials edited!');
          $('#edit_modal').modal('hide');
          $('#loading_modal').modal('hide');
          $('#prompt_modal').modal('show');
        }, 500);
      } else {

        setTimeout(function () {

          $('#prompt_modal [name="message"]').html('<b class="text-warning">Oops!</b> File name already exists!');
          $('#loading_modal').modal('hide');
          $('#prompt_modal').modal('show');
        }, 500);
      }
    }
  });
}

function backpackMaterials(
  usrId,
  crId,
  mtrlId
) {

  var formData = new FormData();

  formData.append('user_id', usrId);
  formData.append('classroom_id', crId);
  formData.append('materials_id', mtrlId);

  $.ajax({
    method: 'post',
    url: 'database/materials/add_to_backpack.php',
    data: formData,
    processData: false,
    contentType: false,
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'successful') {

        setTimeout(function () {

          $('#prompt_modal [name="message"]').html('<b class="text-success">Successful!</b> Added to backpack!');
          $('#loading_modal').modal('hide');
          $('#prompt_modal').modal('show');
        }, 500);
      } else {

        setTimeout(function () {

          $('#prompt_modal [name="message"]').html('<b class="text-warning">Oops!</b> File name already exists!');
          $('#loading_modal').modal('hide');
          $('#prompt_modal').modal('show');
        }, 500);
      }
    }
  });
}

function pinMaterials(
  usrId,
  crId,
  pinId,
  mtrlId,
  crName
) {

  var formData = new FormData();

  formData.append('user_id', usrId);
  formData.append('classroom_id', crId);
  formData.append('pin_id', pinId);
  formData.append('materials_id', mtrlId);

  $.ajax({
    method: 'post',
    url: 'database/materials/pin.php',
    data: formData,
    processData: false,
    contentType: false,
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'successful') {

        setTimeout(function () {

          $('#prompt_modal [name="message"]').html('<b class="text-success">Successful!</b> Pinned to ' + crName + '!');
          $('#pin_modal').modal('hide');
          $('#loading_modal').modal('hide');
          $('#prompt_modal').modal('show');
        }, 500);
      } else {

        setTimeout(function () {

          $('#prompt_modal [name="message"]').html('<b class="text-warning">Oops!</b> File name already exists!');
          $('#loading_modal').modal('hide');
          $('#prompt_modal').modal('show');
        }, 500);
      }
    }
  });
}

function rateMaterial(
  usrId,
  mtrlId,
  mtrlName,
  rate1,
  rate2,
  rate3,
  rate4,
  rate5,
  content,
  rateValue,
  anonymous
) {

  var formData = new FormData();

  formData.append('user_id', usrId);
  formData.append('materials_id', mtrlId);
  formData.append('rate_1', rate1);
  formData.append('rate_2', rate2);
  formData.append('rate_3', rate3);
  formData.append('rate_4', rate4);
  formData.append('rate_5', rate5);
  formData.append('content', content);
  formData.append('rate_value', rateValue);
  formData.append('anonymous', anonymous ? 1 : 0);

  $.ajax({
    method: 'post',
    url: 'database/materials/rate.php',
    data: formData,
    processData: false,
    contentType: false,
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'successful') {

        setTimeout(function () {

          $('#prompt_modal [name="message"]').html('<b class="text-success">Successful!</b> ' + mtrlName + ' has been rated!');
          $('#rate_modal').modal('hide');
          $('#loading_modal').modal('hide');
          $('#prompt_modal').modal('show');
        }, 500);
      } else if (response === 'existing') {

        $('#prompt_modal [name="message"]').html('<b class="text-warning">Oops!</b> Chosen material has already been rated!');
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