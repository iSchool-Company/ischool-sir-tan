
function showGCSearch(recipient) {

  var length = recipient.length;

  for (var i = 0; i < length; i++) {

    var searchNodeTemp;

    if (recipient[i].type === 'std') {

      searchNodeTemp = searchGcStdNode(
        recipient[i].id,
        recipient[i].name,
        recipient[i].image,
        recipient[i].username
      );
    } else {

      searchNodeTemp = searchGcCrNode(
        recipient[i].id,
        recipient[i].name,
        recipient[i].students.length
      );

      searchNodeTemp.attr('value', JSON.stringify(recipient[i].students));
    }

    $('#new_gc_search_container').append(searchNodeTemp);
  }
}

function showGc(data) {

  var responseJSON = JSON.parse(data);
  var response = responseJSON.response;

  var existingGc = '';

  if (response === 'found') {

    var messages = responseJSON.messages;
    var length = messages.length;

    for (var i = 0; i < length; i++) {

      var messageNodeTemp = gcNode(
        messages[i].gc_id,
        messages[i].other_image,
        messages[i].other_name,
        messages[i].gc_name,
        messages[i].value,
        messages[i].date_time_sent,
        messages[i].seen
      );

      if (myType === 'Student') {

        messageNodeTemp.find('[name="delete_button"]').remove();
      } else {

        messageNodeTemp.find('[name="delete_button"]').show();
      }

      if (i === 0) {

        if ($('#gcht' + messages[i].gc_id).length > 0) {

          var id = $('#gc_panel > [id^="gcht"]').first().attr('id').substr(4);

          if (id == messages[i].gc_id) {

            updateGcNode(messages[i]);
          } else {

            $('#gcht' + messages[i].gc_id).remove();
            $('#gc_panel').prepend(messageNodeTemp);
          }
        } else {

          $('#gc_panel').prepend(messageNodeTemp);
        }
      } else {

        if ($('#gcht' + messages[i].gc_id).length > 0) {

          var id = $('#gcht' + messages[i].gc_id).prev().attr('id').substr(4);

          if (id == messages[i - 1].gc_id) {

            updateGcNode(messages[i]);
          } else {

            $('#gcht' + messages[i].gc_id).remove();
            $('#gcht' + messages[i - 1].gc_id).after(messageNodeTemp);
          }
        } else {

          $('#gcht' + messages[i - 1].gc_id).after(messageNodeTemp);
        }
      }

      existingGc += '#gcht' + messages[i].gc_id + (i < length - 1 ? ', ' : '');
    }

    $('[id^="gcht"]').not(existingGc).remove();
    $('#gc_empty_panel').hide();
    $('#gc_loading_panel').hide();
    $('#load_more_gc_button').show();
  } else {

    $('[id^="gcht"]').remove();
    $('#gc_empty_panel').show();
    $('#gc_loading_panel').hide();
    $('#load_more_gc_button').hide();
  }
}

