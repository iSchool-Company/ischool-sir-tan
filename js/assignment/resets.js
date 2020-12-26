
function resetAddModal() {

  var addForm = $('#add_form');
  var title = addForm.find('[name="title"]');
  var description = addForm.find('[name="description"]');
  var file = addForm.find('[name="file"]');
  var fileR = addForm.find('[name="file_r"]');
  var fileMsg = addForm.find('[name="file_msg"]');
  var fileName = addForm.find('[name="file_name"]');
  var publish = addForm.find('[name="publish"]');
  var dueDateFG = addForm.find('[name="due_date_fg"]');
  var dueDate = addForm.find('[name="due_date"]');
  var dueTime = addForm.find('[name="due_time"]');

  title.val('');
  description.val('');
  publish.prop('checked', false);
  file.text('Choose File');
  fileR.val('');
  fileMsg.text('No file chosen');
  fileName.text('');
  dueDate.val('');
  dueTime.find('option:eq(1)').prop('selected', true);
  hideIfEver(dueDateFG);

  clearResult(title);
  clearResult(description);
  clearResult(dueDate, '<b>Format:</b> mm/dd/yyyy');
}

function resetPublishModal() {

  var publishForm = $('#publish_form');
  var publishMessage = $('#publish_message');
  var dueDate = publishForm.find('[name="due_date"]');
  var dueTime = publishForm.find('[name="due_time"]');

  dueDate.val('');
  dueTime.find('option:eq(1)').prop('selected', true);

  showIfEver(publishForm);
  hideIfEver(publishMessage);

  clearResult(dueDate, '<b>Format:</b> mm/dd/yyyy');
}

function resetEditModal() {

  var editForm = $('#edit_form');
  var title = editForm.find('[name="title"]');
  var description = editForm.find('[name="description"]');
  var file = editForm.find('[name="file"]');
  var fileR = editForm.find('[name="file_r"]');
  var fileMsg = editForm.find('[name="file_msg"]');
  var fileName = editForm.find('[name="file_name"]');

  title.val('');
  description.val('');
  file.text('Choose File');
  fileR.val('');
  fileMsg.text('No file chosen');
  fileName.text('');

  clearResult(title);
  clearResult(description);
}

function resetSubmissionModal(reset) {

  if (reset) {

    $('#assignment_result_panel').empty();
    $('#assignment_result_sort_by').val('Date Submitted');

    clearInterval(resultRetriever);
    clearInterval(resultFiller);
  } else {

    resultRetriever = setInterval(function () {
      retrieveResultIds(
        sortBy,
        assignmentId
      );
    }, 1000);

    resultFiller = setInterval(function () {
      traverseResultIds('resassmt');
    }, 1000);
  }
}

function resetSubmitModal() {

  var submitForm = $('#submit_form');

  submitForm.find('[name="file"]').text('Choose File');
  submitForm.find('[name="file_msg"]').text('No file chosen');
  submitForm.find('[name="file_name"]').text('');
  submitForm.find('[name="file_r"]').val('');

  clearResult(submitForm.find('[name="file_r"]'));
}

function resetRateModal() {

  var rateForm = $('#rate_form');
  var studentName = rateForm.find('[name="student_name"]');
  var grade = rateForm.find('[name="grade"]');

  studentName.text('');
  clearResult(grade, 'Grade must be in percent(50-100)');
}

function resetResubmitModal() {

  var resubmitForm = $('#resubmit_form');
  var dueDate = resubmitForm.find('[name="due_date"]');
  var dueTime = resubmitForm.find('[name="due_time"]');

  dueDate.val('');
  dueTime.find('option:eq(1)').prop('selected', true);

  clearResult(dueDate, '<b>Format:</b> mm/dd/yyyy');
}

function resetContent() {

  var contentPanel = $('#assignment_content_panel');
  var defaultValue = '---';

  contentPanel.attr('value', '0');
  contentPanel.find('[name="title"]').text(defaultValue);
  contentPanel.find('[name="description"]').text(defaultValue);
  contentPanel.find('[name="date_time_created"]').text(defaultValue);
  contentPanel.find('[name="date_time_published"]').text(defaultValue);
  contentPanel.find('[name="due_date"]').text(defaultValue);
  contentPanel.find('[name="time_remaining"]').text('');
  contentPanel.find('[name="status"]').text(defaultValue);
  contentPanel.find('[name="file"]').text(defaultValue);
  contentPanel.find('[name="status_color"]').css('color', 'gray');
  contentPanel.find('#submit_button').hide();
}

$(document).ready(function () {

  $('#add_modal').on('hidden.bs.modal', function () {

    resetAddModal();
  });

  $('#publish_modal').on('hidden.bs.modal', function () {

    resetPublishModal();
  });

  $('#edit_modal').on('hidden.bs.modal', function () {

    resetEditModal();
  });

  $('#submissions_modal').on({

    'shown.bs.modal': function () {

      resetSubmissionModal(false);
    },

    'hidden.bs.modal': function () {

      resetSubmissionModal(true);
    }
  });

  $('#submit_modal').on('hidden.bs.modal', function () {

    resetSubmitModal();
  });

  $('#rate_modal').on('hidden.bs.modal', function () {

    resetRateModal();
  });

  $('#resubmit_modal').on('hidden.bs.modal', function () {

    resetResubmitModal();
  });
});