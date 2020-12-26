
function resetPanel(panel) {

  var mainPanel = $('#' + panel + '_panel');
  var emptyPanel = $('#empty_' + panel + '_panel');

  if (mainPanel.children().length > 0) {
    mainPanel.empty();
  }

  if (emptyPanel.css('display') === 'none') {
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

function fillIds2(
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
          $('[id^="' + nodePrefix + '"]').first().attr('id').substr(prefixLength)
        ) {

          $('#' + nodePrefix + ids[i]).remove();
          $('#' + panel + '_panel').prepend(nodeTemp);
          $('#' + nodePrefix + ids[i]).hide();
          $('#' + nodePrefix + ids[i]).fadeIn(500);
        }
      } else {

        $('#' + panel + '_panel').prepend(nodeTemp);
        $('#' + nodePrefix + ids[i]).hide();
        $('#' + nodePrefix + ids[i]).fadeIn(500);
      }
    } else {

      if ($('#' + nodePrefix + ids[i]).length > 0) {

        if (
          $('#' + nodePrefix + ids[i]).prev().attr('id').substr(prefixLength)
          !=
          ids[i - 1]
        ) {

          $('#' + nodePrefix + ids[i]).remove();
          $('#' + nodePrefix + ids[i - 1]).after(nodeTemp);
          $('#' + nodePrefix + ids[i]).hide();
          $('#' + nodePrefix + ids[i]).fadeIn(500);
        }
      } else {

        $('#' + nodePrefix + ids[i - 1]).after(nodeTemp);
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

      retrieveQuizDisplay(
        myType,
        id,
        myId,
        version,
        rootDOM
      );
    }
  });
}

