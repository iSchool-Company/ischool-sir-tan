
$(document).on('click', '[id^="mtrl"] [name="rate_button"]', function () {

  var rootDOM = $(this).parents('[id^="mtrl"]');
  var id = rootDOM.attr('id').substr(4);

  materialsId = id;

  retrieveMaterialsForRating(
    myId,
    classroomId
  );
});

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

  let anonymousSpan = $('#anonymous');

  $('#rate_form [name="anonymous"]').change(function () {

    let elem = $(this);

    if (elem.is(':checked')) {
      anonymousSpan.text('anonymous');
    } else {
      anonymousSpan.text($('#nav_name').text());
    }
  });

  $('#rate_modal [name="submit_button"]').click(function () {

    var rateForm = $('#rate_form');
    var materialSelect = rateForm.find('[name="materials"]');
    var rate1 = rateForm.find('[name="rate_1"]:checked');
    var rate2 = rateForm.find('[name="rate_2"]:checked');
    var rate3 = rateForm.find('[name="rate_3"]:checked');
    var rate4 = rateForm.find('[name="rate_4"]:checked');
    var rate5 = rateForm.find('[name="rate_5"]:checked');
    var content = rateForm.find('[name="content"]');
    var anonymous = rateForm.find('[name="anonymous"]');
    var ok = true;

    var materialSelectValue = materialSelect.val();
    var materialSelectText = materialSelect.find('option:selected').text();
    var contentValue = content.val();
    var anonymousValue = anonymous.prop('checked');

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

      rateMaterial(
        myId,
        materialSelectValue,
        materialSelectText,
        rate1.val(),
        rate2.val(),
        rate3.val(),
        rate4.val(),
        rate5.val(),
        contentValue,
        rateValue,
        anonymousValue
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