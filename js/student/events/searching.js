
$(document).ready(function () {

  $('#find_form [name="search"]').on({

    'keyup': function () {

      var value = $(this).val();

      if (value !== search) {

        search = value;
      }

      retrieveStudents(
        myId,
        classroomId,
        search
      );
    },

    'focus': function () {

      clearInterval(studentRetriever);
      searching = true;
    },

    'blur': function () {

      studentRetriever = setInterval(function () {

        retrieveStudents(
          myId,
          classroomId,
          search
        );
      }, 2000);

      searching = false;
    }
  });
});