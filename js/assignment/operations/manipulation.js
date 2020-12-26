
function createAssignment(
  usrId,
  crId,
  title,
  description,
  file,
  publish,
  dueDate,
  dueTime
) {

  var formData = new FormData();

  formData.append('user_id', usrId);
  formData.append('classroom_id', crId);
  formData.append('title', title);
  formData.append('description', description);
  formData.append('publish_now', publish);
  formData.append('due_date', phpDate(dueDate));
  formData.append('due_time', dueTime);
  formData.append('file', file);

  $.ajax({
    method: 'post',
    url: 'database/assignment/create.php',
    data: formData,
    processData: false,
    contentType: false,
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'successful') {

        setTimeout(function () {

          $('#prompt_modal [name="message"]').html(
            '<b class="text-success">Successful!</b> Assignment added!'
          );
          $('#add_modal').modal('hide');
          $('#loading_modal').modal('hide');
          $('#prompt_modal').modal('show');
        }, 500);
      } else {

        setTimeout(function () {

          $('#prompt_modal [name="message"]').html(
            '<b class="text-danger">Oops!</b> Unknown error happened! Please try again!'
          );
          $('#loading_modal').modal('hide');
          $('#prompt_modal').modal('show');
        }, 500);
      }
    }
  });
}

function publishAssignment(
  usrId,
  crId,
  assmtId,
  publish,
  dueDate,
  dueTime
) {

  var formData = new FormData();

  formData.append('user_id', usrId);
  formData.append('classroom_id', crId);
  formData.append('assignment_id', assmtId);
  formData.append('publish_now', publish);
  formData.append('due_date', phpDate(dueDate));
  formData.append('due_time', dueTime);

  $.ajax({
    method: 'post',
    url: 'database/assignment/publish.php',
    data: formData,
    processData: false,
    contentType: false,
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'successful') {

        setTimeout(function () {

          $('#prompt_modal [name="message"]').html(
            '<b class="text-success">Successful!</b> Assignment ' + (publish ? 'published' : 'unpublished') + '!'
          );
          $('#publish_modal').modal('hide');
          $('#loading_modal').modal('hide');
          $('#prompt_modal').modal('show');
        }, 500);
      }
    }
  });
}

function updateAssignment(
  usrId,
  crId,
  assmtId,
  title,
  description,
  changed,
  file
) {

  var formData = new FormData();

  formData.append('user_id', usrId);
  formData.append('classroom_id', crId);
  formData.append('assignment_id', assmtId);
  formData.append('title', title);
  formData.append('description', description);
  formData.append('changed', changed);
  formData.append('file', file);

  $.ajax({
    method: 'post',
    url: 'database/assignment/update.php',
    data: formData,
    processData: false,
    contentType: false,
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'successful') {

        setTimeout(function () {

          $('#prompt_modal [name="message"]').html(
            '<b class="text-success">Successful!</b> Assignment modified!'
          );
          $('#edit_modal').modal('hide');
          $('#loading_modal').modal('hide');
          $('#prompt_modal').modal('show');
        }, 500);
      } else {

        setTimeout(function () {

          $('#prompt_modal [name="message"]').html(
            '<b class="text-danger">Oops!</b> Unknown error happened! Please try again!'
          );
          $('#loading_modal').modal('hide');
          $('#prompt_modal').modal('show');
        }, 500);
      }
    }
  });
}

function deleteAssignment(
  usrId,
  crId,
  assmtId
) {

  var formData = new FormData();

  formData.append('user_id', usrId);
  formData.append('classroom_id', crId);
  formData.append('assignment_id', assmtId);

  $.ajax({
    method: 'post',
    url: 'database/assignment/delete.php',
    data: formData,
    processData: false,
    contentType: false,
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'successful') {

        setTimeout(function () {

          $('#prompt_modal [name="message"]').html(
            '<b class="text-success">Successful!</b> Assignment deleted!'
          );
          $('#delete_modal').modal('hide');
          $('#loading_modal').modal('hide');
          $('#prompt_modal').modal('show');
        }, 500);
      }
    }
  });
}