function showQuizDisplay(
  data,
  rootDOM
) {

  var responseJSON = JSON.parse(data);
  var response = responseJSON.response;
  var info = responseJSON.info;

  var timeRemaining = rootDOM.find('[name="time_remaining"]');
  var status = rootDOM.find('[name="status"]');
  var statusColor = rootDOM.find('[name="status_color"]');
  var questionCount = rootDOM.find('[name="question_count"]');
  var takerCount = rootDOM.find('[name="taker_count"]');
  var idleCount = rootDOM.find('[name="idle_count"]');

  if (response === 'found') {

    var title = rootDOM.find('[name="title"]');
    var dateTimePublished = rootDOM.find('[name="date_time_published"]');
    var dueDate = rootDOM.find('[name="due_date"]');

    if (title.text() != info.title) {
      title.text(info.title);
    }

    if (dateTimePublished.text() != info.date_time_published) {
      dateTimePublished.text(info.date_time_published);
    }

    if (dueDate.text() != info.due_date) {
      dueDate.text(info.due_date);
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

  if (questionCount.text() != info.question_count) {
    questionCount.text(info.question_count);
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

        publishButton.hide();
        editButton.hide();

        break;

      case 'Published':

        publishButton.show();
        editButton.hide();

        if (publishButton.text().trim() != 'Unpublish') {
          publishButton.html('<span class="fa fa-eye-slash"></span> Unpublish');
        }

        publishButton.parent().removeClass('disabled');

        break;

      case 'Unpublished':

        publishButton.show();
        editButton.show();

        if (publishButton.text().trim() != 'Publish') {
          publishButton.html('<span class="fa fa-eye"></span> Publish');
        }

        if (info.question_count == 0) {
          publishButton.parent().addClass('disabled');
          publishButton.attr('title', 'You cannot publish a blank quiz.');
          publishButton.attr('href', '#');
        } else {
          publishButton.parent().removeClass('disabled');
          publishButton.attr('title', '');
          publishButton.attr('href', '#publish_modal');
        }

        break;
    }
  }
}

function showQuizEditable(data) {

  var responseJSON = JSON.parse(data);
  var response = responseJSON.response;

  if (response === 'found') {

    var info = responseJSON.info;
    var editForm = $('#edit_form');
    var title = editForm.find('[name="title"]');
    var description = editForm.find('[name="description"]');
    var type = editForm.find('[name="type"]');
    var duration = editForm.find('[name="duration"]');

    quizType = info.type;

    title.val(info.title);
    description.val(info.description);
    type.val(info.type);
    duration.val(info.duration);
  }
}

function addQstn(parent) {

  var qstnPanel = $(parent);

  qstnLength = qstnPanel.children().length;

  var qstnNodeTemp = qstnNode(qstnLength + 1);

  switch (quizType) {

    case '1':

      qstnNodeTemp.find('[name="add_choices_panel"]').after(addChoiceButton());
      qstnNodeTemp.find('[name="add_choices_panel"] > div').append(mcChoiceNode(1));
      qstnPanel.append(qstnNodeTemp);
      break;

    case '2':

      qstnNodeTemp.find('[name="add_choices_panel"] > div').append(tfChoiceNode());
      qstnPanel.append(qstnNodeTemp);
      break;

    case '3':

      qstnNodeTemp.find('[name="add_choices_panel"] > div').append(iChoiceNode());
      qstnPanel.append(qstnNodeTemp);
      break;
  }

  qstnPanel.find('[name="choice"]').last().hide();
  qstnPanel.find('[name="choice"]').last().slideDown(200);
}

function removeQstn(rootDOM) {

  var qstnPanel = rootDOM.parents('[id$="question_panel"]');

  rootDOM.slideUp(200);

  setTimeout(function () {

    rootDOM.remove();

    qstnLength = qstnPanel.children().length;

    if (qstnLength == 0) {

      addQstn('#' + qstnPanel.attr('id'));
    } else {

      qstnPanel.children().each(function (i) {

        var qstn = $(this);

        qstn.find('[name="qstn_num"]').text(i + 1);
      });
    }
  }, 200);
}

function addChc(rootDOM) {

  var chcPanel = rootDOM.find('[name="add_choices_panel"] > div');
  var length = chcPanel.children().length;

  if (length < 5) {

    chcPanel.append(mcChoiceNode(length + 1));
    chcPanel.find('[name="choice"]').last().hide();
    chcPanel.find('[name="choice"]').last().slideDown(200);
  }
}

function removeChc(rootDOM) {

  var chcPanel = rootDOM.parents('[name="add_choices_panel"] > div');
  var length = 0;

  rootDOM.slideUp(200);

  setTimeout(function () {

    rootDOM.remove();

    length = chcPanel.children().length;

    if (length == 0) {

      addChc(chcPanel.parents('[name="question"]'));
    } else {

      chcPanel.children().each(function (i) {

        var chc = $(this);

        chc.find('[name="chc_num"]').text(i + 1);
      });
    }
  }, 200);
}

function qstnHasContent() {

  var hasContent = false;

  $('[name="question"]').each(function () {

    var rootDOM = $(this);

    if (quizType == '1') {

      if (rootDOM.find('textarea').val() !== '') {

        rootDOM.find('[name="choice"]').each(function () {

          var chc = $(this).find('[name="chc"]');
          var chk = $(this).find('[name="set_answer"]');

          if (chc.val() !== '' && chk.is(':checked')) {
            hasContent = true;
          }
        });
      }
    } else {

      if (rootDOM.find('[name="qstn"]').val() != '' && rootDOM.find('[name="chc"]').val() != '') {
        hasContent = true;
      }
    }
  });

  return hasContent;
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

    mainPanel.hide();
    contentPanel.show();

    clearInterval(quizRetriever);
    clearInterval(quizFiller);

    quizContentRetriever = setInterval(function () {

      var rootDOM = $('#quiz_content_panel');
      var version = rootDOM.attr('value');
      var cType = rootDOM.find('[name="type"]');

      retrieveQuizContent(
        myType,
        quizId,
        myId,
        version,
        rootDOM,
        cType
      );
    }, 1000);
  } else if (mode === 'main') {

    breadcrumb.html(title);
    breadcrumb.next().remove();

    mainPanel.show();
    contentPanel.hide();

    clearInterval(quizContentRetriever);

    quizRetriever = setInterval(function () {

      retrieveQuizIds(
        myType,
        classroomId,
        myId
      );
    }, 1000);

    quizFiller = setInterval(function () {

      traverseIds('qz');
    }, 1000);
  }

  breadcrumb.toggleClass('active');
}

