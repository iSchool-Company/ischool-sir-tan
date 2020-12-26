
function resetPanel(panel) {

  var mainPanel = $('#' + panel + '_panel');
  var emptyPanel = $('#empty_' + panel + '_panel');

  if (mainPanel.children().length > 0) {
    mainPanel.empty();
  }

  if (emptyPanel.css('display') === 'none') {
    mainPanel.prev().hide();
    emptyPanel.show();
  }
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

  if (emptyPanel.css('display') !== 'none') {
    emptyPanel.hide();
  }

  for (var i = 0; i < length; i++) {

    var nodeTemp = node(ids[i]);

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

  $('[id^="' + nodePrefix + '"]').each(function (i) {

    var rootDOM = $(this);

    if (isPartiallyVisible(rootDOM)) {

      var prefixLength = nodePrefix.length;
      var id = rootDOM.attr('id').substr(prefixLength);
      var version = rootDOM.attr('value');

      retrieveDisplay(
        id,
        version,
        rootDOM,
        i
      );
    }
  });
}

function showDisplay(
  data,
  rootDOM,
  i
) {

  var responseJSON = JSON.parse(data);
  var response = responseJSON.response;
  var info = responseJSON.info;

  if (response === 'found') {

    var num = rootDOM.find('[name="num"]').first();
    var nums = rootDOM.find('[name="num"]');
    var file = rootDOM.find('[name="file"]');
    var dateTimeAdded = rootDOM.find('[name="date_time_added"]');
    var type = rootDOM.find('[name="type"]');
    var editButton = rootDOM.find('[name="edit_button"]');
    var pinButton = rootDOM.find('[name="pin_button"]');
    var removeButton = rootDOM.find('[name="remove_button"]');
    var typeValue = '';

    if (num.text() != (i + 1) + '.') {
      nums.text((i + 1) + '.');
    }

    if (file.text() != info.file_name) {
      file.text(info.file_name);
      file.attr('href', info.file);
      file.attr('download', info.file_name);
    }

    switch (info.file.split('.').pop()) {

      case 'doc':
      case 'docx':
        typeValue = '<span class="fa fa-file-word-o text-main-green"></span> Document';
        break;

      case 'xls':
      case 'xlsx':
        typeValue = '<span class="fa fa-file-excel-o text-main-green"></span> Spreadsheet';
        break;

      case 'ppt':
      case 'pptx':
        typeValue = '<span class="fa fa-file-powerpoint-o text-main-green"></span> Presentation';
        break;

      case 'pdf':
        typeValue = '<span class="fa fa-file-pdf-o text-main-green"></span> PDF';
        break;

      case 'txt':
        typeValue = '<span class="fa fa-file-text-o text-main-green"></span> Text File';
        break;
    }

    if (type.html() != typeValue) {
      type.html(typeValue);
    }

    if (dateTimeAdded.text() != info.date_time_added) {
      dateTimeAdded.text(info.date_time_added);
    }

    if (myType === 'Teacher') {
      showIfEver(editButton);
      showIfEver(removeButton);
      showIfEver(pinButton);
    } else {
      showIfEver(editButton);
      showIfEver(removeButton);
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
    var fileNameR = editForm.find('[name="file_name_r"]');
    var file = editForm.find('[name="file"]');
    var fileMsg = editForm.find('[name="file_msg"]');
    var fileName = editForm.find('[name="file_name"]');

    fileNameR.val(info.file);

    if (info.file_name !== null) {

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