function backpackAssignment(
  usrId,
  crId,
  assmtId
) {

  var formData = new FormData();

  formData.append('user_id', usrId);
  formData.append('classroom_id', crId);
  formData.append('assignment_id', assmtId);

  $.ajax({
    method: 'post',
    url: 'database/assignment/add_to_backpack.php',
    data: formData,
    processData: false,
    contentType: false,
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'successful') {

        setTimeout(function () {

          $('#prompt_modal [name="message"]').html(
            '<b class="text-success">Successful!</b> Added to backpack!'
          );
          $('#loading_modal').modal('hide');
          $('#prompt_modal').modal('show');
        }, 500);
      } else {

        setTimeout(function () {

          $('#prompt_modal [name="message"]').html(
            '<b class="text-warning">Oops!</b> Already in backpack!'
          );
          $('#loading_modal').modal('hide');
          $('#prompt_modal').modal('show');
        }, 500);
      }
    }
  });
}

function pinAssignment(
  usrId,
  crId,
  pinId,
  assmtId,
  crName
) {

  var formData = new FormData();

  formData.append('user_id', usrId);
  formData.append('classroom_id', crId);
  formData.append('pin_id', pinId);
  formData.append('assignment_id', assmtId);

  $.ajax({
    method: 'post',
    url: 'database/assignment/pin.php',
    data: formData,
    processData: false,
    contentType: false,
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'successful') {

        setTimeout(function () {

          $('#prompt_modal [name="message"]').html('<b class="text-success">Successful!</b> Pinned to ' + crName + '!');
          $('#loading_modal').modal('hide');
          $('#prompt_modal').modal('show');
        }, 500);
      }
    }
  });
}

function submitAssignment(
  usrId,
  crId,
  assmtId,
  file
) {

  var formData = new FormData();

  formData.append('user_id', usrId);
  formData.append('classroom_id', crId);
  formData.append('assignment_id', assmtId);
  formData.append('file', file);

  $.ajax({
    method: 'post',
    url: 'database/assignment/submit.php',
    data: formData,
    processData: false,
    contentType: false,
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'successful') {

        setTimeout(function () {

          $('#prompt_modal [name="message"]').html(
            '<b class="text-success">Successful!</b> Assignment submitted!'
          );
          $('#submit_modal').modal('hide');
          $('#loading_modal').modal('hide');
          $('#prompt_modal').modal('show');
        }, 500);
      }
    }
  });
}

function rateAssignment(
  usrId,
  crId,
  assmtsbId,
  grade
) {

  var formData = new FormData();

  formData.append('user_id', usrId);
  formData.append('classroom_id', crId);
  formData.append('submission_id', assmtsbId);
  formData.append('grade', grade);

  $.ajax({
    method: 'post',
    url: 'database/assignment/rate.php',
    data: formData,
    processData: false,
    contentType: false,
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'successful') {
        hideModal('rate');
      }
    }
  });
}

function resubmitAssignment(
  usrId,
  crId,
  assmtsbId,
  dueDate,
  dueTime
) {

  var formData = new FormData();

  formData.append('user_id', usrId);
  formData.append('classroom_id', crId);
  formData.append('submission_id', assmtsbId);
  formData.append('due_date', phpDate(dueDate));
  formData.append('due_time', dueTime);

  $.ajax({
    method: 'post',
    url: 'database/assignment/resubmit.php',
    data: formData,
    processData: false,
    contentType: false,
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'successful') {
        hideModal('resubmit');
      }
    }
  });
}

function backpackResult(
  usrId,
  crId,
  assmtsbId
) {

  var formData = new FormData();

  formData.append('user_id', usrId);
  formData.append('classroom_id', crId);
  formData.append('submission_id', assmtsbId);

  $.ajax({
    method: 'post',
    url: 'database/assignment/result/add_to_backpack.php',
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

          $('#prompt_modal [name="message"]').html(
            '<b class="text-warning">Oops!</b> Already in backpack!'
          );
          $('#loading_modal').modal('hide');
          $('#prompt_modal').modal('show');
        }, 500);
      }
    }
  });
}