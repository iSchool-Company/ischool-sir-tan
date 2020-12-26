
function newNewsFunction() {

  $.ajax({
    url: "database/news/retrieve/display.php",
    data: {
      method: 'newer',
      news_id: firstNewsId
    },
    success: function (data, status) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'found') {

        var news = responseJSON.news;
        var length = news.length;

        if (length > 0) {

          $('#new_news_button').fadeIn(1500);
          $('#new_news_button').text('Read ' + length + ' new news');

          newNewsData = data;
        }
      }
    }
  });
};