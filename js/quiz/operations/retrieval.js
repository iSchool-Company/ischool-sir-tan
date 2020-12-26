
function retrieveQuizIds(
  type,
  crId,
  usrId
) {

  $.ajax({
    url: 'database/quiz/retrieve/ids.php',
    data: {
      type: type,
      classroom_id: crId,
      user_id: usrId
    },
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'found') {

        var ids = responseJSON.ids;

        fillIds(
          quizNode,
          'qz',
          'quiz',
          ids
        );
      } else {
        resetPanel('quiz');
      }
    }
  });
}

function retrieveQuizDisplay(
  type,
  qzId,
  usrId,
  version,
  rootDOM
) {

  $.ajax({
    url: 'database/quiz/retrieve/display.php',
    data: {
      type: type,
      quiz_id: qzId,
      user_id: usrId,
      version: version
    },
    success: function (data) {

      showQuizDisplay(
        data,
        rootDOM
      );
    }
  });
}

function retrieveQuizEditable(qzId) {

  $.ajax({
    url: 'database/quiz/retrieve/editable.php',
    data: { quiz_id: qzId },
    success: function (data) {

      showQuizEditable(data);
    }
  });
}

function retrieveQuizContent(
  type,
  qzId,
  usrId,
  version,
  rootDOM,
  cType
) {

  $.ajax({
    url: 'database/quiz/retrieve/content.php',
    data: {
      type: type,
      quiz_id: qzId,
      user_id: usrId,
      version: version
    },
    success: function (data, status) {

      showQuizContent(
        data,
        rootDOM,
        cType
      );
    }
  });

  if (myType === 'Teacher') {

    $.ajax({
      url: 'database/quiz/question/retrieve/display.php',
      data: {
        quiz_type: cType.text(),
        quiz_id: qzId
      },
      success: function (data) {

        var responseJSON = JSON.parse(data);
        var response = responseJSON.response;

        if (response === 'found') {

          var questions = responseJSON.questions;

          $('#empty_manage_question_panel').hide();

          showQuestions(questions);
        } else {
          resetPanel('manage_question');
        }
      }
    });
  }
}

function retrieveQuestionEditable(qstnId) {

  var editPanel = $('#edit_question_panel');

  addQstn('#edit_question_panel');

  editPanel.find('[name="hide"], [name="qstn_remove"], hr').remove();

  if (quizType === '1') {
    editPanel.find('[name="choice"]').remove();
  } else {
    editPanel.find('[name="add_choice_button"]').remove();
  }

  $.ajax({
    url: 'database/quiz/question/retrieve/editable.php',
    data: { question_id: qstnId },
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'found') {

        var info = responseJSON.info;
        var question = info.value;
        var answers = info.answers;
        var length = answers.length;

        editPanel.find('[name="qstn"]').val(question);

        if (quizType === '1') {

          for (var i = 0; i < length; i++) {
            editPanel.find('[name="add_choices_panel"] > div').append(mcChoiceNode(i + 1, answers[i].id));
            editPanel.find('[name="add_choices_panel"] > div').find('[name="chc"]').last().val(answers[i].value);

            if (answers[i].correct == 1) {
              editPanel.find('[name="add_choices_panel"] > div').find('[name="set_answer"]').last().prop('checked', true);
            }
          }
        } else {
          editPanel.find('[name="chc"]').val(answers[0].value);
        }
      }
    }
  });
}

function retrieveClassrooms(
  usrId,
  crId
) {

  $.ajax({
    url: 'database/classroom/retrieve/names.php',
    data: {
      user_id: usrId,
      classroom_id: crId
    },
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'found') {

        var classrooms = responseJSON.classrooms;

        showClassrooms(classrooms);

        $('#pin_modal [name="confirm_button"]').attr('disabled', false);
      } else {

        $('#pin_form [name="classrooms"]').append('<option>No Other Classroom Yet</option>');
        $('#pin_modal [name="confirm_button"]').attr('disabled', true);
      }
    }
  });
}

function retrieveResultIds(
  sort,
  qzId
) {

  $.ajax({
    url: 'database/quiz/result/retrieve/ids.php',
    data: {
      sort_by: sort,
      quiz_id: qzId
    },
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'found') {

        var results = responseJSON.results;

        fillIds2(
          resultNode,
          'resqz',
          'quiz_result',
          results
        );
      } else {

        resetPanel('quiz_result');
      }
    }
  });
}

function retrieveResultDisplay(
  rootDOM,
  i
) {

  var id = rootDOM.attr('id').substr(5);

  $.ajax({
    url: 'database/quiz/result/retrieve/display.php',
    data: { submission_id: id },
    success: function (data, status) {

      showResultDisplay(
        data,
        rootDOM,
        i
      );
    }
  });
}