
function createGC(
  usrId,
  name,
  message,
  students
) {

  $.ajax({
    method: 'post',
    url: 'database/gc/create.php',
    data: {
      user_id: usrId,
      name: name,
      members: students,
      value: message
    },
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'successful') {

        setTimeout(function () {

          $('#new_gc_modal').modal('hide');
          $('#loading_modal').modal('hide');
        }, 500);
      }
    }
  });
}

function deleteGc(
  usrId,
  gId
) {

  $.ajax({
    method: 'post',
    url: 'database/gc/delete.php',
    data: {
      user_id: usrId,
      group_chat_id: gId
    },
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'successful') {

        setTimeout(function () {

          $('#prompt_modal [name="message"]').html(
            '<b class="text-success">Successful!</b> Group Chat deleted!'
          );
          $('#gc_convo_modal').modal('hide');
          $('#loading_modal').modal('hide');
          $('#prompt_modal').modal('show');
        }, 500);
      }
    }
  });
}

function renameGc(
  usrId,
  gId,
  name
) {

  $.ajax({
    method: 'post',
    url: 'database/gc/rename.php',
    data: {
      user_id: usrId,
      group_chat_id: gId,
      group_name: name
    },
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'successful') {

        setTimeout(function () {

          $('#prompt_modal [name="message"]').html(
            '<b class="text-success">Successful!</b> Group Chat modified!'
          );

          $('#gc_convo_modal [name="gc_name"]').text(name);

          $('#edit_group_name_modal').modal('hide');
          $('#loading_modal').modal('hide');
          $('#prompt_modal').modal('show');
        }, 500);
      }
    }
  });
}

function sendGc(
  content,
  image
) {

  var formData = new FormData();

  formData.append('user_id', myId);
  formData.append('group_chat_id', gcId);
  formData.append('value', content);
  formData.append('image', image);

  $.ajax({
    method: 'post',
    url: 'database/gc/send.php',
    data: formData,
    processData: false,
    contentType: false,
    success: function (data) {

      $('#gc_convo_form [name="reply_textarea"]').val('');
      $('#gc_convo_form [name="reply_textarea"]').focus();
      $('#gc_convo_form [name="image_r"]').val('');
      $('#gc_convo_form [name="image_preview"]').hide();
      $('#gc_convo_form [name="image_file_name"]').text('No current picture');
    }
  });
}

function addGcMember(
  gId,
  usrId
) {

  var formData = new FormData();

  formData.append('user_id', usrId);
  formData.append('group_chat_id', gId);

  $.ajax({
    method: 'post',
    url: 'database/gc/add.php',
    data: formData,
    processData: false,
    contentType: false,
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'successful') {

        showMembers();
      }
    }
  });
}

function removeGcMember(
  gId,
  usrId
) {

  var formData = new FormData();

  formData.append('user_id', usrId);
  formData.append('group_chat_id', gId);

  $.ajax({
    method: 'post',
    url: 'database/gc/remove.php',
    data: formData,
    processData: false,
    contentType: false,
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'successful') {

        showMembers();
      }
    }
  });
}