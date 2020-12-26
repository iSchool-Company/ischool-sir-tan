
function showCountdown() {

  countdownDisplayer = setInterval(function () {

    countdownCount--;

    if (countdownCount === 0) {

      clearInterval(countdownDisplayer);

      $('#submit_button').show();
      $('#exam_panel').show();
      $('#countdown_panel').hide();

      showQuestion();
      tickTimer();
    } else {

      $('#countdown_h2').text(countdownCount);
    }

  }, 1000);
}

function showExam(info) {

  title = info.title;
  type = info.type;
  timerCount = info.duration;
  questions = info.questions;
  overall = questions.length;

  $('#title').text(title);
  $('#exam_type').text(type);

  if (type === 'Multiple Choice') {

    $('#mc_chc').show();
  } else if (type === 'True/False') {

    $('#tf_chc').show();
  } else if (type === 'Identification') {

    $('#i_chc').show();
  }

  $('#overall').text(overall);

  showCountdown();
}

function tickTimer() {

  timeDisplayer = setInterval(function () {

    var time = $('#time');
    var minutes = Math.floor(timerCount / 60);
    var seconds = timerCount - (minutes * 60);

    if (minutes < 10) {
      minutes = '0'.concat(minutes);
    }

    if (seconds < 10) {
      seconds = '0'.concat(seconds);
    }

    $('#time').text(minutes + ':' + seconds);

    if (timerCount > 11) {

      timerCount--;
    } else if (timerCount > 0) {

      $('#time').fadeOut(500).fadeIn(500);

      timerCount--;
    } else {

      endQuiz();
    }

    if (timerCount % 60 === 0) {

      updateDone(
        myId,
        quizId
      );
    }
  }, 1000);
}

function showQuestion() {

  var question = questions[currentQstn - 1];
  var choices = question.answer;
  var length = choices.length;

  $('#qstn_num').text(currentQstn);
  $('#qstn_value').text(question.value);
  $('#current_item').text(currentQstn);
  $('#progress > div').css({
    'width': ((currentQstn / overall) * 100) + '%'
  });

  if (type === 'Multiple Choice') {

    $('#mc_chc').empty();

    for (var i = 0; i < length; i++) {

      $('#mc_chc').append(mcChcNode(choices[i].value));
    }
  } else if (type === 'True/False') {

    $('#tf_chc').find('[name="chc"]').prop('checked', false);
  } else if (type === 'Identification') {

    $('#i_chc').find('[name="chc"]').val('');
  }

  currentQstn++;
}

function showResultModal() {

  $('#result_quiz_text').text(title);
  $('#result_score_text').text(score + '/' + overall);

  if (((score / overall) * 100) >= 50) {

    $('#result_remarks_text').text('Passed');
  } else {

    $('#result_remarks_text').text('Failed');
  }

  $('#result_modal').modal('show');
}