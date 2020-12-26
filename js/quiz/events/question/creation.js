
$(document).ready(function () {

  $('#add_question_button').click(function () {

    addQstn('#add_question_question_panel');
  });

  $('#add_question_question_button_panel button').click(function () {

    var count = $('#add_question_question_button_panel select');

    for (var i = 0; i < count.val(); i++) {

      addQstn('#add_question_question_panel');
    }

    count.val('1');
  });

  $('#add_question_form').submit(function (e) {

    e.preventDefault();

    var form = $(this);
    var questions = [];

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

    addQuestions(
      myId,
      classroomId,
      quizId,
      JSON.stringify(questions)
    );
  });
});