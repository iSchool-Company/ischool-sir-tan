
$(document).ready(function () {

  retrieveFresh();

  $('#load_more_button').click(function () {

    $.ajax({
      url: "database/news/retrieve/display.php",
      data: {
        method: 'later',
        news_id: lastNewsId
      },
      async: false,
      success: function (data, status) {
        showNews('after', data);
      }
    });
  });

  $('#new_news_button').click(function () {

    showNews('before', newNewsData);
    $('#new_news_button').hide();
    $('#new_news_button').text('Read 0 new news');
    newNewsData = null;
  });

  $('#back_button').click(function () {

    $('html, body').animate({
      scrollTop: $("#back_button").offset().top
    });

    $('#news_full_content_panel').slideUp(1000);

    newsInterval = setInterval(newNewsFunction, 1000);

    setTimeout(function () {

      $('#news_panel').slideDown(500);
      $('#load_more_button').slideDown(00);

      $('#news_full_content_panel [name="image"]').attr('src', '');
      $('#news_full_content_panel [name="title"]').text('');
      $('#news_full_content_panel [name="caption"]').html('');
      $('#news_full_content_panel [name="date_time"]').text('');
    }, 1000);

    setTimeout(function () {
      $('html, body').animate({
        scrollTop: $("#nw" + lastViewedNewsId).offset().top - 150
      }, 800);
    }, 1500);

    setTimeout(function () {
      $("#nw" + lastViewedNewsId).hide();
      $("#nw" + lastViewedNewsId).fadeIn(500);
    }, 2300);
  });
});

$(document).on('click', '[name="read_more"]', function () {

  var rootDOM = $(this).parents('[id^="nw"]');
  var id = rootDOM.attr('id').substr(2);

  $('#new_news_button').hide();

  newsId = id;

  $.ajax({
    url: 'database/news/retrieve/content.php',
    data: { news_id: id },
    success: function (data, status) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'found') {

        var info = responseJSON.info;

        $('#news_full_content_panel [name="image"]').attr('src', info.image);
        $('#news_full_content_panel [name="title"]').text(info.title);
        $('#news_full_content_panel [name="caption"]').html(info.caption);
        $('#news_full_content_panel [name="date_time"]').text(info.date_time_posted);
      }
    }
  });

  lastViewedNewsId = newsId;

  clearInterval(newsInterval);

  $('#news_panel').slideUp(1000);
  $('#load_more_button').slideUp(1000);

  setTimeout(function () {
    $('#news_full_content_panel').slideDown(1000);
  }, 1000);

  setTimeout(function () {

    $('html, body').animate({
      scrollTop: $("#back_button").offset().top - 50
    });
  }, 2000);
});