
function retrieveExam(
  crId,
  usrId,
  qzId
) {

  $.ajax({
    method: 'post',
    url: 'database/exam/retrieve/content.php',
    data: {
      classroom_id: crId,
      user_id: usrId,
      quiz_id: qzId
    },
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'found') {

        var info = responseJSON.info;

        showExam(info);
      }
    }
  });
}

function updateScore(
  usrId,
  qzId,
  score
) {

  $.ajax({
    method: 'post',
    url: 'database/exam/update_score.php',
    data: {
      user_id: usrId,
      quiz_id: qzId,
      score: score
    }
  });
}

function updateDone(
  usrId,
  qzId
) {

  $.ajax({
    method: 'post',
    url: 'database/exam/update_done.php',
    data: {
      user_id: usrId,
      quiz_id: qzId
    }
  });
}