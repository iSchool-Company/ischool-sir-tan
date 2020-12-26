
function checkAnswer() {

  var answer = '';

  if (type === 'Multiple Choice') {
    answer = $('#mc_chc [name="chc"]:checked').val();
  } else if (type === 'True/False') {
    answer = $('#tf_chc [name="chc"]:checked').val();
  } else if (type === 'Identification') {
    answer = $('#i_chc [name="chc"]').val();
  }

  var choices = questions[currentQstn - 2].answer;
  var length = choices.length;

  for (var i = 0; i < length; i++) {

    if (choices[i].correct == 1 && answer == choices[i].value) {

      score++;

      updateScore(
        myId,
        quizId,
        score
      );

      break;
    }
  }
}

function endQuiz() {

  clearInterval(timeDisplayer);

  $('#progress > div').css({
    'width': '0%'
  });

  if (type === 'Multiple Choice') {

    $('#mc_chc').empty();
    $('#mc_chc').hide();
  } else if (type === 'True/False') {

    $('#tf_chc').hide();
  } else if (type === 'Identification') {

    $('#i_chc').hide();
  }

  $('#qstn_num').parent().html('<br>');

  setTimeout(showResultModal, 1000);
}

$(document).ready(function () {

  if (quizId === 0) {

    alert('Modal for intruder here...');

    window.location = 'classrooms_quizzes.php';
  } else {

    retrieveExam(
      classroomId,
      myId,
      quizId
    );
  }

  $('#next_button').click(function () {

    checkAnswer();

    if (currentQstn <= overall) {

      showQuestion();
    } else {

      endQuiz();
    }
  });

  $('#submit_modal [name="confirm_button"]').click(function () {

    $('#submit_modal').modal('hide');

    endQuiz();
  });

  $('#result_modal').on('hidden.bs.modal', function () {

    window.location = 'classrooms_quizzes.php';
  });

  $('#result_modal [name="confirm_button"]').click(function () {

    window.location = 'classrooms_quizzes.php';
  });
});