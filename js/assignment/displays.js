
function resetPanel(panel) {

  var mainPanel = $('#' + panel + '_panel');
  var emptyPanel = $('#empty_' + panel + '_panel');

  if (mainPanel.children().length > 0) {

    mainPanel.empty();
  }

  showIfEver(emptyPanel);
}

function fillIds(
  node,
  nodePrefix,
  panel,
  ids
) {

  var existingIds = '';
  var length = ids.length;
  var prefixLength = nodePrefix.length;
  var emptyPanel = $('#empty_' + panel + '_panel');

  hideIfEver(emptyPanel);

  for (var i = 0; i < length; i++) {

    var nodeTemp = node(ids[i]);

    if (myType === 'Student') {
      nodeTemp.find('[name="fa_info"]').remove();
    }

    if (i === 0) {

      if ($('#' + nodePrefix + ids[i]).length > 0) {

        if (
          $('#' + nodePrefix + ids[i]).attr('id').substr(prefixLength)
          !=
          $('[id^="' + nodePrefix + '"]').last().attr('id').substr(prefixLength)
        ) {

          $('#' + nodePrefix + ids[i]).remove();
          $('#' + panel + '_panel').append(nodeTemp);
          $('#' + nodePrefix + ids[i]).hide();
          $('#' + nodePrefix + ids[i]).fadeIn(500);
        }
      } else {

        $('#' + panel + '_panel').append(nodeTemp);
        $('#' + nodePrefix + ids[i]).hide();
        $('#' + nodePrefix + ids[i]).fadeIn(500);
      }
    } else {

      if ($('#' + nodePrefix + ids[i]).length > 0) {

        if (
          $('#' + nodePrefix + ids[i]).next().attr('id').substr(prefixLength)
          !=
          ids[i - 1]
        ) {

          $('#' + nodePrefix + ids[i]).remove();
          $('#' + nodePrefix + ids[i - 1]).before(nodeTemp);
          $('#' + nodePrefix + ids[i]).hide();
          $('#' + nodePrefix + ids[i]).fadeIn(500);
        }
      } else {

        $('#' + nodePrefix + ids[i - 1]).before(nodeTemp);
        $('#' + nodePrefix + ids[i]).hide();
        $('#' + nodePrefix + ids[i]).fadeIn(500);
      }
    }

    $('#' + nodePrefix + ids[i]).find('[data-toggle="tooltip"]').tooltip();

    existingIds += '#' + nodePrefix + ids[i] + (i < length - 1 ? ', ' : '');
  }

  $('[id^="' + nodePrefix + '"]').not(existingIds).remove();
}

function traverseIds(nodePrefix) {

  $('[id^="' + nodePrefix + '"]').each(function () {

    var rootDOM = $(this);

    if (isPartiallyVisible(rootDOM)) {

      var prefixLength = nodePrefix.length;
      var id = rootDOM.attr('id').substr(prefixLength);
      var version = rootDOM.attr('value');

      retrieveDisplay(
        myType,
        id,
        myId,
        version,
        rootDOM
      );
    }
  });
}

function showDisplay(
  data,
  rootDOM
) {

  var responseJSON = JSON.parse(data);
  var response = responseJSON.response;
  var info = responseJSON.info;

  var timeRemaining = rootDOM.find('[name="time_remaining"]');
  var status = rootDOM.find('[name="status"]');
  var statusColor = rootDOM.find('[name="status_color"]');
  var takerCount = rootDOM.find('[name="taker_count"]');
  var idleCount = rootDOM.find('[name="idle_count"]');

  if (response === 'found') {

    var title = rootDOM.find('[name="title"]');
    var dateTimePublished = rootDOM.find('[name="date_time_published"]');
    var dueDate = rootDOM.find('[name="due_date"]');
    var hasFile = rootDOM.find('[name="has_file"]');

    if (title.text() != info.title) {

      title.text(info.title);
    }

    if (dateTimePublished.text() != info.date_time_published) {

      dateTimePublished.text(info.date_time_published);
    }

    if (dueDate.text() != info.due_date) {

      dueDate.text(info.due_date);
    }

    if (hasFile.text() != info.has_file) {

      hasFile.text(info.has_file);
    }

    if (myType === 'Teacher') {

      var backpackButton = rootDOM.find('[name="backpack_button"]');

      if (info.has_file === 'Yes') {

        showIfEver(backpackButton);
      } else {

        hideIfEver(backpackButton);
      }
    }

    rootDOM.attr('value', info.version);
  }

  if (timeRemaining.text() != info.time_remaining) {

    timeRemaining.text(info.time_remaining);
  }

  if (status.text() != info.status) {

    status.text(info.status);
  }

  if (statusColor.css('color') != info.status_color) {

    statusColor.css('color', info.status_color);
  }

  if (takerCount.text() != info.taker_count) {

    takerCount.text(info.taker_count);
  }

  if (idleCount.text() != info.idle_count) {

    idleCount.text(info.idle_count);
  }

  if (myType === 'Teacher') {

    var dateTimeCreated = rootDOM.find('[name="date_time_created"]');
    var publishButton = rootDOM.find('[name="publish_button"]');
    var editButton = rootDOM.find('[name="edit_button"]');

    if (dateTimeCreated.text() != info.date_time_created) {

      dateTimeCreated.text(info.date_time_created);
    }

    switch (info.status) {

      case 'Closed':

        hideIfEver(publishButton);
        hideIfEver(editButton);
        break;

      case 'Published':

        showIfEver(publishButton);
        hideIfEver(editButton);

        if (publishButton.text().trim() != 'Unpublish') {

          publishButton.html('<span class="fa fa-eye-slash"></span> <span class="text-main-black">Unpublish</span>');
        }
        break;

      case 'Unpublished':

        showIfEver(publishButton);
        showIfEver(editButton);

        if (publishButton.text().trim() != 'Publish') {

          publishButton.html('<span class="fa fa-eye"></span> <span class="text-main-black">Publish</span>');
        }
        break;
    }
  }
}

