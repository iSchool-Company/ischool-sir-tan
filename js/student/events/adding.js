
$(document).ready(function () {

  $('#search_form [name="search"]').on({

    'keyup': function () {

      if ($(this).val() === '') {

        $('#empty_search_panel').html(
          'Search a student and you can start adding them. <span class="fa fa-user"></span>'
        );
        $('#empty_search_panel').show();
        $('#search_panel').empty();

        searchTemp = '';
      } else if ($(this).val() !== searchTemp) {

        $('#search_panel').empty();

        showSearch(
          classroomId,
          $(this).val()
        );

        searchTemp = $(this).val();
      }
    }
  });
});

$(document).on('click', '[name="add_button"]', function () {

  var originalButton = $(this);
  var rootDOM = $(this).parents('[id^="srchstd"]');
  var id = rootDOM.attr('id').substr(7);

  originalButton.after(spinnerSmall());
  originalButton.hide();

  $.ajax({
    method: 'POST',
    url: 'database/student/add.php',
    data: {
      classroom_id: classroomId,
      user_id: id,
      teacher_id: myId
    },
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'successful') {

        rootDOM.empty();
        rootDOM.append('<h4 class="text-center">You have successfully added a student!</h4>');

        setTimeout(function () {

          rootDOM.fadeOut(1000);
        }, 1500);

        setTimeout(function () {

          rootDOM.next().remove();
        }, 2000);

        setTimeout(function () {

          rootDOM.remove();

          $('#search_panel').empty();

          showSearch(
            classroomId,
            $('#search_form [name="search"]').val()
          );
        }, 2500);
      }
    }
  });
});