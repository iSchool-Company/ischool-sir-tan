
function backpackNode(id) {

  return $(
    '<div id="bckpck' + id + '" class="row" value="0"> ' +
    '<div class="col-md-1"> ' +
    '<p class="hidden-xs hidden-sm" name="num">0.</p> ' +
    '</div> ' +
    '<div class="col-md-4"> ' +
    '<p> ' +
    '<span class="visible-xs-inline visible-sm-inline" name="num">0.</span> ' +
    '<a class="text-main-green" href="#" name="file" title="Click to download" data-toggle="tooltip" style="font-size:15px;">---</a> ' +
    '</p> ' +
    '</div> ' +
    '<div class="col-md-2"> ' +
    '<p> ' +
    '<span name="type">---</span> ' +
    '</p> ' +
    '</div> ' +
    '<div class="col-md-3"> ' +
    '<p> ' +
    '<span class="visible-xs-inline visible-sm-inline fa fa-calendar-plus-o text-main-green"></span> ' +
    '<span name="date_time_added">---</span> ' +
    '</p> ' +
    '</div> ' +
    '<div class="col-md-2"> ' +
    '<a href="#edit_modal" name="edit_button" data-toggle="modal" style="display:none; margin-right:20px;"> ' +
    '<span class="fa fa-pencil text-main-green" data-toggle="tooltip" data-placement="auto" title="Edit" style="font-size:18px;"></span>' +
    '</a> ' +
    '<a href="#pin_modal" name="pin_button" data-toggle="modal" style="display:none; margin-right:20px;"> ' +
    '<span class="fa fa-thumb-tack text-main-green" data-toggle="tooltip" data-placement="auto" title="Pin" style="font-size:18px;"></span>' +
    '</a> ' +
    '<a href="#delete_modal" name="remove_button" data-toggle="modal" style="display:none;"> ' +
    '<span class="fa fa-trash text-main-red" data-toggle="tooltip" data-placement="auto" title="Delete" style="font-size:18px;"></span>' +
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