
$(document).ready(function () {

  $('#delete_modal [name="confirm_button"]').click(function () {

    $('#loading_modal').modal('show');
    $('#delete_modal').modal('hide');

    deleteNews(
      newsId
    );
  });
});

$(document).on('click', '[href="#delete_modal"]', function () {

  newsId = $(this).parents('[id^="nws"]').attr('id').substr(3);
});