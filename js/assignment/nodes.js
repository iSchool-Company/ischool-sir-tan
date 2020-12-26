
function assignmentNode(id) {

  var crudButton =
    '<div name="assmt_dropdown" class="dropdown"> ' +
    '<button class="btn btn-link dropdown-toggle text-main-green" type="button" data-toggle="dropdown" style="text-decoration:none;"> ' +
    '<span class="fa fa-gear"></span> <span class="fa fa-chevron-down"></span> ' +
    '</button> ' +
    '<ul class="dropdown-menu dropdown-menu-right"> ' +
    '<li> ' +
    '<a href="#publish_modal" data-toggle="modal" name="publish_button" style="display:none;"> ' +
    '</a> ' +
    '</li> ' +
    '<li> ' +
    '<a href="#edit_modal" data-toggle="modal" name="edit_button" style="display:none;"> ' +
    '<span class="fa fa-pencil"></span> <span class="text-main-black">Edit</span> ' +
    '</a> ' +
    '</li> ' +
    '<li> ' +
    '<a href="#x" data-toggle="modal" name="backpack_button" style="display:none;"> ' +
    '<span class="fa fa-briefcase"></span> <span class="text-main-black">Add to Backpack</span> ' +
    '</a> ' +
    '</li> ' +
    '<li> ' +
    '<a href="#pin_modal" data-toggle="modal" name="pin_button"> ' +
    '<span class="fa fa-thumb-tack"></span> <span class="text-main-black">Pin</span> ' +
    '</a> ' +
    '</li> ' +
    '<li> ' +
    '<a href="#delete_modal" data-toggle="modal" name="delete_button"> ' +
    '<span class="fa fa-trash text-main-red"></span> <span class="text-main-black">Delete</span> ' +
    '</a> ' +
    '</li> ' +
    '</ul> ' +
    '</div> ';

  var dateTimeCreatedPart =
    '<p>' +
    '<span class="fa fa-calendar-plus-o text-main-green" title="Date Created" data-toggle="tooltip"></span> ' +
    '<span name="date_time_created">---</span> ' +
    '</p>';

  return $(
    '<div id="assmt' + id + '" class="panel panel-default panel-gray" value="0"> ' +
    '<div class="panel-body"> ' +
    (myType === 'Teacher' && crStatus === 'on_going' ? crudButton : '') +
    '<div class="media-left hidden-xs"> ' +
    '<img src="pictures/modules/quiz.png" style="width:60px;"> ' +
    '</div> ' +
    '<div class="media-body"> ' +
    '<h4 class="media-heading"> ' +
    '<a class="text-main-green" name="title" href="#">---</a> ' +
    '</h4> ' +
    (myType === 'Teacher' ? dateTimeCreatedPart : '') +
    '<p> ' +
    '<span class="fa fa-eye text-main-green" title="Date Published" data-toggle="tooltip"></span> ' +
    '<span name="date_time_published">---</span> ' +
    '</p> ' +
    '<p> ' +
    '<span class="fa fa-hourglass-end text-main-green" title="Due Date" data-toggle="tooltip"></span> ' +
    '<span name="due_date">---</span> ' +
    '<br class="visible-xs"/> ' +
    '<small name="time_remaining"></small> ' +
    '</p> ' +
    '<p> ' +
    '<span class="fa fa-circle" name="status_color" style="color:gray;"></span> ' +
    '<span name="status"">---</span> ' +
    '</p> ' +
    '<p name="fa_info"> ' +
    '<span name="has_file">---</span> ' +
    '<span class="fa fa-file-text text-main-green" title="Has File" data-toggle="tooltip"></span> ' +
    '&nbsp;&nbsp; ' +
    '<span name="taker_count">---</span> ' +
    '<span class="fa fa-pencil text-main-green" title="Done" data-toggle="tooltip"></span> ' +
    '&nbsp;&nbsp; ' +
    '<span name="idle_count">---</span> ' +
    '<span class="fa fa-clock-o text-main-green" title="Pending" data-toggle="tooltip"></span> ' +
    '</p> ' +
    '</div> ' +
    '</div> ' +
    '</div> ' +
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
    '<div id="resassmt' + id + '" class="row"> ' +
    '<div class="col-md-1"> ' +
    '<p class="hidden-xs hidden-sm" name="num">0.</p> ' +
    '</div> ' +
    '<div class="col-md-4"> ' +
    '<p> ' +
    '<span class="visible-xs-inline visible-sm-inline" name="num">0.</span> ' +
    '<span name="name">---</span> ' +
    '</p> ' +
    '</div> ' +
    '<div class="col-md-3"> ' +
    '<p> ' +
    '<span class="visible-xs-inline visible-sm-inline fa fa-pencil"></span> ' +
    '<span name="date_time_submitted">---</span> ' +
    '</p> ' +
    '</div> ' +
    '<div class="col-md-1"> ' +
    '<p> ' +
    '<span class="visible-xs-inline visible-sm-inline fa fa-percent"></span> ' +
    '<span name="grade">---</span> ' +
    '</p> ' +
    '</div> ' +
    '<div class="col-md-3"> ' +
    '<a href="#" name="download_button" style="display:none;text-decoration:none;margin-right:20px;"> ' +
    '<span class="fa fa-cloud-download text-main-green" data-toggle="tooltip" data-placement="auto" title="Download" style="font-size:18px;"></span>' +
    '</a> ' +
    '<a href="#rate_modal" name="rate_button" data-toggle="modal" style="display:none;text-decoration:none;margin-right:20px;"> ' +
    '<span class="fa fa-pencil-square-o text-main-green" data-toggle="tooltip" data-placement="auto" title="Rate" style="font-size:18px;"></span>' +
    '</a> ' +
    '<a href="#resubmit_modal" name="resubmit_button" data-toggle="modal" style="display:none;text-decoration:none;margin-right:20px;"> ' +
    '<span class="fa fa-repeat text-main-green" data-toggle="tooltip" data-placement="auto" title="Resubmit" style="font-size:18px;"></span>' +
    '</a> ' +
    '<a href="#backpack_modal" name="backpack_button" data-toggle="modal" style="display:none;text-decoration:none;"> ' +
    '<span class="fa fa-briefcase text-main-green" data-toggle="tooltip" data-placement="auto" title="Add to Backpack" style="font-size:18px;"></span>' +
    '</a> ' +
    '</div> ' +
    '<hr class="visible-xs visible-sm"> ' +
    '</div> '
  );
}