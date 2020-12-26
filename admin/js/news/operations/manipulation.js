
function addNews(
  usrId,
  title,
  content,
  file
) {

  var formData = new FormData();

  formData.append('user_id', usrId);
  formData.append('title', title);
  formData.append('content', content);
  formData.append('file', file);

  $.ajax({
    method: 'post',
    url: 'database/news/add.php',
    data: formData,
    processData: false,
    contentType: false,
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'successful') {

        setTimeout(function () {

          $('#prompt_modal [name="message"]').html(
            '<b class="text-success">Successful!</b> News added!'
          );
          $('#add_modal').modal('hide');
          $('#loading_modal').modal('hide');
          $('#prompt_modal').modal('show');

          var firstId = $('#news_panel').children().first().attr('id').substr(3);

          retrieveNews(
            'newer',
            firstId
          );
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

function updateNews(
  id,
  title,
  content,
  file
) {

  var formData = new FormData();

  formData.append('id', id);
  formData.append('title', title);
  formData.append('content', content);
  formData.append('file', file);

  $.ajax({
    method: 'post',
    url: 'database/news/add.php',
    data: formData,
    processData: false,
    contentType: false,
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'successful') {

        setTimeout(function () {

          $('#prompt_modal [name="message"]').html(
            '<b class="text-success">Successful!</b> News edited!'
          );
          $('#edit_modal').modal('hide');
          $('#loading_modal').modal('hide');
          $('#prompt_modal').modal('show');

          $('#nws' + id + ' [name="title"]').text(title);
          $('#nws' + id + ' [name="content"]').text(content);
          $('#nws' + id + ' [name="image"]').attr('src', responseJSON.image);
        }, 500);
      }
    }
  });
}

function deleteNews(
  nwsId
) {

  var formData = new FormData();

  formData.append('news_id', nwsId);

  $.ajax({
    method: 'post',
    url: 'database/news/delete.php',
    data: formData,
    processData: false,
    contentType: false,
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'successful') {

        setTimeout(function () {

          $('#prompt_modal [name="message"]').html(
            '<b class="text-success">Successful!</b> News deleted!'
          );
          $('#loading_modal').modal('hide');
          $('#prompt_modal').modal('show');

          $('#nws' + newsId).remove();
        }, 500);
      }
    }
  });
}