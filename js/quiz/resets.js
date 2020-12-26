
function resetAddModal() {

  var addForm = $('#add_form');

  addForm.find('.form-control').val('');
  addForm.find('select').find('option:eq(0)').prop('selected', true);
  addForm.find('[name="due_time"]').find('option:eq(1)').prop('selected', true);
  addForm.find('[name="type"]').attr('disabled', false);
  addForm.find('[name="question_now"]').prop('checked', false);
  addForm.find('[name="publish_now"]').prop('checked', false);
  addForm.find('[name="publish_fg"]').hide();
  addForm.find('[name="due_date_fg"]').hide();
  addForm.find('#add_question_panel').empty();
  addForm.find('#add_question_button_panel').hide();
  addForm.find('[name="check_all"]').prop('checked', true);

  if (addForm.find('[name="members"]').css('display') != 'none') {

    addForm.find('[name="hide"]').click();
  }

  clearResult(addForm.find('[name="title"]'));
  clearResult(addForm.find('[name="description"]'));
  clearResult(addForm.find('[name="due_date"]'), '<b>Format:</b> mm/dd/yyyy');
  clearResult(addForm.find('[name="due_time"]'));

  quizType = '1';
  quizAll = true;
}

function resetPublishModal() {

  $('#publish_form [name="due_date"]').val('');
  $('#publish_form [name="due_time"]').find('option:eq(1)').prop('selected', true);

  clearResult($('#publish_form [name="due_date"]'), '<b>Format:</b> mm/dd/yyyy');
  clearResult($('#publish_form [name="due_time"]'));
}

function resetEditModal() {

  $('#edit_form [name="title"]').val('');
  $('#edit_form [name="description"]').val('');
  $('#edit_form [name="type"]').find('option:eq(0)').prop('selected', true);
  $('#edit_form [name="duration"]').find('option:eq(0)').prop('selected', true);
}

function resetContent() {

  var contentPanel = $('#quiz_content_panel');
  var defaultValue = '---';

  contentPanel.attr('value', '0');
  contentPanel.find('[name="title"]').text(defaultValue);
  contentPanel.find('[name="description"]').text(defaultValue);
  contentPanel.find('[name="duration"]').text(defaultValue);
  contentPanel.find('[name="question_count"]').text(defaultValue);
  contentPanel.find('[name="date_time_created"]').text(defaultValue);
  contentPanel.find('[name="date_time_published"]').text(defaultValue);
  contentPanel.find('[name="due_date"]').text(defaultValue);
  contentPanel.find('[name="time_remaining"]').text('');
  contentPanel.find('[name="status"]').text(defaultValue);
  contentPanel.find('[name="status_color"]').css('color', 'gray');
  contentPanel.find('[name="type"]').text(defaultValue);
  contentPanel.find('#manage_question_panel').empty();
  contentPanel.find('#take_now_button').hide();
  contentPanel.find('#empty_manage_question_panel').show();
}

function resetAddQuestionModal() {

  $('#add_question_question_panel').empty();
}

function resetEditQuestionModal() {

  $('#edit_question_panel').empty();
}

function resetResultModal(reset) {

  if (reset) {

    clearInterval(resultRetriever);
    clearInterval(resultFiller);

    $('#quiz_result_panel').empty();
    $('#quiz_result_sort_by').val('Date Taken');
  } else {

    resultRetriever = setInterval(function () {

      retrieveResultIds(
        sortBy,
        quizId
      );
    }, 1000);

    resultFiller = setInterval(function () {

      traverseResultIds();
    }, 1000);
  }
}

function showTaker() {

  $.ajax({
    url: 'database/student/retrieve/display.php',
    data: {
      user_id: 0,
      classroom_id: classroomId,
      search: ''
    },
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'found') {

        var students = responseJSON.students;
        var length = students.length;

        $('#tags [name="members"]').empty();

        for (var i = 0; i < length; i++) {

          var memberNodeTemp = memberNode(
            students[i].id,
            students[i].name,
            students[i].profile_picture
          );

          $('#tags [name="members"]').append(memberNodeTemp);
        }
      }
    }
  });
}

function resetRetakeModal() {

  $('#retake_form [name="due_date"]').val('');
  $('#retake_form [name="due_time"]').find('option:eq(1)').prop('selected', true);

  clearResult($('#retake_form [name="due_date"]'), '<b>Format:</b> mm/dd/yyyy');
  clearResult($('#retake_form [name="due_time"]'));
}

$(document).ready(function () {

  $('#add_modal').on({

    'hidden.bs.modal': function () {

      resetAddModal();
    },

    'shown.bs.modal': function () {

      showTaker();
    }
  });

  $('#publish_modal').on('hidden.bs.modal', function () {

    resetPublishModal();
  });

  $('#edit_modal').on('hidden.bs.modal', function () {

    resetEditModal();
  });

  $('#add_question_modal').on('hidden.bs.modal', function () {

    resetAddQuestionModal();
  });

  $('#edit_question_modal').on('hidden.bs.modal', function () {

    resetEditQuestionModal();
  });

  $('#result_modal').on({

    'shown.bs.modal': function () {

      resetResultModal(false);
    },
    'hidden.bs.modal': function () {

      resetResultModal(true);
    }
  });

  $('#retake_modal').on('hidden.bs.modal', function () {

    resetRetakeModal();
  });
});