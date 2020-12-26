
var newsId = 0;

$(document).ready(function () {

  retrieveNews('fresh');

  $('#load_more_button').click(function () {

    var lastId = $('#news_panel').children().last().attr('id').substr(3);

    retrieveNews(
      'later',
      lastId
    );
  });
});