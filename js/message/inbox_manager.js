
function messageNode(
  id,
  image,
  who,
  name,
  username,
  content,
  dateTime,
  seen
) {

  return $(
    '<div id="msg' + id + '" class="panel panel-default panel-gray" value="' + username + '"> ' +
    '<div class="panel-body" style="position: relative;"> ' +
    '<div class="media"> ' +
    '<div class="media-left media-middle"> ' +
    '<img class="img-circle inbox-img" src="' + image + '" alt="Not Available"/> ' +
    '</div> ' +
    '<div class="media-body"> ' +
    '<h4> ' +
    '<span class="inbox-name"> ' + name + '</span> ' +
    '<br class="visible-xs"> ' +
    '<small><i name="date_time"> ' + dateTime + '</i></small> ' +
    '<span class="label label-success" name="new" style="display:' + (seen ? 'none' : '') + ';">' +
    '<span class="fa fa-user"></span> ' +
    '<span>Unread</span> ' +
    '</span> ' +
    '</h4> ' +
    '<p> ' +
    '<b name="who"> ' + who + '</b>: ' +
    '<span name="content"> ' + content + '</span> ' +
    '</p> ' +
    '</div> ' +
    '</div> ' +
    '<hr/> ' +
    '<div> ' +
    '<button class="btn btn-link text-main-green" type="button" name="open_button" style="text-decoration:none;"> ' +
    '<span class="fa fa-folder-open"></span><b class="text-main-black"> Open</b> ' +
    '</button> ' +
    '<button class="btn btn-link text-main-red" type="button" name="delete_button" data-toggle="modal" data-target="#delete_modal" style="text-decoration:none;"> ' +
    '<span class="fa fa-trash"></span><b class="text-main-black"> Delete</b> ' +
    '</button> ' +
    '</div> ' +
    '</div> ' +
    '</div>'
  );
}

function retrieveMessages() {

  $.ajax({
    url: "database/message/retrieve/display.php",
    data: {
      user_id: myId,
      last_offset: messageLastOffset
    },
    success: function (data, status) {
      showMessages(data);
    }
  });
}

function showMessages(data) {

  var responseJSON = JSON.parse(data);
  var response = responseJSON.response;

  existingMessages = '';

  if (response === 'found') {

    var messages = responseJSON.messages;
    var length = messages.length;

    for (var i = 0; i < length; i++) {

      var messageNodeTemp = messageNode(
        messages[i].other_id,
        messages[i].other_image,
        messages[i].who,
        messages[i].other_name,
        messages[i].other_username,
        messages[i].value,
        messages[i].date_time_sent,
        messages[i].seen
      );

      if (i === 0) {

        if ($('#msg' + messages[i].other_id).length > 0) {

          var id = $('#inbox_panel > [id^="msg"]').first().attr('id').substr(3);

          if (id == messages[i].other_id) {
            updateMessageNode(messages[i]);
          } else {
            $('#msg' + messages[i].other_id).remove();
            $('#inbox_panel').prepend(messageNodeTemp);
          }
        } else {
          $('#inbox_panel').prepend(messageNodeTemp);
        }
      } else {

        if ($('#msg' + messages[i].other_id).length > 0) {

          var id = $('#msg' + messages[i].other_id).prev().attr('id').substr(3);

          if (id == messages[i - 1].other_id) {
            updateMessageNode(messages[i]);
          } else {
            $('#msg' + messages[i].other_id).remove();
            $('#msg' + messages[i - 1].other_id).after(messageNodeTemp);
          }
        } else {
          $('#msg' + messages[i - 1].other_id).after(messageNodeTemp);
        }
      }

      existingMessages += '#msg' + messages[i].other_id + (i < length - 1 ? ', ' : '');
    }

    $('[id^="msg"]').not(existingMessages).remove();
    $('#inbox_empty_panel').hide();

    $('#load_more_message_button').show();
    $('#inbox_loading_panel').hide();

    messageTotalOffset = length;

    if (messageLastOffset != messageTotalOffset && !messageLastReached) {
      messageLastReached = true;
    }

    if (!messageLastReached) {
      $('#load_more_message_button').button('reset');
    } else {
      $('#load_more_message_button').text('No more messages!');
    }
  } else {

    $('[id^="msg"]').remove();
    $('#inbox_empty_panel').show();

    $('#load_more_message_button').hide();
  }
}

function updateMessageNode(objectTemp) {

  var rootDOM = $('#msg' + objectTemp.other_id);
  var image = rootDOM.find('img');
  var who = rootDOM.find('[name="who"]');
  var content = rootDOM.find('[name="content"]');
  var dateTime = rootDOM.find('[name="date_time"]');
  var seen = rootDOM.find('[name="new"]');

  if (image.attr('src') != objectTemp.other_image) {
    image.attr('src', objectTemp.other_image);
  }

  if (who.text() != objectTemp.who) {
    who.text(objectTemp.who);
  }

  if (content.text() != objectTemp.value) {
    content.text(objectTemp.value);
  }

  if (dateTime.text() != objectTemp.date_time_sent) {
    dateTime.text(objectTemp.date_time_sent);
  }

  if (seen.css('display') != 'none' && objectTemp.seen) {
    seen.css('display', 'none');
  } else if (seen.css('display') == 'none' && !objectTemp.seen) {
    seen.css('display', '');
  }
}

function deleteConvo() {

  $.ajax({
    method: 'post',
    url: 'database/message/delete.php',
    data: {
      user_id: myId,
      other_id: messageDeleteId
    },
    success: function () {
      $('#new_message_modal').modal('hide');
    }
  });
}

$(document).ready(function () {

  setInterval(retrieveMessages, 2000);

  $('#load_more_message_button').click(function () {

    if (messageLastOffset == messageTotalOffset) {
      $(this).button('loading');
      $('#inbox_loading_panel').show();
      messageLastOffset += 3;
    } else {
      messageLastReached = true;
      $('#load_more_message_button').text('No more messages!');
    }
  });

  $('#delete_modal [name="confirm_button"]').click(function () {
    deleteConvo();
  });
});

$(document).on('click', '[id^="msg"] [name="delete_button"]', function () {

  var rootDOM = $(this).parents('[id^="msg"]');

  messageDeleteId = rootDOM.attr('id').substr(3);
});