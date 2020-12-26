
function showNews(
  news,
  method
) {

  var length = news.length;

  for (var i = 0; i < length; i++) {

    var newsNodeTemp = newsNode(
      news[i].id,
      news[i].image,
      news[i].title,
      news[i].date_time_posted,
      news[i].admin_username,
      news[i].caption
    );

    switch (method) {

      case 'fresh':
      case 'later':
        $('#news_panel').append(newsNodeTemp);
        break;
      case 'newer':
        $('#news_panel').prepend(newsNodeTemp);
        break;
    }
  }
}