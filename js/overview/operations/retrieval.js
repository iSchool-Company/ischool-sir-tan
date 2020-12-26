
function retrieveClassroomDetails(
  usrId,
  crId
) {

  $.ajax({
    url: 'database/overview/retrieve/details.php',
    data: {
      user_id: usrId,
      classroom_id: crId
    },
    success: function (data, status) {

      showClassroomDetails(data);
    }
  });
}