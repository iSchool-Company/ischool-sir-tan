
function showNews(
  way,
  data
) {

  var responseJSON = JSON.parse(data);
  var response = responseJSON.response;

  if (response === 'found') {

    var news = responseJSON.news;
    var length = news.length;

    for (var i = 0; i < length; i++) {

      var newsNodeTemp = newsNode(
        news[i].id,
        news[i].image,
        news[i].title,
        news[i].caption,
        news[i].date_time_posted
      );

      switch (way) {

        case 'append':
          $('#news_panel').append(newsNodeTemp);
          firstNewsId = news[0].id;
          lastNewsId = news[i].id;
          break;

        case 'after':
          $('#nw' + lastNewsId).after(newsNodeTemp);
          lastNewsId = news[i].id;
          break;

        case 'before':
          $('#nw' + firstNewsId).before(newsNodeTemp);
          firstNewsId = news[i].id;
          break;
      }

      $('#nw' + news[i].id).hide();
      $('#nw' + news[i].id).fadeToggle();
    }
  }

  if (response === 'nothing' && way === 'after') {
    $('#load_more_button').html('You\'ve reached the oldest news!');
  }
}

function updateNews() {

  $('[id^="nw"]').each(function () {

    var rootDOM = $(this);

    if (isPartiallyVisible(rootDOM)) {

      var id = rootDOM.attr('id').substr(2);
      var image = rootDOM.find('[name="image"]');
      var title = rootDOM.find('[name="title"]');
      var dateTime = rootDOM.find('[name="date_time"]');
      var caption = rootDOM.find('[name="caption"]');

      $.ajax({
        url: 'database/news/retrieve/content.php',
        data: { news_id: id },
        success: function (data, status) {

          var responseJSON = JSON.parse(data);
          var response = responseJSON.response;

          if (response === 'found') {

            var info = responseJSON.info;

            if (image.attr('src') != info.image) {
              image.attr('src', info.image);
            }

            if (title.text() != info.title) {
              title.text(info.title);
            }

            if (caption.text() != info.caption) {
              caption.html(info.caption);
            }

            if (dateTime.text() != info.date_time) {
              dateTime.text(info.date_time_posted);
            }
          }
        }
      });
    }
  });

  var rootDOM = $('#news_full_content_panel');

  if (rootDOM.css('display') != 'none') {

    var image = rootDOM.find('[name="image"]');
    var title = rootDOM.find('[name="title"]');
    var dateTime = rootDOM.find('[name="date_time"]');
    var caption = rootDOM.find('[name="caption"]');

    $.ajax({
      url: 'database/news/retrieve/content.php',
      data: { news_id: newsId },
      success: function (data, status) {

        var responseJSON = JSON.parse(data);
        var response = responseJSON.response;

        if (response === 'found') {

          var info = responseJSON.info;

          if (image.attr('src') != info.image) {
            image.attr('src', info.image);
          }

          if (title.text() != info.title) {
            title.text(info.title);
          }

          if (caption.text() != info.caption) {
            caption.html(info.caption);
          }

          if (dateTime.text() != info.date_time) {
            dateTime.text(info.date_time_posted);
          }
        }
      }
    });
  }
}

function retrieveFresh() {

  $.ajax({
    url: "database/news/retrieve/display.php",
    data: { method: 'fresh' },
    success: function (data, status) {
      showNews('append', data);
      newsInterval = setInterval(newNewsFunction, 1000);
      newsUpdater = setInterval(updateNews, 5000);
    }
  });
}