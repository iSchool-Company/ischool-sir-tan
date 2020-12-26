
function memberNode(
  id,
  name,
  image
) {

  return $(
    '<div name="mmbr" style="padding:5px;" value="' + id + '"> ' +
    '<input type="checkbox" checked> ' +
    '<span style="padding-bottom:7px;"> ' +
    '<img class="img-circle" src="' + image + '" style="width:20px;height:20px;"> ' +
    '<span class="text-main-black">' + name + '</span> ' +
    '</span> ' +
    '</div> '
  );
}

function quizNode(id) {

  var crudButton =
    '<div name="qz_dropdown" class="dropdown">' +
    '<button class="btn btn-link dropdown-toggle text-main-green" type="button" data-toggle="dropdown" style="text-decoration:none;">' +
    '<span class="fa fa-gear"></span> <span class="fa fa-chevron-down"></span>' +
    '</button>' +
    '<ul class="dropdown-menu dropdown-menu-right">' +
    '<li class="disabled">' +
    '<a href="#publish_modal" data-toggle="modal" name="publish_button">' +
    '</a>' +
    '</li>' +
    '<li>' +
    '<a href="#edit_modal" data-toggle="modal" name="edit_button">' +
    '<span class="fa fa-pencil"></span> Edit' +
    '</a>' +
    '</li>' +
    '<li>' +
    '<a href="#delete_modal" data-toggle="modal" name="delete_button">' +
    '<span class="fa fa-trash"></span> Delete' +
    '</a>' +
    '</li>' +
    '<li>' +
    '<a href="#pin_modal" data-toggle="modal" name="pin_button">' +
    '<span class="fa fa-thumb-tack"></span> Pin' +
    '</a>' +
    '</li>' +
    '</ul>' +
    '</div>';

  var dateTimeCreatedPart =
    '<p>' +
    '<span class="fa fa-calendar-plus-o text-main-green" title="Date Created" data-toggle="tooltip"></span> ' +
    '<span name="date_time_created">---</span> ' +
    '</p>';

  return $(
    '<div id="qz' + id + '" class="panel panel-default panel-gray" value="0">' +
    '<div class="panel-body">' +
    (myType === 'Teacher' && crStatus === 'on_going' ? crudButton : '') +
    '<div class="media" style="margin-top:0;">' +
    '<div class="media-left hidden-xs">' +
    '<img src="pictures/modules/quiz.png" style="width:60px;">' +
    '</div>' +
    '<div class="media-body">' +
    '<h4 class="media-heading">' +
    '<a class="text-main-green" name="title" href="#">---</a> ' +
    '</h4>' +
    (myType === 'Teacher' ? dateTimeCreatedPart : '') +
    '<p>' +
    '<span class="fa fa-eye text-main-green" title="Date Published" data-toggle="tooltip"></span> ' +
    '<span name="date_time_published">---</span> ' +
    '</p>' +
    '<p>' +
    '<span class="fa fa-hourglass-end text-main-green" title="Due Date" data-toggle="tooltip"></span> ' +
    '<span name="due_date">---</span> ' +
    '<br class="visible-xs"/>' +
    '<small name="time_remaining"></small>' +
    '</p>' +
    '<p>' +
    '<span class="fa fa-circle text-main-green" name="status_color" style="color:gray;"></span> ' +
    '<span name="status"">---</span>' +
    '</p>' +
    '<p name="fa_info">' +
    '<span name="question_count">---</span> ' +
    '<span class="fa fa-question-circle text-main-green" title="Questions" data-toggle="tooltip"></span> ' +
    '&nbsp;&nbsp;' +
    '<span name="taker_count">---</span> ' +
    '<span class="fa fa-pencil text-main-green" title="Done" data-toggle="tooltip"></span> ' +
    '&nbsp;&nbsp;' +
    '<span name="idle_count">---</span> ' +
    '<span class="fa fa-clock-o text-main-green" title="Waiting" data-toggle="tooltip"></span> ' +
    '</p>' +
    '</div>' +
    '</div>' +
    '</div>' +
    '</div>'
  );
}

function qstnNode(num, id) {

  return $(
    '<div class="form-group" name="question"> ' +
    '<hr> ' +
    '<label> ' +
    '<a class="text-main-green" name="hide" href="#"> ' +
    '<span class="fa fa-minus" style="font-size:16px;"></span>' +
    '</a> ' +
    'Question # <span name="qstn_num">' + num + '</span> ' +
    '<a class="text-main-red" name="qstn_remove" href="#"> ' +
    '<span class="fa fa-remove" style="font-size:16px;"></span>' +
    '</a> ' +
    '</label> ' +
    '<textarea class="form-control" name="qstn" rows="5" placeholder="Enter question here..."></textarea> ' +
    '<br> ' +
    '<div name="add_choices_panel" class="row"> ' +
    '<div class="col-md-8"> ' +
    '</div> ' +
    '</div> ' +
    '</div> '
  );
}

