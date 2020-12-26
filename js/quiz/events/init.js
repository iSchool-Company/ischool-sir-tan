
$(document).ready(function () {

  retrieveQuizIds(
    myType,
    classroomId,
    myId
  );

  quizRetriever = setInterval(function () {

    retrieveQuizIds(
      myType,
      classroomId,
      myId
    );
  }, 1000);

  quizFiller = setInterval(function () {

    traverseIds('qz');
  }, 1000);

  if (myType === 'Student') {

    $('#empty_quiz_panel > p').html(
      'Wait for your teacher to post a quiz. <span class="fa fa-user"></span>'
    );
  }
});