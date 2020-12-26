
$(document).ready(function () {

  retrieveIds(
    myType,
    classroomId,
    myId
  );

  assignmentRetriever = setInterval(function () {

    retrieveIds(
      myType,
      classroomId,
      myId
    );
  }, 1000);

  assignmentFiller = setInterval(function () {

    traverseIds('assmt');
  }, 1000);

  if (myType === 'Student') {

    $('#empty_assignment_panel > p').html(
      'Wait for your teacher to post an assignment. <span class="fa fa-user"></span>'
    );
  }

  if (notifId !== 0) {

    showNotifIfEver();
  }
});

function showNotifIfEver() {

  setTimeout(function () {

    $('#assmt' + notifId).hide();
    $('#assmt' + notifId).fadeToggle(500);
    $('#assmt' + notifId).css({
      backgroundColor: '#dfe3ee'
    })
  }, 2000);
}