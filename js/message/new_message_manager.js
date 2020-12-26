
function searchNode(
  id,
  name,
  image,
  username
) {

  return $(
    '<a id="srch' + id + '" href="#" style="text-decoration:none;color:#3b5998;"> ' +
    '<div class="media search-result" style="margin: 5px 20px;"> ' +
    '<div class="media-left"> ' +
    '<img class="img-circle media-object" src="' + image + '" alt="' + username + '" style="width:35px; height:35px;"/> ' +
    '</div> ' +
    '<div class="media-body"> ' +
    '<h5 class="media-heading text-main-black" name="recipient_name">' + name + '</h5> ' +
    '<p class="text-main-black" name="recipient_username">@' + username + '</p> ' +
    '</div> ' +
    '</div> ' +
    '</a>'
  );
}

function retrieveSearch(search) {

  $.ajax({
    url: 'database/message/search.php',
    data: {
      user_type: myType,
      user_id: myId,
      search: search
    },
    success: function (data, status) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'found') {

        var recipients = responseJSON.recipients;

        showSearch(recipients);
      } else {

        $('#new_message_prompt').text('No result matches your search!');
        $('#new_message_prompt').show();
      }
    }
  });
}

function showSearch(data) {

  var length = data.length;

  for (var i = 0; i < length; i++) {

    var searchNodeTemp = searchNode(
      data[i].id,
      data[i].name,
      data[i].image,
      data[i].username
    );

    $('#new_message_search_container').append(searchNodeTemp);
  }
}

function convoMode() {

  $('#new_message_heading').hide();
  $('#sender_details').show();
  $('#new_message_search_main').hide();
  $('[href="#delete_modal"]').show();
}

function resetConvoModal() {

  recentSearch = '';
  recipientId = 0;
  recipientName = '';

  $('#new_message_heading').show();
  $('#sender_details').hide();
  $('#sender_image').attr('src', '');
  $('#sender_name').text('');
  $('#sender_username').text('');
  $('#new_message_search_main').show();
  $('#new_message_search_bar').val('');
  $('#new_message_search_bar').attr('readonly', false);
  $('#convo_panel').empty();
  $('[href="#delete_modal"]').hide();
  $('#load_more_convo_button').hide();

  clearInterval(convoRetriever);

  setTimeout(function () {

    convoFirstContainerId = 0;
    convoFirstConvoId = 0;
    convoFirstSender = -1;
    convoLastContainerId = 0;
    convoLastConvoId = 0;
    convoLastSender = -1;
    convoFirstDone = true;
  }, 500);
}

function validFile(elem, file) {

  var extension = file.split('.').pop().toLowerCase();

  switch (extension) {
    case 'png':
    case 'jpg':
    case 'jpeg':
    case 'gif':
      return true;
      break;
    default:
      return false;
  }
}

function getFileSize(file) {

  return (file[0].files[0].size / 1024).toFixed(2);
}

function readUrl(input) {

  if (input.files && input.files[0]) {

    var reader = new FileReader();

    reader.onload = function (e) {
      $('#convo_form [name="image_preview"]').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
  }
}

$(document).ready(function () {

  $('[href="#new_message_modal"]').click(function () {
    newMessage = true;
  });

  $('#new_message_search_bar').on({

    'keyup': function () {

      var search = $('#new_message_search_bar').val();

      if (search == '') {

        $('#new_message_search_container').empty();

        $('#new_message_prompt').html(
          'Search a friend and you can start sending messages. ' +
          '<span class="fa fa-user"></span>'
        );
        $('#new_message_prompt').show();

        recentSearch = '';
      } else if (search != recentSearch) {

        $('#new_message_search_container').empty();

        $('#new_message_prompt').hide();

        retrieveSearch(search);

        recentSearch = search;
      }
    },

    'click': function () {
      $('#new_message_search_bar').attr('readonly', false);
    },

    'focus': function () {

      var search = $('#new_message_search_bar').val();

      $('#new_message_search_panel').fadeIn(500);

      if (search == '') {

        $('#new_message_search_container').empty();

        $('#new_message_prompt').html(
          'Search a friend and you can start sending messages. ' +
          '<span class="fa fa-user"></span>'
        );
        $('#new_message_prompt').show();

        recentSearch = '';
      } else if (search != recentSearch) {

        $('#new_message_search_container').empty();

        $('#new_message_prompt').hide();

        retrieveSearch(search);

        recentSearch = search;
      }
    },

    'blur': function () {

      $('#new_message_search_panel').fadeOut(500);

      if (recipientName !== '') {

        $('#new_message_search_bar').val(recipientName);
        $('#new_message_search_bar').attr('readonly', true);
      }

      setTimeout(function () {
        $('#new_message_search_container').empty();
      }, 500);
    }
  });

  $('#convo_form [name="image"]').click(function () {
    $('#convo_form [name="image_r"]').click();
  });

  $('#convo_form [name="image_r"]').change(function () {

    var elem = $(this);
    var value = elem.val();

    if (!validFile(elem, value)) {
      $('#convo_form [name="image_file_name"]').text('Image file only!');
      elem.val('');
      $('#convo_form [name="image_preview"]').hide();
    } else if (getFileSize(elem) > 5 * 1024) {
      $('#convo_form [name="image_file_name"]').text('Maximum of 5MB only!');
      elem.val('');
      $('#convo_form [name="image_preview"]').hide();
    } else {
      $('#convo_form [name="image_file_name"]').text(value.split('\\').pop());
      readUrl(this);
      $('#convo_form [name="image_preview"]').show();
    }
  });
});

$(document).on('click', '[id^="srch"]', function () {

  var rootDOM = $(this);
  var id = rootDOM.attr('id').substr(4);
  var image = rootDOM.find('img').attr('src');
  var name = rootDOM.find('[name="recipient_name"]').text();
  var username = rootDOM.find('[name="recipient_username"]').text();

  $('#new_message_search_bar').attr('readonly', true);

  recipientId = id;
  recipientName = name;

  $('#sender_image').attr('src', image);
  $('#sender_name').text(name);
  $('#sender_username').text(username);
  $('#new_message_search_bar').val(name);

  $('#new_message_heading').hide();
  $('#sender_details').show();
});