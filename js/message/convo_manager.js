
function sendMessage(
  content,
  image
) {

  var formData = new FormData();

  formData.append('user_id', myId);
  formData.append('other_id', recipientId);
  formData.append('value', content);
  formData.append('image', image);

  if (newMessage) {

    retrieveConvo('fresh');

    convoRetriever = setInterval(function () {
      retrieveConvo('newer');
    }, 1000);

    convoMode();

    newMessage = false;
  }

  $.ajax({
    method: 'post',
    url: 'database/message/send.php',
    data: formData,
    processData: false,
    contentType: false,
    success: function (data, status) {

      $('#convo_form [name="reply_textarea"]').focus();
      $('#convo_form [name="image_r"]').val('');
      $('#convo_form [name="image_preview"]').hide();
      $('#convo_form [name="image_file_name"]').text('No current picture');
    }
  });
}

function otherContainer(id) {

  return $(
    '<div id="container' + id + '" class="col-md-8"> ' +
    '<div class="media"> ' +
    '<div class="media-left media-bottom"> ' +
    '<img class="img-circle media-object" src="' + recipientImage + '" alt="Not Available" style="width:30px; height:30px; margin:5px 0;"/> ' +
    '</div> ' +
    '<div class="media-body"> ' +
    '</div> ' +
    '</div> ' +
    '</div>'
  );
}

function otherGcContainer(id, image) {

  return $(
    '<div id="container' + id + '" class="col-md-8"> ' +
    '<div class="media"> ' +
    '<div class="media-left media-bottom"> ' +
    '<img class="img-circle media-object" src="' + image + '" alt="Not Available" style="width:30px; height:30px; margin:5px 0;" data-toggle="tooltip"/> ' +
    '</div> ' +
    '<div class="media-body"> ' +
    '</div> ' +
    '</div> ' +
    '</div>'
  );
}

function ownerContainer(id) {

  return $(
    '<div id="container' + id + '" class="col-md-8 col-md-offset-4"> ' +
    '<div class="media"> ' +
    '<div class="media-body"> ' +
    '</div> ' +
    '<div class="media-right media-bottom"> ' +
    '<img class="img-circle media-object" src="' + myImage + '" alt="Not Available" style="width:30px; height:30px; margin:5px 0;"/> ' +
    '</div> ' +
    '</div> ' +
    '</div>'
  );
}

function convoNode(
  id,
  type,
  content,
  dateTime,
  image,
  name
) {

  if (type == 0) {

    return $(
      '<div id="cnv' + id + '" class="message-sender-content"> ' +
      '<p class="text-muted" style="margin:0;font-size:10px;">' + (name === undefined ? '' : name) + '</p>' +
      '<div name="content"> ' + content + '</div> ' +
      '<p class="text-muted" style="display:none;margin:0;font-size:10px;"><i>' + dateTime + '</i></p>' +
      (image != null ? '<a href=" ' + image + '" target="_blank"><img class="img-rounded" src=" ' + image + '" style="width:100%;margin:5px 0;min-height:20px;"></a>' : '') +
      '</div>'
    );
  } else {

    return $(
      '<div id="cnv ' + id + '" class="message-receiver-content"> ' +
      '<p class="text-muted text-right" style="margin:0;font-size:10px;">' + (name === undefined ? '' : name) + '</p>' +
      '<div name="content" style="float:right;"> ' + content + '</div> ' +
      '<br style="clear:both;">' +
      '<p class="text-muted text-right" style="display:none;margin:0;font-size:10px;"><i>' + dateTime + '</i></p>' +
      (image != null ? '<a href=" ' + image + '" target="_blank"><img class="img-rounded" src=" ' + image + '" style="width:100%;margin:5px 0;min-height:20px;"></a>' : '') +
      '</div>'
    );
  }
}

$(document).on('mouseenter', '[id^="cnv"] [name="content"]', function () {
  $(this).nextAll('p').slideDown(100);
});

$(document).on('mouseleave', '[id^="cnv"] [name="content"]', function () {
  $(this).nextAll('p').slideUp(100);
});

function retrieveConvo(way) {

  var data = {};

  switch (way) {

    case 'fresh':

      data = {
        method: way,
        user_id: myId,
        other_id: recipientId
      };
      break;

    case 'newer':

      data = {
        method: way,
        user_id: myId,
        other_id: recipientId,
        ref_id: convoLastId
      };
      break;
  }

  $.ajax({
    url: "database/message/retrieve/convo.php",
    data: data,
    success: function (data, status) {

      showConvo('append', data);
    }
  });
};

