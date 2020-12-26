
function showStudents(students) {

  var length = students.length;

  existingStudents = '';

  for (var i = 0; i < length; i++) {

    var studentNodeTemp = studentNode(
      students[i].id,
      students[i].profile_picture,
      students[i].name,
      students[i].username
    );

    if (crStatus === 'archived') {
      studentNodeTemp.find('[name="delete_button"]').remove();
    }

    if (i === 0) {

      if ($('#std' + students[i].id).length > 0) {

        if (
          $('#std' + students[i].id).attr('id').substr(3)
          ==
          $('[id^="std"]').eq(0).attr('id').substr(3)
        ) {

          updateStudentNode(students[i]);
        } else {

          $('#std' + students[i].id).remove();
          $('#student_panel').prepend(studentNodeTemp);
          $('#std' + students[i].id).hide();
          $('#std' + students[i].id).fadeIn(searching ? 0 : 1000);
          $('#std' + students[i].id).find('[data-toggle="tooltip"]').tooltip();
        }
      } else {

        $('#student_panel').prepend(studentNodeTemp);
        $('#std' + students[i].id).hide();
        $('#std' + students[i].id).fadeIn(searching ? 0 : 1000);
        $('#std' + students[i].id).find('[data-toggle="tooltip"]').tooltip();
      }
    } else {

      if ($('#std' + students[i].id).length > 0) {

        if (
          $('#std' + students[i].id).prev().attr('id').substr(3)
          ==
          students[i - 1].id
        ) {

          updateStudentNode(students[i]);
        } else {

          $('#std' + students[i].id).remove();
          $('#std' + students[i - 1].id).after(studentNodeTemp);
          $('#std' + students[i].id).hide();
          $('#std' + students[i].id).fadeIn(searching ? 0 : 1000);
          $('#std' + students[i].id).find('[data-toggle="tooltip"]').tooltip();
        }
      } else {

        $('#std' + students[i - 1].id).after(studentNodeTemp);
        $('#std' + students[i].id).hide();
        $('#std' + students[i].id).fadeIn(searching ? 0 : 1000);
        $('#std' + students[i].id).find('[data-toggle="tooltip"]').tooltip();
      }
    }

    existingStudents += '#std' + students[i].id + (i < length - 1 ? ', ' : '');
  }

  $('[id^="std"]').not(existingStudents).remove();

  retrieveNewStudentNotif();
}

function updateStudentNode(objectTemp) {

  var rootDOM = $('#students' + objectTemp.id);
  var name = rootDOM.find('[name="name"]').text().trim();
  var username = rootDOM.find('[name="username"]').text().trim();

  if (name !== objectTemp.name) {

    rootDOM.find('[name="name"]').text(objectTemp.name);
  }

  if (username !== '@' + objectTemp.username) {

    rootDOM.find('[name="username"]').text('@' + objectTemp.username);
  }
}

function showSearch(
  crId,
  srch
) {

  $.ajax({
    url: 'database/student/search.php',
    data: {
      classroom_id: crId,
      search: srch
    },
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'found') {

        var students = responseJSON.students;
        var length = students.length;

        for (var i = 0; i < length; i++) {

          var searchNodeTemp = searchNode(
            students[i].id,
            students[i].image,
            students[i].name,
            students[i].username
          );

          $('#search_panel').append(searchNodeTemp);

          $('#search' + students[i].id).hide();
          $('#search' + students[i].id).fadeToggle(100);
        }

        $('#empty_search_panel').hide();

      } else {

        $('#empty_search_panel').html('No matches your search!');
        $('#empty_search_panel').show();
      }
    }
  });
}