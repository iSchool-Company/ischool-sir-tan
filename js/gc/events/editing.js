
var recentMemberSearch = '';

function retrieveMembers(
  usrId,
  gId,
  search
) {

  $.ajax({
    url: 'database/gc/search_member.php',
    data: {
      user_id: usrId,
      gc_id: gId,
      search: search
    },
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'found') {

        var recipient = responseJSON.recipients;

        var length = recipient.length;

        for (var i = 0; i < length; i++) {

          var memberSearchNodeTemp = memberSearchNode(
            recipient[i].id,
            recipient[i].name,
            recipient[i].image,
            recipient[i].username
          );

          $('#member_search_container').append(memberSearchNodeTemp);
        }
      } else {

        $('#member_search_prompt').text('No result matches your search!');
        $('#member_search_prompt').show();
      }
    }
  });
}

$(document).ready(function () {

  $('#gc_dropdown [name="edit_group_name_button"]').click(function () {

    var gcName = $('#gc_convo_modal [name="gc_name"]').text().trim();

    $('#edit_group_name_form [name="group_name"]').val(gcName);
  });

  $('#edit_group_name_modal [name="confirm_button"]').click(function () {

    var gcName = $('#edit_group_name_form [name="group_name"]').val();

    $('#loading_modal').modal('show');

    renameGc(
      myId,
      gcId,
      gcName
    );
  });

  $('#edit_members_form [name="search_bar"]').on({

    'keyup': function () {

      var search = $('#edit_members_form [name="search_bar"]').val();

      if (search === '') {

        $('#member_search_container').empty();

        $('#member_search_prompt').html(
          'Search your desired student and you can create a Group Chat. ' +
          '<span class="fa fa-user"></span>'
        );
        $('#member_search_prompt').show();

        recentMemberSearch = '';
      } else if (search != recentMemberSearch) {

        $('#member_search_container').empty();
        $('#member_search_prompt').hide();

        retrieveMembers(
          myId,
          gcId,
          search
        );

        recentGCSearch = search;
      }
    },

    'focus': function () {

      var search = $('#edit_members_form [name="search_bar"]').val();

      $('#member_search_panel').fadeIn(500);

      if (search == '') {

        $('#member_search_container').empty();

        $('#member_search_prompt').html(
          'Search your desired student and you can create a Group Chat. ' +
          '<span class="fa fa-user"></span>'
        );
        $('#member_search_prompt').show();

        recentGCSearch = '';
      } else if (search != recentSearch) {

        $('#member_search_container').empty();

        $('#member_search_prompt').hide();

        retrieveGCSearch(
          myId,
          gcId,
          search
        );

        recentGCSearch = search;
      }
    },

    'blur': function () {

      $('#member_search_panel').fadeOut(500);

      setTimeout(function () {
        $('#member_search_container').empty();
      }, 500);
    }
  });
});

$(document).on('click', '[id^="srcmmbr"] [name="add_button"]', function () {

  var rootDOM = $(this).parents('[id^="srcmmbr"]');
  var id = rootDOM.attr('id').substr(7);

  addGcMember(
    gcId,
    id
  );
});

$(document).on('click', '[name="mmbr"] [name="remove_button"]', function () {

  var rootDOM = $(this).parents('[name="mmbr"]');
  var id = rootDOM.attr('value');

  removeGcMember(
    gcId,
    id
  );
});