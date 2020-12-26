
var details = {};

$(document).ready(function () {

  retrieveClassroomDetails(
    myId,
    classroomId
  );

  setInterval(function () {

    retrieveClassroomDetails(
      myId,
      classroomId
    );
  }, 3000);
});