function showContent(
  data,
  rootDOM
) {

  var responseJSON = JSON.parse(data);
  var response = responseJSON.response;
  var info = responseJSON.info;

  var timeRemaining = rootDOM.find('[name="time_remaining"]');
  var status = rootDOM.find('[name="status"]');
  var statusColor = rootDOM.find('[name="status_color"]');

  if (response === 'found') {

    var title = rootDOM.find('[name="title"]');
    var breadcrumb = $('#ass_name');
    var description = rootDOM.find('[name="description"]');
    var duration = rootDOM.find('[name="duration"]');
    var dateTimePublished = rootDOM.find('[name="date_time_published"]');
    var dueDate = rootDOM.find('[name="due_date"]');
    var file = rootDOM.find('[name="file"]');

    if (title.text() != info.title) {

      title.text(info.title);
      breadcrumb.text(info.title);
    }

    if (description.text() != info.description) {

      description.text(info.description);
    }

    if (duration.text() != info.duration) {

      duration.text(info.duration);
    }

    if (dateTimePublished.text() != info.date_time_published) {

      dateTimePublished.text(info.date_time_published);
    }

    if (dueDate.text() != info.due_date) {

      dueDate.text(info.due_date);
    }

    if (info.file !== null) {

      if (file.text() != info.title) {

        file.text(info.file_name);
        file.attr('href', info.file);
        file.attr('title', 'Click to download').tooltip('fixTitle');
        file.attr('download', info.file_name);
      }
    } else {

      file.text('No file attached');
      file.attr('href', '#');
      file.removeAttr('download');
      file.attr('title', 'Nothing to download').tooltip('fixTitle');
    }

    if (myType === 'Teacher') {

      var dateTimeCreated = rootDOM.find('[name="date_time_created"]');
      var backpackButton = rootDOM.find('[name="backpack_button"]');

      showIfEver(dateTimeCreated.parent());

      if (dateTimeCreated.text() != info.date_time_created) {

        dateTimeCreated.text(info.date_time_created);
      }

      if (info.file !== null) {

        showIfEver(backpackButton);
      } else {

        hideIfEver(backpackButton);
      }
    }

    rootDOM.attr('value', info.version);
  } else if (response === 'nothing') {

    assignmentId = 0;

    changeMode(
      'main',
      'ass',
      'Assignment',
      'assignment'
    );

    resetContent();
  }

  if (timeRemaining.text() != info.time_remaining) {

    timeRemaining.text(info.time_remaining);
  }

  if (status.text() != info.status) {

    status.text(info.status);
  }

  if (statusColor.css('color') != info.status_color) {

    statusColor.css('color', info.status_color);
  }

  if (myType === 'Teacher') {

    var publishButton = rootDOM.find('[name="publish_button"]');
    var editButton = rootDOM.find('[name="edit_button"]');

    switch (info.status) {

      case 'Closed':

        hideIfEver(publishButton);
        hideIfEver(editButton);
        break;

      case 'Published':

        showIfEver(publishButton);
        hideIfEver(editButton);

        if (publishButton.text().trim() != 'Unpublish') {

          publishButton.html('<span class="fa fa-eye-slash"></span> <span class="text-main-black">Unpublish</span>');
        }
        break;

      case 'Unpublished':

        showIfEver(publishButton);
        showIfEver(editButton);

        if (publishButton.text().trim() != 'Publish') {

          publishButton.html('<span class="fa fa-eye"></span> <span class="text-main-black">Publish</span>');
        }
        break;
    }
  } else {

    var submitButton = $('#submit_button');

    if (info.status != 'On Going') {

      hideIfEver(submitButton);
    } else {

      showIfEver(submitButton);
    }
  }
}

