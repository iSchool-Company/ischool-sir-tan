
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