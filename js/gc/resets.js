
function resetGcConvoModal() {

  $('#load_more_gc_convo_button').hide();
  $('#gc_convo_panel').empty();
  $('#gc_convo_modal [name="gc_name"]').text('');

  setTimeout(function () {

    convoGcFirstContainerId = 0;
    convoGcFirstConvoId = 0;
    convoGcFirstSender = -1;
    convoGcFirstName = '';
    convoGcLastContainerId = 0;
    convoGcLastConvoId = 0;
    convoGcLastSender = -1;
    convoGcLastName = '';
  }, 500);
}

function resetNewGcModal() {

  $('#new_gc_form [name="name"]').val('');
  $('#new_gc_form [name="message"]').val('');
  $('#new_gc_form [name="search_bar"]').val('');
  $('#new_gc_form [name="gc_members"]').empty();
}

function resetEditGroupNameModal() {

  $('#new_gc_form [name="group_name"]').val('');
}

function showMembers() {

  $.ajax({
    url: 'database/gc/retrieve/members.php',
    data: {
      gc_id: gcId
    },
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'found') {

        var members = responseJSON.members;
        var length = members.length;

        $('#edit_members_modal [name="members"]').empty();

        for (var i = 0; i < length; i++) {

          var memberNodeTemp = memberNode(
            members[i].id,
            members[i].name,
            members[i].image
          );

          $('#edit_members_modal [name="members"]').append(memberNodeTemp);
        }
      }
    }
  });
}

$(document).ready(function () {

  $('#new_gc_modal').on({

    'hidden.bs.modal': function () {

      resetNewGcModal();
    }
  });

  $('#edit_group_name_modal').on({

    'hidden.bs.modal': function () {

      resetEditGroupNameModal();
    }
  });

  $('#edit_members_modal').on({

    'shown.bs.modal': function () {

      showMembers();
    }
  });
});