function showConvo(
  way,
  data
) {

  var responseJSON = JSON.parse(data);
  var response = responseJSON.response;

  if (response === 'found') {

    var convo = responseJSON.convo;
    var length = convo.length;

    for (var i = 0; i < length; i++) {

      switch (way) {

        case 'append':
          $('#load_more_convo_button').show();
          if (convoFirstContainerId == 0) {
            convoFirstContainerId = convoFirstId = convo[i].id;
            convoFirstSender = convo[i].is_sender;
          }

          if (convoLastSender != convo[i].is_sender) {

            convoLastContainerId = convoLastId = convo[i].id;
            convoLastSender = convo[i].is_sender;

            var containerTemp = convo[i].is_sender == 0 ?
              otherContainer(convo[i].id) :
              ownerContainer(convo[i].id);
            var convoNodeTemp = convoNode(
              convo[i].id,
              convo[i].is_sender,
              convo[i].value,
              convo[i].date_time_sent,
              convo[i].image
            );
            containerTemp.find('.media-body').append(convoNodeTemp);

            $('#convo_panel').append(containerTemp);

            convoNodeTemp.tooltip();
            convoNodeTemp.hide();
            convoNodeTemp.fadeIn(1000);
          } else {

            convoLastId = convo[i].id;

            var convoBody = $('#container' + convoLastContainerId).find('.media-body');
            var convoNodeTemp = convoNode(
              convo[i].id,
              convo[i].is_sender,
              convo[i].value,
              convo[i].date_time_sent,
              convo[i].image
            );

            convoBody.append(convoNodeTemp);

            convoNodeTemp.tooltip();
            convoNodeTemp.hide();
            convoNodeTemp.fadeIn(1000);
          }

          setTimeout(function () {
            $('#convo_panel').parents('.modal-body').first().animate({
              scrollTop: $("#convo_panel").parents('.modal-body').first()[0].scrollHeight
            }, 1000);
          }, 400);
          break;
        case 'prepend':

          if (convoFirstSender != convo[i].is_sender) {

            convoFirstContainerId = convoFirstId = convo[i].id;
            convoFirstSender = convo[i].is_sender;

            var containerTemp = convo[i].is_sender == 0 ?
              otherContainer(convo[i].id) :
              ownerContainer(convo[i].id);
            var convoNodeTemp = convoNode(
              convo[i].id,
              convo[i].is_sender,
              convo[i].value,
              convo[i].date_time_sent
            );
            containerTemp.find('.media-body').prepend(convoNodeTemp);

            $('#convo_panel').prepend(containerTemp);

            convoNodeTemp.tooltip();
            convoNodeTemp.hide();
            convoNodeTemp.fadeIn(1000);
          } else {

            convoFirstId = convo[i].id;

            var convoBody = $('#container' + convoFirstContainerId).find('.media-body');
            var convoNodeTemp = convoNode(convo[i].id, convo[i].is_sender, convo[i].value, convo[i].date_time_sent)

            convoBody.prepend(convoNodeTemp);

            convoNodeTemp.tooltip();
            convoNodeTemp.hide();
            convoNodeTemp.fadeIn(1000);
          }

          break;
      }
    }
  }
}

function scrollConvo() {

  convoFirstDone = false;

  $('#convo_panel').prepend('<span class="text-center" style="display:block;"><img class="text-center" src="pictures/modules/loading.gif" style="width:20px;"></span>');

  $.ajax({
    url: 'database/message/retrieve/convo.php',
    data: {
      method: 'later',
      user_id: myId,
      other_id: recipientId,
      ref_id: convoFirstId
    },
    success: function (data, status) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'found') {

        var flag = $("#container" + convoFirstContainerId).find('.media-body').children().first();

        setTimeout(function () {

          $('#load_more_convo_button').show();

          showConvo('prepend', data);

          convoFirstDone = true;

          $('#convo_panel > span').remove();

        }, 450);

        setTimeout(function () {

          $('#convo_panel').animate({
            scrollTop: flag.offset().top - 250
          }, 10);
        }, 500);
      } else {

        setTimeout(function () {

          $('#convo_panel > span').remove();
          $('#convo_panel').prepend('<p class="text-center">No more messages!</p>');
        }, 500);
      }
    }
  });
}

$(document).ready(function () {

  $('#convo_form').submit(function (e) {

    e.preventDefault();

    var content = $('#convo_form [name="reply_textarea"]').val();
    var image = $('#convo_form [name="image_r"]')[0].files[0];

    if (recipientId != 0 && content != '') {

      $('#convo_form [name="reply_textarea"]').val('');

      sendMessage(content, image);
    }
  });

  $('#load_more_convo_button').on({

    'click': function (e) {

      $('#load_more_convo_button').hide();
      scrollConvo();
    }
  });

  $('#new_message_modal').on('hidden.bs.modal', function () {
    resetConvoModal();
  });
});

$(document).on('click', '[id^="msg"] [name="open_button"]', function () {

  var rootDOM = $(this).parents('[id^="msg"]');
  var image = rootDOM.find('.inbox-img').attr('src');
  var name = rootDOM.find('.inbox-name').text();
  var username = rootDOM.attr('value');

  recipientId = messageDeleteId = rootDOM.attr('id').substr(3);
  recipientImage = image;

  $('#sender_image').attr({ 'src': image });
  $('#sender_username').text('@' + username);
  $('#sender_name').text(name);

  convoMode();

  newMessage = false;

  retrieveConvo('fresh');

  convoRetriever = setInterval(function () {
    retrieveConvo('newer');
  }, 1000);

  $('#new_message_modal').modal('show');
});