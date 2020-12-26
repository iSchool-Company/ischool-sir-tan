
function createQuiz(
  usrId,
  crId,
  title,
  description,
  type,
  duration,
  questions,
  publish,
  dueDate,
  dueTime,
  qzAll,
  students
) {

  var formData = new FormData();

  formData.append('user_id', usrId);
  formData.append('classroom_id', crId);
  formData.append('title', title);
  formData.append('description', description);
  formData.append('type', type);
  formData.append('duration', duration);
  formData.append('questions', questions);
  formData.append('publish_now', publish);
  formData.append('due_date', phpDate(dueDate));
  formData.append('due_time', dueTime);
  formData.append('quiz_all', qzAll);
  formData.append('students', students);

  $.ajax({
    method: 'post',
    url: 'database/quiz/create.php',
    data: formData,
    processData: false,
    contentType: false,
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'successful') {

        setTimeout(function () {

          $('#prompt_modal [name="message"]').html('<b class="text-success">Successful!</b> Quiz added!');
          $('#add_modal').modal('hide');
          $('#loading_modal').modal('hide');
          $('#prompt_modal').modal('show');
        }, 500);
      }
    }
  });
}

function publishQuiz(
  usrId,
  crId,
  qzId,
  publish,
  dueDate,
  dueTime
) {

  var formData = new FormData();

  formData.append('user_id', usrId);
  formData.append('classroom_id', crId);
  formData.append('quiz_id', qzId);
  formData.append('publish_now', publish);
  formData.append('due_date', phpDate(dueDate));
  formData.append('due_time', dueTime);

  $.ajax({
    method: 'post',
    url: 'database/quiz/publish.php',
    data: formData,
    processData: false,
    contentType: false,
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'successful') {

        setTimeout(function () {

          $('#prompt_modal [name="message"]').html(
            '<b class="text-success">Successful!</b> Quiz ' + (publish ? 'published' : 'unpublished') + '!'
          );
          $('#publish_modal').modal('hide');
          $('#loading_modal').modal('hide');
          $('#prompt_modal').modal('show');
        }, 500);
      }
    }
  });
}

function updateQuiz(
  usrId,
  crId,
  qzId,
  title,
  description,
  type,
  duration,
  changed
) {

  var formData = new FormData();

  formData.append('user_id', usrId);
  formData.append('classroom_id', crId);
  formData.append('quiz_id', qzId);
  formData.append('title', title);
  formData.append('description', description);
  formData.append('type', type);
  formData.append('duration', duration);
  formData.append('changed', changed);

  $.ajax({
    method: 'post',
    url: 'database/quiz/update.php',
    data: formData,
    processData: false,
    contentType: false,
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'successful') {

        setTimeout(function () {

          $('#prompt_modal [name="message"]').html('<b class="text-success">Successful!</b> Quiz modified!');
          $('#edit_modal').modal('hide');
          $('#loading_modal').modal('hide');
          $('#prompt_modal').modal('show');
        }, 500);
      }
    }
  });
}

function deleteQuiz(
  usrId,
  crId,
  qzId
) {

  var formData = new FormData();

  formData.append('user_id', usrId);
  formData.append('classroom_id', crId);
  formData.append('quiz_id', qzId);

  $.ajax({
    method: 'post',
    url: 'database/quiz/delete.php',
    data: formData,
    processData: false,
    contentType: false,
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'successful') {

        setTimeout(function () {

          $('#prompt_modal [name="message"]').html('<b class="text-success">Successful!</b> Quiz deleted!');
          $('#delete_modal').modal('hide');
          $('#loading_modal').modal('hide');
          $('#prompt_modal').modal('show');
        }, 500);
      }
    }
  });
}

function pinQuiz(
  usrId,
  crId,
  pinId,
  qzId,
  crName
) {

  var formData = new FormData();

  formData.append('user_id', usrId);
  formData.append('classroom_id', crId);
  formData.append('pin_id', pinId);
  formData.append('quiz_id', qzId);

  $.ajax({
    method: 'post',
    url: 'database/quiz/pin.php',
    data: formData,
    processData: false,
    contentType: false,
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'successful') {

        setTimeout(function () {

          $('#prompt_modal [name="message"]').html('<b class="text-success">Successful!</b> Pinned to ' + crName + '!');
          $('#pin_modal').modal('hide');
          $('#loading_modal').modal('hide');
          $('#prompt_modal').modal('show');
        }, 500);
      }
    }
  });
}

function addQuestions(
  usrId,
  crId,
  qzId,
  questions
) {

  var formData = new FormData();

  formData.append('user_id', usrId);
  formData.append('classroom_id', crId);
  formData.append('quiz_id', qzId);
  formData.append('questions', questions);

  $.ajax({
    method: 'post',
    url: 'database/quiz/question/add.php',
    data: formData,
    processData: false,
    contentType: false,
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'successful') {
        hideModal('add_question');
      }
    }
  });
}

function updateQuestion(
  usrId,
  crId,
  qstnId,
  question
) {

  var formData = new FormData();

  formData.append('user_id', usrId);
  formData.append('classroom_id', crId);
  formData.append('question_id', qstnId);
  formData.append('question', question);

  $.ajax({
    method: 'post',
    url: 'database/quiz/question/update.php',
    data: formData,
    processData: false,
    contentType: false,
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'successful') {
        hideModal('edit_question');
      }
    }
  });
}

function deleteQuestion(
  usrId,
  crId,
  qstnId
) {

  var formData = new FormData();

  formData.append('user_id', usrId);
  formData.append('classroom_id', crId);
  formData.append('question_id', qstnId);

  $.ajax({
    method: 'post',
    url: 'database/quiz/question/delete.php',
    data: formData,
    processData: false,
    contentType: false,
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'successful') {
        hideModal('delete_question');
      }
    }
  });
}

function takeExam(qzId) {

  $.ajax({
    method: 'post',
    url: 'database/quiz/session.php',
    data: {
      quiz_id: qzId
    },
    success: function () {

      window.location = 'classrooms_quizzes_take.php';
    }
  });
}

function retakeQuiz(
  usrId,
  crId,
  qzsbId,
  dueDate,
  dueTime
) {

  $.ajax({
    method: 'post',
    url: 'database/quiz/retake.php',
    data: {
      user_id: usrId,
      classroom_id: crId,
      submission_id: qzsbId,
      due_date: phpDate(dueDate),
      due_time: dueTime
    },
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'successful') {

        setTimeout(function () {

          $('#retake_modal').modal('hide');
          $('#loading_modal').modal('hide');
        }, 500);
      }
    }
  });
}