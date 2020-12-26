
$(document).ready(function () {

  $('#edit_question_form').submit(function (e) {

    e.preventDefault();

    var data = {};
    var question = $(this).find('[name="question"]');
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
          data = qData;
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

          data = qData;
        }
      }
    }

    updateQuestion(
      myId,
      classroomId,
      questionId,
      JSON.stringify(data)
    );
  });
});

$(document).on('click', '[id^="qstn"] [name="q_edit_button"]', function () {

  var rootDOM = $(this).parents('[id^="qstn"]');
  var id = rootDOM.attr('id').substr(4);

  questionId = id;

  retrieveQuestionEditable(questionId);
});