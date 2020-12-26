
$(document).ready(function () {

  $('#load_more_gc_button').click(function () {

    $('#gc_convo_loading_panel').show();

    loadMoreGc(
      myId,
      lastId
    );
  });

  $('#gc_convo_form').submit(function (e) {

    e.preventDefault();

    var content = $('#gc_convo_form [name="reply_textarea"]').val();
    var image = $('#gc_convo_form [name="image_r"]')[0].files[0];

    if (content != '') {

      sendGc(
        content,
        image
      );
    }
  });

  $('#gc_convo_modal').on({

    'shown.bs.modal': function () {

      retrieveGcConvo('fresh');

      convoGcRetriever = setInterval(function () {

        retrieveGcConvo('newer');
      }, 3000);
    },

    'hidden.bs.modal': function () {

      resetGcConvoModal();
      clearInterval(convoGcRetriever);
    }
  });

  $('#load_more_gc_convo_button').click(function () {

    $('#load_more_gc_convo_button').hide();

    retrieveGcConvo('later');
  });
});

$(document).on('click', '[id^="gcht"] [name="open_button"]', function () {

  var rootDOM = $(this).parents('[id^="gcht"]');
  var name = rootDOM.find('.inbox-name').text();

  gcId = rootDOM.attr('id').substr(4);

  $('#gc_convo_modal').modal('show');
  $('#gc_convo_modal [name="gc_name"]').text(name);
});