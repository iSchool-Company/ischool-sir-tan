
$(document).ready(function () {

  $('#add_form [name="type"]').change(function () {

    quizType = $(this).val();
  });

  $('#tags [name="check_all"]').click(function () {

    var rootDOM = $('#tags');
    var all = rootDOM.find('[name="mmbr"]').length;
    var checked = rootDOM.find('[name="mmbr"] input:checkbox:checked').length;

    if (all === checked) {

      rootDOM.find('[name="mmbr"] input:checkbox').prop('checked', false);
      $('#tags [name="name"]').text('Some Students');
      $(this).prop('checked', false);
      quizAll = false;
    } else if (checked === 0) {

      rootDOM.find('[name="mmbr"] input:checkbox').prop('checked', true);
      $('#tags [name="name"]').text('All Students');
      $(this).prop('checked', true);
      quizAll = true;
    } else {

      rootDOM.find('[name="mmbr"] input:checkbox').prop('checked', true);
      $('#tags [name="name"]').text('All Students');
      $(this).prop('checked', true);
      quizAll = true;
    }
  });

  $('#tags [name="hide"]').click(function () {

    var rootDOM = $('#tags');
    var mem = rootDOM.find('[name="members"]');
    var hide = $(this).find('span');

    mem.slideToggle(200);
    hide.toggleClass('fa-chevron-down fa-chevron-up');
  });

  $('#add_form [name="question_now"]').change(function () {

    if ($(this).is(':checked')) {

      $('#add_question_panel').show();
      $('#add_question_button_panel').show();
      $('#add_form [name="type"]').attr('disabled', true);

      addQstn('#add_question_panel');
    } else {

      $('#add_question_panel').empty();
      $('#add_question_panel').hide();
      $('#add_question_button_panel').hide();
      $('#add_form [name="type"]').attr('disabled', false);
      $('#add_form [name="publish_now"]').prop('checked', false);
      $('#add_form [name="publish_fg"]').hide();
      $('#add_form [name="due_date_fg"]').hide();
      $('#add_form [name="due_date"]').val('');
      $('#add_form [name="due_time"]').find('option:eq(1)').prop('selected', true);

      clearResult($('#add_form [name="due_date"]'));
      clearResult($('#add_form [name="due_time"]'));

      qstnLength = 0;
    }
  });

  $('#add_question_button_panel button').click(function () {

    var count = $('#add_question_button_panel select');

    for (var i = 0; i < count.val(); i++) {
      addQstn('#add_question_panel');
    }

    count.val('1');
  });

  $('#add_form [name="publish_now"]').click(function () {

    if ($(this).is(':checked')) {

      $('#add_form [name="due_date_fg"]').show();
    } else {

      $('#add_form [name="due_date_fg"]').hide();
      $('#add_form [name="due_date"]').val('');
      $('#add_form [name="due_time"]').find('option:eq(1)').prop('selected', true);
    }
  });

  $('#add_form').submit(function (e) {

    e.preventDefault();

    var submitOk = true;
    var form = $(this);
    var title = form.find('[name="title"]');
    var description = form.find('[name="description"]');
    var type = form.find('[name="type"]');
    var duration = form.find('[name="duration"]');
    var questions = [];
    var publish = form.find('[name="publish_now"]');
    var dueDate = form.find('[name="due_date"]');
    var dueTime = form.find('[name="due_time"]');
    var students = [];

    if (title.val() === '') {

      showResult(
        title,
        true,
        'Please provide a title!'
      );

      submitOk = false;
    } else {

      showResult(
        title,
        false,
        ''
      );
    }

    if (description.val() === '') {

      showResult(
        description,
        true,
        'Please provide a description!'
      );

      submitOk = false;
    } else {

      showResult(
        description,
        false,
        ''
      );
    }

    if (publish.is(':checked')) {

      if (dueDate.val() === '') {

        showResult(
          dueDate,
          true,
          'Enter due date!'
        );

        ok = false;
      } else if (!isValidDate(dueDate.val())) {

        showResult(
          dueDate,
          true,
          'Invalid format(<b>mm/dd/yyyy</b>)!'
        );

        ok = false;
      } else if (differenceDate2(dueDate.val(), dueTime.val()) < 1) {

        showResult(
          dueDate,
          true,
          'Must be 1 hour ahead!'
        );

        ok = false;
      } else {

        showResult(
          dueDate,
          false,
          '<b>Format:</b> mm/dd/yyyy'
        );
      }
    }

    form.find('[name="question"]').each(function (i) {

      var question = $(this);
      var qstn = question.find('[name="qstn"]');
      var qValue = qstn.val();
      var hasAnswer = false;
      var qData = {
        question: '',
        choices: []
      };

      if (qValue !== '') {

        qData.question = qValue;

        if (quizType == '1') {

          question.find('[name="choice"]').each(function (j) {

            var choice = $(this);
            var chc = choice.find('[name="chc"]');
            var cValue = chc.val();
            var correct = choice.find('[name="set_answer"]').is(':checked');
            var cData = {
              value: '',
              correct: false
            };

            if (cValue !== '') {

              cData.value = cValue;
              cData.correct = correct;

              hasAnswer = correct ? true : hasAnswer;

              qData.choices[j] = cData;
            }
          });

          if (hasAnswer) {

            questions[i] = qData;
          }
        } else {

          var choice = question.find('[name="choice"]');
          var chc = choice.find('[name="chc"]');
          var cValue = chc.val();
          var cData = {
            value: '',
            correct: false
          };

          if (cValue !== '') {

            cData.value = cValue;
            cData.correct = true;
            qData.choices[0] = cData;

            questions[i] = qData;
          }
        }
      }
    });

    $('#tags [name="mmbr"] input:checkbox:checked').each(function () {

      var id = $(this).parents('[name="mmbr"]').attr('value');

      students.push(id);
    });

    if (submitOk) {

      $('#loading_modal').modal('show');

      createQuiz(
        myId,
        classroomId,
        title.val(),
        description.val(),
        type.val(),
        duration.val(),
        JSON.stringify(questions),
        publish.is(':checked'),
        dueDate.val(),
        dueTime.val(),
        quizAll,
        JSON.stringify(students)
      );
    }
  });
});

