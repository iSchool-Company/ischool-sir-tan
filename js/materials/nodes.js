
function materialsNode(id) {

  return $(
    '<div id="mtrl' + id + '" class="row" value="0"> ' +
    '<div class="col-md-1"> ' +
    '<p class="hidden-xs hidden-sm" name="num">0.</p> ' +
    '</div> ' +
    '<div class="col-md-4"> ' +
    '<p> ' +
    '<span class="visible-xs-inline visible-sm-inline" name="num">0.</span> ' +
    '<a href="#" name="topic" title="Click to download" data-toggle="tooltip">---</a> ' +
    '</p> ' +
    '</div> ' +
    '<div class="col-md-2"> ' +
    '<p> ' +
    '<span name="type">---</span> ' +
    '</p> ' +
    '</div> ' +
    '<div class="col-md-3"> ' +
    '<p> ' +
    '<span class="visible-xs-inline visible-sm-inline fa fa-calendar-plus-o"></span> ' +
    '<span name="date_time_added">---</span> ' +
    '</p> ' +
    '</div> ' +
    '<div class="col-md-2"> ' +
    '<a href="#edit_modal" name="edit_button" data-toggle="modal" style="display:none;"> ' +
    '<span class="fa fa-pencil" data-toggle="tooltip" data-placement="auto" title="Edit" style="font-size:18px;"></span>' +
    '</a> ' +
    '&nbsp;&nbsp; ' +
    '<a href="#backpack_modal" name="backpack_button" data-toggle="modal" style="display:none;"> ' +
    '<span class="fa fa-briefcase" data-toggle="tooltip" data-placement="auto" title="Add to Backpack" style="font-size:18px;"></span>' +
    '</a> ' +
    '&nbsp;&nbsp; ' +
    '<a href="#pin_modal" name="pin_button" data-toggle="modal" style="display:none;"> ' +
    '<span class="fa fa-thumb-tack" data-toggle="tooltip" data-placement="auto" title="Pin" style="font-size:18px;"></span>' +
    '</a> ' +
    '&nbsp;&nbsp; ' +
    '<a href="#delete_modal" name="remove_button" data-toggle="modal" style="display:none;"> ' +
    '<span class="fa fa-remove" data-toggle="tooltip" data-placement="auto" title="Remove" style="font-size:18px;"></span>' +
    '</a> ' +
    '<hr class="visible-xs visible-sm"> ' +
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