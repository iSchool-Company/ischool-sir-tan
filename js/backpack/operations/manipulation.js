
function addBackpack(
  usrId,
  fileName,
  file
) {

  var formData = new FormData();

  formData.append('user_id', usrId);
  formData.append('file_name', fileName);
  formData.append('file', file);

  $.ajax({
    method: 'post',
    url: 'database/backpack/add.php',
    data: formData,
    processData: false,
    contentType: false,
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'successful') {

        setTimeout(function () {

          $('#prompt_modal [name="message"]').html('<b class="text-success">Successful!</b> File added!');
          $('#add_modal').modal('hide');
          $('#loading_modal').modal('hide');
          $('#prompt_modal').modal('show');
        }, 500);
      } else {

        setTimeout(function () {

          $('#prompt_modal [name="message"]').html('<b class="text-warning">Oops!</b> File name exists!');
          $('#loading_modal').modal('hide');
          $('#prompt_modal').modal('show');
        }, 500);
      }
    }
  });
}

function deleteBackpack(
  usrId,
  bckpckId
) {

  var formData = new FormData();

  formData.append('user_id', usrId);
  formData.append('backpack_id', bckpckId);

  $.ajax({
    method: 'post',
    url: 'database/backpack/delete.php',
    data: formData,
    processData: false,
    contentType: false,
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'successful') {

        setTimeout(function () {

          $('#prompt_modal [name="message"]').html('<b class="text-success">Successful!</b> File Deleted!');
          $('#delete_modal').modal('hide');
          $('#loading_modal').modal('hide');
          $('#prompt_modal').modal('show');
        }, 500);
      }
    }
  });
}

function updateBackpack(
  usrId,
  bckpckId,
  fileName,
  file,
  changed
) {

  var formData = new FormData();

  formData.append('user_id', usrId);
  formData.append('backpack_id', bckpckId);
  formData.append('file_name', fileName);
  formData.append('file', file);
  formData.append('changed', changed);

  $.ajax({
    method: 'post',
    url: 'database/backpack/update.php',
    data: formData,
    processData: false,
    contentType: false,
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'successful') {

        setTimeout(function () {

          $('#prompt_modal [name="message"]').html('<b class="text-success">Successful!</b> File Modified!');
          $('#edit_modal').modal('hide');
          $('#loading_modal').modal('hide');
          $('#prompt_modal').modal('show');
        }, 500);
      } else {

        setTimeout(function () {

          $('#prompt_modal [name="message"]').html('<b class="text-warning">Oops!</b> File name exists!');
          $('#loading_modal').modal('hide');
          $('#prompt_modal').modal('show');
        }, 500);
      }
    }
  });
}

function pinBackpack(
  usrId,
  pinId,
  bckpckId,
  crName
) {

  var formData = new FormData();

  formData.append('user_id', usrId);
  formData.append('pin_id', pinId);
  formData.append('backpack_id', bckpckId);

  $.ajax({
    method: 'post',
    url: 'database/backpack/pin.php',
    data: formData,
    processData: false,
    contentType: false,
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'successful') {

        setTimeout(function () {

          $('#prompt_modal [name="message"]').html(
            '<b class="text-success">Successful!</b> File pinned to ' + crName + '!'
          );
          $('#pin_modal').modal('hide');
          $('#loading_modal').modal('hide');
          $('#prompt_modal').modal('show');
        }, 500);
      } else {

        setTimeout(function () {

          $('#prompt_modal [name="message"]').html('<b class="text-warning">Oops!</b> File name exists!');
          $('#loading_modal').modal('hide');
          $('#prompt_modal').modal('show');
        }, 500);
      }
    }
  });
}