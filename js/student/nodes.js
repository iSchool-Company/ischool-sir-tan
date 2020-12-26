
function studentNode(
  stdId,
  stdImage,
  stdName,
  stdUsername
) {

  var deleteButton = '';

  if (myType === 'Teacher') {

    deleteButton =
      '<a class="btn btn-link" href="#remove_modal" name="delete_button" data-toggle="modal" style="position:absolute;top:0;right:0;margin:5px;color:#e24e42;"> ' +
      '<span class="fa fa-remove" title="Remove this Student" data-toggle="tooltip" data-placement="auto"></span> ' +
      '</a> ';
  }

  return $(
    '<div id="std' + stdId + '" class="col-md-4 col-sm-6"> ' +
    '<div class="panel panel-default panel-gray" style="position:relative;"> ' +
    '<span class="label label-success" style="position:absolute;right:40px;top:20px;"></span> ' +
    '<div class="panel-body panel-student"> ' +
    '<div class="media"> ' +
    '<div class="media-left"> ' +
    '<img class="img-circle" src="' + stdImage + '" alt="Not Available" style="width:60px;height:60px;"> ' +
    '</div> ' +
    '<div class="media-body"> ' +
    '<a class="text-main-green" href="#"> ' +
    '<p name="name" style="margin-top:7px;"> ' + stdName + '</p> ' +
    '</a>' +
    '<p name="username">@' + stdUsername + '</p> ' +
    '</div> ' +
    '<div> ' +
    deleteButton +
    '</div> ' +
    '</div> ' +
    '</div>'
  );
}

function searchNode(
  id,
  image,
  name,
  username
) {

  return $(
    '<div id="srchstd' + id + '" class="media"> ' +
    '<div class="media"> ' +
    '<div class="media-left"> ' +
    '<img class="img-circle media-object" src="' + image + '" alt="Not Available" style="width:35px; height:35px;"/> ' +
    '</div> ' +
    '<div class="media-body"> ' +
    '<button class="btn btn-success pull-right" type="button" name="add_button"> ' +
    '<span class="fa fa-plus-circle"></span> Add ' +
    '</button> ' +
    '<span> ' +
    '<h5 class="media-heading" style="margin:0;"> ' + name + '</h5> ' +
    '<p>@' + username + '</p> ' +
    '</span> ' +
    '</div> ' +
    '</div> ' +
    '</div> '
  );
}

function spinnerSmall() {

  return $(
    '<img class="pull-right" src="pictures/modules/loading2.gif" style="width:40px;">'
  );
}

function spinnerSmall2() {

  return $(
    '<img src="pictures/modules/loading2.gif" style="width:40px;">'
  );
}