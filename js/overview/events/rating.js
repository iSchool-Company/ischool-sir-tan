
$(document).ready(function () {

  $('.rate-negative').click(function () {
    setRateValue('negative');
  });

  $('.rate-neutral').click(function () {
    setRateValue('neutral');
  });

  $('.rate-positive').click(function () {
    setRateValue('positive');
  });

  $('#rate_modal [name="submit_button"]').click(function () {

    var rateForm = $('#rate_form');
    var content = rateForm.find('[name="content"]');
    var ok = true;

    var contentValue = content.val();

    if (contentValue === '') {

      showResult(
        content,
        true,
        'Enter a feedback content!'
      );

      ok = false;
    } else {

      showResult(
        content,
        false,
        ''
      );
    }

    if (ok) {

      $('#loading_modal').modal('show');

      rateInstructor(
        myId,
        classroomId,
        contentValue,
        rateValue
      );
    }
  });
});

function setRateValue(value) {

  let elem = $('.rate-' + rateValue);

  elem.removeClass('active');

  let newElem = $('.rate-' + value);

  newElem.addClass('active');

  rateValue = value;
}