function mcChoiceNode(
  num,
  id
) {

  return $(
    '<div class="form-group" name="choice" value="' + id + '"> ' +
    '<label> ' +
    'Choice # <span name="chc_num">' + num + '</span> ' +
    '<a class="text-main-red" href="#"> ' +
    '<span class="fa fa-remove" name="chc_remove" style="font-size:16px;"></span> ' +
    '</a> ' +
    '</label> ' +
    '<input class="form-control" name="chc" placeholder="Enter answer here..."> ' +
    '<div class="checkbox" style="margin:0;"> ' +
    '<label> ' +
    '&nbsp; <input name="set_answer" type="checkbox"/> Set as answer ' +
    '</label> ' +
    '</div> ' +
    '</div> '
  );
}

function tfChoiceNode() {

  return $(
    '<div class="form-group" name="choice"> ' +
    '<label>Answer:</label> ' +
    '<select class="form-control" name="chc"> ' +
    '<option>True</option> ' +
    '<option>False</option> ' +
    '</select> ' +
    '</div> '
  );
}

function iChoiceNode() {

  return $(
    '<div class="form-group" name="choice"> ' +
    '<label>Answer:</label> ' +
    '<input class="form-control" name="chc" placeholder="Enter answer here..."> ' +
    '</div> '
  );
}

function addChoiceButton() {

  return $(
    '<button class="btn btn-success" name="add_choice" type="button"> ' +
    '<span class="fa fa-plus-circle"></span> ' +
    'Add Choice ' +
    '</button> '
  );
}

function contentQstnNode(
  num,
  id,
  question,
  answer
) {

  return $(
    '<div id="qstn' + id + '"> ' +
    '<div class="panel-body"> ' +
    '<div class="dropdown pull-right" name="manage_button" style="display:none;"> ' +
    '<button class="btn btn-link dropdown-toggle text-main-green" type="button" data-toggle="dropdown" style="text-decoration:none;"> ' +
    '<span class="fa fa-gear" style="font-size:16px;"></span> <span class="fa fa-chevron-down"></span> ' +
    '</button> ' +
    '<ul class="dropdown-menu dropdown-menu-right"> ' +
    '<li> ' +
    '<a href="#edit_question_modal" data-toggle="modal" name="q_edit_button"> ' +
    '<span class="fa fa-pencil"></span> Edit ' +
    '</a> ' +
    '</li> ' +
    '<li> ' +
    '<a href="#delete_question_modal" data-toggle="modal" name="q_delete_button"> ' +
    '<span class="fa fa-trash"></span> Delete ' +
    '</a> ' +
    '</li> ' +
    '</ul> ' +
    '</div> ' +
    '<p><b style="margin: 0 5px;"><span name="num">' + num + '</span>)</b> <span name="q_value">' + question + '</span></p> ' +
    '<small style="margin-left:30psx;"><b name="answer_type">Answer:</b> <span name="a_value">' + answer + '</span></small> ' +
    '</div> ' +
    '<hr style="margin:0;"> ' +
    '</div> '
  );
}

function classroomNode(
  id,
  name
) {

  return $(
    '<option value="' + id + '">' + name + '</option>'
  );
}

function resultNode(id) {

  return $(
    '<div id="resqz' + id + '" class="row"> ' +
    '<div class="col-md-1"> ' +
    '<p class="hidden-xs hidden-sm" name="num">0.</p> ' +
    '</div> ' +
    '<div class="col-md-5"> ' +
    '<p> ' +
    '<span class="visible-xs-inline visible-sm-inline" name="num">0.</span> ' +
    '<span name="name">---</span> ' +
    '</p> ' +
    '</div> ' +
    '<div class="col-md-3"> ' +
    '<p> ' +
    '<span class="visible-xs-inline visible-sm-inline fa fa-pencil"></span> ' +
    '<span name="date_time_taken">---</span> ' +
    '</p> ' +
    '</div> ' +
    '<div class="col-md-2"> ' +
    '<p> ' +
    '<span class="visible-xs-inline visible-sm-inline fa fa-percent"></span> ' +
    '<span name="score">---</span> ' +
    '</p> ' +
    '</div> ' +
    '<div class="col-md-1"> ' +
    '<a class="btn btn-xs" href="#retake_modal" name="retake_button" data-toggle="modal" style="display:none;"> ' +
    '<span class="fa fa-repeat" data-toggle="tooltip" data-placement="auto" title="Retake" style="font-size:18px;"></span> ' +
    '</a> ' +
    '</div> ' +
    '<hr class="visible-xs visible-sm"> ' +
    '</div> '
  );
}