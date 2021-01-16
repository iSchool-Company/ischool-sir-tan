
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
    var rate1 = rateForm.find('[name="rate_1"]:checked');
    var rate2 = rateForm.find('[name="rate_2"]:checked');
    var rate3 = rateForm.find('[name="rate_3"]:checked');
    var rate4 = rateForm.find('[name="rate_4"]:checked');
    var rate5 = rateForm.find('[name="rate_5"]:checked');
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
        rate1.val(),
        rate2.val(),
        rate3.val(),
        rate4.val(),
        rate5.val(),
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