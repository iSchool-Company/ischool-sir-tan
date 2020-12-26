
function manageRouting() {

  if (myId === 0) {

    $('body').append(routingModal());
    $('#routing_modal').modal('show');

    setTimeout(function () {
      window.location = 'index.php';
    }, 2000);
  } else {

    updateUserRecord();
    setInterval(updateUserRecord, 5000);
  }
}

function routingModal() {

  return $(
    '<div id="routing_modal" class="modal fade"> ' +
    '<div class="modal-dialog modal-sm"> ' +
    '<div class="modal-content"> ' +
    '<div class="modal-body"> ' +
    '<div class="row"> ' +
    '<div class="col-md-12 col-xs-12"> ' +
    '<p class="text-center">You\'re not yet logged in!</p> ' +
    '</div> ' +
    '</div> ' +
    '</div> ' +
    '<div class="modal-footer"> ' +
    '<a class="btn btn-success btn-sm" href="#" type="button" data-dismiss="modal"> ' +
    '<span class="fa fa-thumbs-up"></span> Ok ' +
    '</a> ' +
    '</div> ' +
    '</div> ' +
    '</div> ' +
    '</div>'
  );
}

function updateUserRecord() {

  $.ajax({
    url: 'database/retrieve_user_record.php',
    data: { user_id: myId },
    success: function (data, status) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response == 'found') {

        var info = responseJSON.info;
        var firstName = $('#nav_name').text();
        var image = $('#my_profile_dropdown > a > img, #nav_my_profile > a > img, #dp, #dp2');

        if (firstName != info.first_name) {
          $('#nav_name').text(info.first_name);
        }

        if (image.eq(0).attr('src') != info.profile_picture) {
          image.attr('src', info.profile_picture);
        }
      }
    }
  });
}

function fixNavbarCollapse() {
  $('.navbar-collapse').on('show.bs.collapse', function (e) {
    $('.navbar-collapse').not(this).collapse('hide');
  });
}

function showTooltip() {
  $('[data-toggle="tooltip"]').tooltip();
}

$(document).ready(function () {

  manageRouting();
  fixNavbarCollapse();
  showTooltip();
});

$(document).on('show.bs.modal', '.modal', function () {

  var zIndex = 1040 + (10 * $('.modal:visible').length);

  $(this).css('z-index', zIndex);

  setTimeout(function () {

    $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
  }, 0);
});

$(document).on('hidden.bs.modal', '#routing_modal', function () {
  window.location = 'index.php';
});

$(document).on('submit', 'form', function (e) {
  e.preventDefault();
});

$(document).on('click', '[href="#"]', function (e) {
  e.preventDefault();
});