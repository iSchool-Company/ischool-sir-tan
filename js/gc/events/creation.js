
function refreshMembers() {

  var gcMember = $('#new_gc_form [name="gc_members"]');

  memberClassrooms = [0];
  memberStudents = [0];

  gcMember.find('[name="gcmemcr"]').each(function () {

    var id = $(this).attr('value');

    memberClassrooms.push(id);
  });

  gcMember.find('[name="gcmemcrstd"]').each(function () {

    var id = $(this).attr('value');

    memberStudents.push(id);
  });

  gcMember.find('[name="gcmemstd"]').each(function () {

    var id = $(this).attr('value');

    memberStudents.push(id);
  });
}

$(document).ready(function () {

  $('#new_gc_form [name="name"]').on('keyup paste', function () {

    var name = $(this);

    if (name.val() === '') {

      showResult(
        name,
        true,
        'Please provide the group name!'
      );
    } else {
      checkName(
        myId,
        name.val()
      );
    }
  });

  $('#new_gc_form [name="search_bar"]').on({

    'keyup': function () {

      var search = $('#new_gc_form [name="search_bar"]').val();

      if (search === '') {

        $('#new_gc_search_container').empty();

        $('#new_gc_prompt').html(
          'Search your desired student and you can create a Group Chat. ' +
          '<span class="fa fa-user"></span>'
        );
        $('#new_gc_prompt').show();

        recentGCSearch = '';
      } else if (search != recentGCSearch) {

        $('#new_gc_search_container').empty();

        $('#new_gc_prompt').hide();

        retrieveGCSearch(
          myId,
          search,
          memberClassrooms.toString(),
          memberStudents.toString()
        );

        recentGCSearch = search;
      }
    },

    'focus': function () {

      var search = $('#new_gc_form [name="search_bar"]').val();

      $('#new_gc_search_panel').fadeIn(500);

      if (search == '') {

        $('#new_gc_search_container').empty();

        $('#new_gc_prompt').html(
          'Search your desired student and you can create a Group Chat. ' +
          '<span class="fa fa-user"></span>'
        );
        $('#new_gc_prompt').show();

        recentGCSearch = '';
      } else if (search != recentSearch) {

        $('#new_gc_search_container').empty();

        $('#new_gc_prompt').hide();

        retrieveGCSearch(
          myId,
          search,
          memberClassrooms.toString(),
          memberStudents.toString()
        );

        recentGCSearch = search;
      }
    },

    'blur': function () {

      $('#new_gc_search_panel').fadeOut(500);

      setTimeout(function () {
        $('#new_gc_search_container').empty();
      }, 500);
    }
  });

  $('#new_gc_form').submit(function (e) {

    e.preventDefault();

    var name = $('#new_gc_form [name="name"]');
    var message = $('#new_gc_form [name="message"]');

    memberStudents.splice(0, 1);
    memberStudents = squash(memberStudents);

    $('#loading_modal').modal('show');

    createGC(
      myId,
      name.val(),
      message.val(),
      memberStudents
    );
  });
});

$(document).on('click', '[id^="gcsrchstd"]', function () {

  var rootDOM = $(this);
  var id = rootDOM.attr('id').substr(9);
  var name = rootDOM.find('[name="name"]').text();
  var image = rootDOM.find('img').attr('src');

  var memStdNodeTemp = memStdNode(
    id,
    name,
    image
  );

  $('#new_gc_form [name="gc_members"]').append(memStdNodeTemp);

  $('#new_gc_form [name="search_bar"]').val('');

  refreshMembers();
});

$(document).on('click', '[id^="gcsrchcr"]', function () {

  var rootDOM = $(this);
  var id = rootDOM.attr('id').substr(8);
  var name = rootDOM.find('[name="name"]').text();
  var students = JSON.parse(rootDOM.attr('value'));
  var length = students.length;

  var memCrNodeTemp = memCrNode(
    id,
    name
  );

  for (var i = 0; i < length; i++) {

    var memCrStdNodeTemp = memCrStdNode(
      students[i].id,
      students[i].name,
      students[i].image
    );

    $('[name="gcmemstd"][value="' + students[i].id + '"]').remove();

    memCrNodeTemp.find('[name="mem"]').append(memCrStdNodeTemp);
  }

  $('#new_gc_form [name="gc_members"]').append(memCrNodeTemp);

  $('#new_gc_form [name="search_bar"]').val('');

  refreshMembers();
});

$(document).on('click', '[name="gcmemcr"] [name="hide"]', function () {

  var rootDOM = $(this).parents('[name="gcmemcr"]');
  var mem = rootDOM.find('[name="mem"]');
  var hide = $(this).find('span');

  mem.slideToggle(200);
  hide.toggleClass('fa-chevron-down fa-chevron-up');
});

$(document).on('change', '[name="gcmemcrstd"] [type="checkbox"]', function () {

  var rootDOM = $(this).parents('[name="gcmemcrstd"]');
  var checked = $(this).is(':checked');
  var id = rootDOM.attr('value');

  if (!checked) {

    $('[name="gcmemcrstd"][value="' + id + '"] [type="checkbox"]').prop('checked', false);
  } else {

    $('[name="gcmemcrstd"][value="' + id + '"] [type="checkbox"]').prop('checked', true);
  }
});

$(document).on('click', '[name="gcmemcr"] [name="close"]', function () {

  var rootDOM = $(this).parents('[name="gcmemcr"]');

  rootDOM.remove();

  refreshMembers();
});

$(document).on('click', '[name="gcmemstd"] [name="close"]', function () {

  var rootDOM = $(this).parents('[name="gcmemstd"]');

  rootDOM.remove();

  refreshMembers();
});