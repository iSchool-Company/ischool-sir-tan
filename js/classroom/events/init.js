
$(document).ready(function () {

  retrieveClassrooms(
    myType,
    myId
  );

  classroomRetriever = setInterval(function () {

    retrieveClassrooms(
      myType,
      myId
    );
  }, 1000);
});