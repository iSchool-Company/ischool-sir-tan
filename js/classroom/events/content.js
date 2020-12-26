
$(document).on('click', '[name="classroom_name"]', function () {

  var rootDOM = $(this).parents('[id^="cr"]');
  var status = rootDOM.find('[name="status"]').text().trim();

  classroomId = rootDOM.attr('id').substr(2);

  if (status != 'Pending') {

    sessionClassroom(classroomId);
  } else {

    $('#prompt_modal [name="message"]').html('<b class="text-warning">Oops!</b> Please wait for the approval of the teacher!');
    $('#prompt_modal').modal('show');
  }
});