function updateGcNode(objectTemp) {

  var rootDOM = $('#gcht' + objectTemp.gc_id);
  var image = rootDOM.find('img');
  var name = rootDOM.find('.inbox-name');
  var who = rootDOM.find('[name="who"]');
  var content = rootDOM.find('[name="content"]');
  var dateTime = rootDOM.find('[name="date_time"]');
  var seen = rootDOM.find('[name="new"]');

  if (image.attr('src') != objectTemp.other_image) {
    image.attr('src', objectTemp.other_image);
  }

  if (name.text() != objectTemp.gc_name) {
    name.text(objectTemp.gc_name);
  }

  if (who.text() != objectTemp.other_name) {
    who.text(objectTemp.other_name);
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

function showGcConvo(
  way,
  data
) {

  var responseJSON = JSON.parse(data);
  var response = responseJSON.response;

  $('#gc_convo_loading_panel').hide();

  if (response === 'found') {

    var convo = responseJSON.convo;
    var length = convo.length;

    for (var i = 0; i < length; i++) {

      switch (way) {

        case 'fresh':
        case 'newer':

          if (convoGcFirstContainerId == 0) {
            convoGcFirstContainerId = convoGcFirstId = convo[i].id;
            convoGcFirstSender = convo[i].is_sender;
            convoGcFirstName = convo[i].first_name;
          }

          if (convoGcLastSender != convo[i].is_sender || (convoGcLastName != convo[i].first_name && convo[i].is_sender == 0)) {

            convoGcLastContainerId = convoGcLastId = convo[i].id;
            convoGcLastSender = convo[i].is_sender;
            convoGcLastName = convo[i].first_name;

            var containerTemp = convo[i].is_sender == 0 ?
              otherGcContainer(convo[i].id, convo[i].image) :
              ownerContainer(convo[i].id);
            var convoNodeTemp = convoNode(
              convo[i].id,
              convo[i].is_sender,
              convo[i].value,
              convo[i].date_time_sent,
              null,
              convo[i].is_sender == 0 ? convo[i].first_name : ''
            );
            containerTemp.find('.media-body').append(convoNodeTemp);

            containerTemp.find('img').attr('title', convo[i].first_name);

            $('#gc_convo_panel').append(containerTemp);

            $('#gc_convo_panel').children('[id^="container"]').last().find('[data-toggle="tooltip"]').tooltip();
          } else {

            convoGcLastId = convo[i].id;

            var convoBody = $('#container' + convoGcLastContainerId).find('.media-body');
            var convoNodeTemp = convoNode(
              convo[i].id,
              convo[i].is_sender,
              convo[i].value,
              convo[i].date_time_sent,
              null,
              convo[i].is_sender == 0 ? convo[i].first_name : ''
            );

            convoBody.append(convoNodeTemp);
          }

          setTimeout(function () {
            $('#gc_convo_panel').parents('.modal-body').first().animate({
              scrollTop: $("#gc_convo_panel").parents('.modal-body').first()[0].scrollHeight
            }, 1000);
          }, 400);

          break;
        case 'later':

          if (convoGcFirstSender != convo[i].is_sender || (convoGcFirstName != convo[i].first_name && convo[i].is_sender == 0)) {

            convoGcFirstContainerId = convoGcFirstId = convo[i].id;
            convoGcFirstSender = convo[i].is_sender;
            convoGcFirstName = convo[i].first_name;

            var containerTemp = convo[i].is_sender == 0 ?
              otherGcContainer(convo[i].id, convo[i].image) :
              ownerContainer(convo[i].id);
            var convoNodeTemp = convoNode(
              convo[i].id,
              convo[i].is_sender,
              convo[i].value,
              convo[i].date_time_sent,
              null,
              convo[i].is_sender == 0 ? convo[i].first_name : ''
            );
            containerTemp.find('.media-body').prepend(convoNodeTemp);

            containerTemp.find('img').attr('title', convo[i].first_name);

            $('#gc_convo_panel').prepend(containerTemp);

            $('#gc_convo_panel').children('[id^="container"]').first().find('[data-toggle="tooltip"]').tooltip();
          } else {

            convoGcFirstId = convo[i].id;

            var convoBody = $('#container' + convoGcFirstContainerId).find('.media-body');
            var convoNodeTemp = convoNode(
              convo[i].id,
              convo[i].is_sender,
              convo[i].value,
              convo[i].date_time_sent,
              null,
              convo[i].is_sender == 0 ? convo[i].first_name : ''
            );

            convoBody.prepend(convoNodeTemp);
          }

          break;
      }
    }

    switch (way) {

      case 'fresh':
      case 'later':

        if (length == 5) {

          $('#load_more_gc_convo_button').show();
        } else {

          $('#load_more_gc_convo_button').hide();
          $('#gc_convo_panel').prepend('<p class="text-center">No more messages!</p>');
        }

        break;
    }
  }
}