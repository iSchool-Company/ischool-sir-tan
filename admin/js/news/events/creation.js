
$(document).ready(function () {

  $('#add_form [name="file"]').click(function () {

    $('#add_form [name="file_r"]').click();
  });

  $('#add_form [name="file_r"]').change(function (e) {

    var elem = $(this);
    var file = elem.val();
    var fileName = file.split('\\').pop();

    if (!validImage(elem, file)) {

      $('#add_form [name="file_msg"]').text('.jpg, .png, .gif image only!');
      $('#add_form [name="file_name"]').text('');
      elem.val('');
    } else if (getFileSize(elem) > 25 * 1024) {

      $('#add_form [name="file_msg"]').text('Maximum of 25MB per upload!');
      $('#add_form [name="file_name"]').text('');
      elem.val('');
    } else {

      $('#add_form [name="file"]').text('Change');
      $('#add_form [name="file_msg"]').text('');
      $('#add_form [name="file_name"]').html(
        fileName + ' <a href="#" name="file_remove"><span class="fa fa-remove"></span></a> '
      );
    }
  });

  $('#add_form').submit(function (e) {

    e.preventDefault();

    var title = $('#add_form [name="title"]');
    var content = $('#add_form [name="content"]');
    var file = $('#add_form [name="file_r"]');
    var ok = true;

    if (title.val() === '') {

      showResult(
        title,
        true,
        'Enter a title!'
      );

      ok = false;
    } else {

      showResult(
        title,
        false,
        ''
      );
    }

    if (content.val() === '') {

      showResult(
        content,
        true,
        'Include a content!'
      );

      ok = false;
    } else {

      showResult(
        content,
        false,
        ''
      );
    }

    if (file.val() === '') {

      showResult(
        file,
        true,
        'Include an image!'
      );

      ok = false;
    } else {

      showResult(
        file,
        false,
        ''
      );
    }

    if (ok) {

      $('#loading_modal').modal('show');

      addNews(
        myId,
        title.val(),
        content.val(),
        file[0].files[0]
      );
    }
  });
});