function traverseResultIds(nodePrefix) {

  $('[id^="' + nodePrefix + '"]').each(function (i) {

    var rootDOM = $(this);

    if (isPartiallyVisible(rootDOM)) {

      var prefixLength = nodePrefix.length;
      var id = rootDOM.attr('id').substr(prefixLength);
      var version = rootDOM.attr('value');

      retrieveResultDisplay(
        id,
        rootDOM,
        i
      );
    }
  });
}

function showResultDisplay(
  data,
  rootDOM,
  i
) {

  var responseJSON = JSON.parse(data);
  var response = responseJSON.response;
  var info = responseJSON.info;

  if (response === 'found') {

    var num = rootDOM.find('[name="num"]');
    var name = rootDOM.find('[name="name"]');
    var dateTimeSubmitted = rootDOM.find('[name="date_time_submitted"]');
    var grade = rootDOM.find('[name="grade"]');
    var downloadButton = rootDOM.find('[name="download_button"]');
    var rateButton = rootDOM.find('[name="rate_button"]');
    var resubmitButton = rootDOM.find('[name="resubmit_button"]');
    var backpackButton = rootDOM.find('[name="backpack_button"]');

    if (crStatus === 'archived') {
      rateButton.remove();
      resubmitButton.remove();
    }

    if (num.text() != (i + 1) + '.') {

      num.text((i + 1) + '.');
    }

    if (name.text() != info.name) {

      name.text(info.name);
    }

    if (dateTimeSubmitted.text() != info.date_time_submitted) {

      dateTimeSubmitted.text(info.date_time_submitted);
    }

    if (grade.text() != info.grade) {

      grade.text(info.grade);
    }

    switch (info.date_time_submitted) {

      case 'Publish First':
      case 'Pending':

        downloadButton.hide();
        rateButton.hide();
        resubmitButton.hide();
        backpackButton.hide();

        downloadButton.attr('href', '#');
        downloadButton.removeAttr('download');
        break;

      case 'Late':

        downloadButton.hide();
        rateButton.hide();
        resubmitButton.show();
        backpackButton.hide();

        downloadButton.attr('href', '#');
        downloadButton.removeAttr('download');
        break;

      default:

        downloadButton.show();
        rateButton.show();
        resubmitButton.show();
        backpackButton.show();

        downloadButton.attr('href', info.file);
        downloadButton.attr('download', info.file_name);
    }
  } else {

    rootDOM.remove();
  }
}

function showEditable(data) {

  var responseJSON = JSON.parse(data);
  var response = responseJSON.response;

  if (response === 'found') {

    var info = responseJSON.info;
    var editForm = $('#edit_form');
    var title = editForm.find('[name="title"]');
    var description = editForm.find('[name="description"]');
    var file = editForm.find('[name="file"]');
    var fileMsg = editForm.find('[name="file_msg"]');
    var fileName = editForm.find('[name="file_name"]');

    title.val(info.title);
    description.val(info.description);

    if (info.file !== null) {

      file.text('Change');
      fileMsg.text('');
      fileName.html(
        info.file_name + ' <a href="#" name="file_remove"><span class="fa fa-remove text-main-red"></span></a> '
      );

      editHasFile = true;
    }
  }
}

function showClassrooms(classrooms) {

  var classroomSelect = $('#pin_form [name="classrooms"]');
  var length = classrooms.length;

  classroomSelect.empty();

  for (var i = 0; i < length; i++) {

    var classroomNodeTemp = classroomNode(
      classrooms[i].id,
      classrooms[i].name
    );

    classroomSelect.append(classroomNodeTemp);
  }
}

function changeMode(
  mode,
  name,
  title,
  panel
) {

  var breadcrumb = $('#' + name + '_bc');
  var mainPanel = $('#' + panel + '_main_panel');
  var contentPanel = $('#' + panel + '_content_panel');

  if (mode === 'content') {

    breadcrumb.html('<a href="#">' + title + '</a>');
    breadcrumb.after('<li id="' + name + '_name" class="active">---</li>');

    hideIfEver(mainPanel);
    showIfEver(contentPanel);

    clearInterval(assignmentRetriever);
    clearInterval(assignmentFiller);

    assignmentContentRetriever = setInterval(function () {

      var rootDOM = $('#assignment_content_panel');
      var version = rootDOM.attr('value');

      retrieveContent(
        myType,
        assignmentId,
        myId,
        version,
        rootDOM
      );
    }, 1000);
  } else if (mode === 'main') {

    breadcrumb.html(title);
    breadcrumb.next().remove();

    showIfEver(mainPanel);
    hideIfEver(contentPanel);

    clearInterval(assignmentContentRetriever);

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
  }

  breadcrumb.toggleClass('active');
}