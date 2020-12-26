
var pageNumber = 1;

function retrieveLogInHistory(page) {

  $('#log_in_history_header').siblings().remove();

  $.ajax({
    url: '../database/retrieve_log_in_history.php',
    data: { page_number: page },
    success: function (data, status) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'found') {

        var logInHistory = responseJSON.log_in_history;
        var length = logInHistory.length;

        for (var i = 0; i < length; i++) {

          var logInNodeTemp = logInNode(
            logInHistory[i].id,
            logInHistory[i].log_in,
            logInHistory[i].log_out,
            logInHistory[i].username,
            logInHistory[i].type
          );

          $('#log_in_history_panel').append(logInNodeTemp);
          $('#login' + logInHistory[i].id).hide();
          $('#login' + logInHistory[i].id).fadeIn(500);
        }
      }
    }
  });
}

function logInNode(id, logIn, logOut, username, type) {

  return $(
    '<div id="login' + id + '" class="row"> ' +
    '<div class="col-md-3"> ' +
    '<p>' + logIn + '</p> ' +
    '</div> ' +
    '<div class="col-md-3"> ' +
    '<p>' + logOut + '</p> ' +
    '</div> ' +
    '<div class="col-md-3"> ' +
    '<p>' + username + '</p> ' +
    '</div> ' +
    '<div class="col-md-2"> ' +
    '<p>' + type + '</p> ' +
    '</div> ' +
    '</div>'
  );
}

function showResult(index, pageId) {

  if (pageNumber != index) {

    retrieveLogInHistory(index);

    $('.pagination li:contains(' + pageNumber + ')').removeClass('active');
    $(pageId).addClass('active');

    pageNumber = index;
  }
}

$(document).ready(function () {

  retrieveLogInHistory(1);

  $('#pg_one').addClass('active');

  $('#pg_one').click(function () {

    showResult(1, this);
  });

  $('#pg_two').click(function () {

    showResult(2, this);
  });

  $('#pg_three').click(function () {

    showResult(3, this);
  });

  $('#pg_four').click(function () {

    showResult(4, this);
  });

  $('#pg_five').click(function () {

    showResult(5, this);
  });

  $('#pg_next').click(function () {

    //showResult(this);
  });
});

$(document).on('click', '[href="#"]', function (e) {

  e.preventDefault();
});