
function retrieveNews(
  method,
  refId
) {

  $.ajax({
    url: 'database/news/retrieve/display.php',
    data: {
      method: method,
      news_id: refId
    },
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'found') {

        var news = responseJSON.news;

        showNews(
          news,
          method
        );
      } else if (method === 'later') {

        $('#load_more_button').text('No more news');
      }
    }
  });
}
