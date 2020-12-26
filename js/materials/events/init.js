
$(document).ready(function () {

  retrieveIds(
    myId,
    classroomId
  );

  materialsRetriever = setInterval(function () {
    retrieveIds(
      myId,
      classroomId
    );
  }, 1000);

  materialsFiller = setInterval(function () {
    traverseIds('mtrl');
  }, 1000);

  if (myType === 'Student') {

    $('#empty_materials_panel > p').html(
      'Wait for your teacher to post a materials. <span class="fa fa-user"></span>'
    );
  }
});