function showQuizContent(
  data,
  rootDOM,
  cType
) {

  var responseJSON = JSON.parse(data);
  var response = responseJSON.response;
  var info = responseJSON.info;

  var timeRemaining = rootDOM.find('[name="time_remaining"]');
  var status = rootDOM.find('[name="status"]');
  var statusColor = rootDOM.find('[name="status_color"]');
  var questionCount = rootDOM.find('[name="question_count"]');

  if (response === 'found') {

    var title = rootDOM.find('[name="title"]');
    var bcTitle = $('#quiz_name');
    var description = rootDOM.find('[name="description"]');
    var duration = rootDOM.find('[name="duration"]');
    var dateTimePublished = rootDOM.find('[name="date_time_published"]');
    var dueDate = rootDOM.find('[name="due_date"]');

    if (title.text() != info.title) {
      title.text(info.title);
    }

    if (bcTitle.text() != info.title) {
      bcTitle.text(info.title);
    }

    if (description.text() != info.description) {
      description.text(info.description);
    }

    if (duration.text() != info.duration) {
      duration.text(info.duration);
    }

    if (cType.text() != info.type) {
      cType.text(info.type);
    }

    if (dateTimePublished.text() != info.date_time_published) {
      dateTimePublished.text(info.date_time_published);
    }

    if (dueDate.text() != info.due_date) {
      dueDate.text(info.due_date);
    }

    switch (info.type) {

      case 'Multiple Choice':
        quizType = '1';
        rootDOM.find('[name="answer_type"]').text('Choices:');
        break;

      case 'True/False':
        quizType = '2';
        rootDOM.find('[name="answer_type"]').text('Answer:');
        break;

      case 'Identification':
        quizType = '3';
        rootDOM.find('[name="answer_type"]').text('Answer:');
        break;
    }

    rootDOM.attr('value', info.version);
  } else if (response === 'nothing') {

    changeMode('main');
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

  if (questionCount.text() != info.question_count) {
    questionCount.text(info.question_count);
  }

  if (myType === 'Teacher') {

    var dateTimeCreated = rootDOM.find('[name="date_time_created"]');
    var publishButton = rootDOM.find('[name="publish_button"]');
    var editButton = rootDOM.find('[name="edit_button"]');
    var manageButton = rootDOM.find('[name="manage_button"]');
    var addQuestionButton = $('#add_question_button');

    dateTimeCreated.parent().show();

    if (dateTimeCreated.text() != info.date_time_created) {
      dateTimeCreated.text(info.date_time_created);
    }

    switch (info.status) {

      case 'Closed':

        publishButton.hide();
        editButton.hide();
        addQuestionButton.hide();
        manageButton.hide();

        break;

      case 'Published':

        publishButton.show();
        editButton.hide();
        addQuestionButton.hide();
        manageButton.hide();

        if (publishButton.text().trim() != 'Unpublish') {
          publishButton.html('<span class="fa fa-eye-slash"></span> Unpublish');
        }

        publishButton.parent().removeClass('disabled');

        break;

      case 'Unpublished':

        publishButton.show();
        editButton.show();
        addQuestionButton.show();
        manageButton.show();

        if (publishButton.text().trim() != 'Publish') {
          publishButton.html('<span class="fa fa-eye"></span> Publish');
        }

        if (info.question_count == 0) {
          publishButton.parent().addClass('disabled');
          publishButton.attr('title', 'You cannot publish a blank quiz.');
          publishButton.attr('href', '#');
        } else {
          publishButton.parent().removeClass('disabled');
          publishButton.attr('title', '');
          publishButton.attr('href', '#publish_modal');
        }

        break;
    }
  } else {

    var takeNowButton = $('#take_now_button');

    if (info.status != 'On Going') {
      takeNowButton.hide();
    } else {
      takeNowButton.show();
    }
  }
}

function showQuestions(questions) {

  var length = questions.length;

  var existingQuestions = '';

  for (var i = 0; i < length; i++) {

    var contentQstnNodeTemp = contentQstnNode(
      i + 1,
      questions[i].id,
      questions[i].value,
      questions[i].answer
    );

    if (crStatus === 'archived') {
      contentQstnNodeTemp.find('[name="manage_button"]').remove();
    }

    if (i === 0) {

      if ($('#qstn' + questions[i].id).length > 0) {

        if (
          $('#qstn' + questions[i].id).attr('id').substr(4)
          !=
          $('[id^="qstn"]').first().attr('id').substr(4)
        ) {

          $('#qstn' + questions[i].id).remove();
          $('#manage_question_panel').prepend(contentQstnNodeTemp);
          $('#qstn' + questions[i].id).hide();
          $('#qstn' + questions[i].id).fadeIn(1000);
        } else {

          updateQuestionNode(questions[i]);
        }
      } else {

        $('#manage_question_panel').prepend(contentQstnNodeTemp);
        $('#qstn' + questions[i].id).hide();
        $('#qstn' + questions[i].id).fadeIn(1000);
      }
    } else {

      if ($('#qstn' + questions[i].id).length > 0) {

        if (
          $('#qstn' + questions[i].id).prev().attr('id').substr(4)
          !=
          questions[i - 1].id
        ) {

          $('#qstn' + questions[i].id).remove();
          $('#qstn' + questions[i - 1].id).after(contentQstnNodeTemp);
          $('#qstn' + questions[i].id).hide();
          $('#qstn' + questions[i].id).fadeIn(1000);
        } else {

          updateQuestionNode(questions[i]);
        }
      } else {

        $('#qstn' + questions[i - 1].id).after(contentQstnNodeTemp);
        $('#qstn' + questions[i].id).hide();
        $('#qstn' + questions[i].id).fadeIn(1000);
      }
    }

    existingQuestions += '#qstn' + questions[i].id + (i < length - 1 ? ', ' : '');
  }

  $('[id^="qstn"]').not(existingQuestions).remove();
}

function updateQuestionNode(objectTemp) {

  var rootDOM = $('#qstn' + objectTemp.id);
  var qValue = rootDOM.find('[name="q_value"]');
  var aValue = rootDOM.find('[name="a_value"]');

  if (qValue.html() !== objectTemp.value) {
    qValue.html(objectTemp.value);
  }

  if (aValue.html() !== objectTemp.answer) {
    aValue.html(objectTemp.answer);
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

function traverseResultIds() {

  $('[id^="resqz"]').each(function (i) {

    var rootDOM = $(this);

    if (isPartiallyVisible(rootDOM)) {

      retrieveResultDisplay(
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

    var num = rootDOM.find('[name="num"]').first();
    var nums = rootDOM.find('[name="num"]');
    var name = rootDOM.find('[name="name"]');
    var dateTimeTaken = rootDOM.find('[name="date_time_taken"]');
    var score = rootDOM.find('[name="score"]');
    var retakeButton = rootDOM.find('[name="retake_button"]');

    if (crStatus === 'archived') {
      retakeButton.remove();
    }

    if (num.text() != (i + 1) + '.') {
      nums.text((i + 1) + '.');
    }

    if (name.text() != info.name) {
      name.text(info.name);
    }

    if (dateTimeTaken.text() != info.date_time_taken) {
      dateTimeTaken.text(info.date_time_taken);
    }

    if (score.text() != info.score) {
      score.text(info.score);
    }

    if (info.score === '---') {
      hideIfEver(retakeButton);
    } else {
      showIfEver(retakeButton);
    }
  } else {

    rootDOM.remove();
  }
}