$(document).on('change', '#tags [name="mmbr"] input:checkbox', function () {

  var rootDOM = $('#tags');
  var all = rootDOM.find('[name="mmbr"]').length;
  var checked = rootDOM.find('[name="mmbr"] input:checkbox:checked').length;

  if (all === checked) {

    quizAll = true;
    $('#tags [name="name"]').text('All Students');
  } else if (checked === 0) {

    quizAll = false;
    $('#tags [name="name"]').text('Some Students');
  } else {

    quizAll = false;
    $('#tags [name="name"]').text('Some Students');
  }
});

$(document).on('click', '[name="hide"]', function () {

  var rootDOM = $(this).parents('[name="question"]');
  var panel = rootDOM.find('label').nextAll();
  var thisButton = $(this);

  if (thisButton.children('span').hasClass('fa-minus')) {

    panel.slideUp(200);
  } else {

    panel.slideDown(200);
  }

  thisButton.children('span').toggleClass('fa-minus');
  thisButton.children('span').toggleClass('fa-plus');
});

$(document).on('click', '[name="question"] [name="qstn_remove"]', function () {

  var rootDOM = $(this).parents('[name="question"]');

  removeQstn(rootDOM);
});

$(document).on('click', '[name="add_choice"]', function () {

  var rootDOM = $(this).parents('[name="question"]');

  addChc(rootDOM);
});

$(document).on('click', '[name="choice"] [name="chc_remove"]', function () {

  var rootDOM = $(this).parents('[name="choice"]');

  removeChc(rootDOM);
});

$(document).on('change keyup', '[name="qstn"], [name="chc"], [name="set_answer"]', function () {

  if (qstnHasContent()) {

    showIfEver($('#add_form [name="publish_fg"]'));
  } else {

    hideIfEver($('#add_form [name="publish_fg"]'));
    hideIfEver($('#add_form [name="due_date_fg"]'));

    $('#add_form [name="publish_now"]').prop('checked', false);
  }
});