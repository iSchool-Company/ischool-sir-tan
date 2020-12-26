
$(document).ready(function () {

  retrieveStudents(
    myId,
    classroomId,
    search
  );

  studentRetriever = setInterval(function () {

    retrieveStudents(
      myId,
      classroomId,
      search
    );
  }, 2000);
});
