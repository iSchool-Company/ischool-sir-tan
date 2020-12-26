
$(document).ready(function () {

  $('#join_form [name="search_bar"]').on({

    'keyup paste': function () {

      var search = $(this).val();

      if (search === '') {

        recentSearch = '';

        $('#join_panel').empty();
        $('#empty_join_panel > p').text('Search a classroom and you can start joining on it.');
        showIfEver($('#empty_join_panel'));
      } else if (search !== recentSearch) {

        $('#join_panel').empty();

        searchClassroom(
          myId,
          search
        );

        recentSearch = search;

        $('#empty_join_panel > p').text('');
        hideIfEver($('#empty_join_panel'));
      }
    }
  });
});

$(document).on('click', '[id^="srchcr"] [name="join_button"]', function () {

  var originalButton = $(this);
  var rootDOM = $(this).parents('[id^="srchcr"]');
  var id = rootDOM.attr('id').substr(6);

  originalButton.after(spinnerSmall());
  originalButton.hide();

  joinClassroom(
    myId,
    id,
    rootDOM,
    originalButton
  );
});