
function searchGcCrNode(
  id,
  name,
  count
) {

  return $(
    '<a id="gcsrchcr' + id + '" href="#" style="text-decoration:none;color:#3b5998;"> ' +
    '<div class="media search-result" style="margin: 5px 20px;"> ' +
    '<div class="media-body"> ' +
    '<h4 class="media-heading text-main-black" name="name">' + name + '</h4> ' +
    '<p class="text-main-black">' + count + ' students</p> ' +
    '</div> ' +
    '</div> ' +
    '</a>'
  );
}

function searchGcStdNode(
  id,
  name,
  image,
  username
) {

  return $(
    '<a id="gcsrchstd' + id + '" href="#" style="text-decoration:none;color:#3b5998;"> ' +
    '<div class="media search-result" style="margin: 5px 20px;"> ' +
    '<div class="media-left"> ' +
    '<img class="img-circle media-object" src="' + image + '" alt="' + username + '" style="width:35px; height:35px;"/> ' +
    '</div> ' +
    '<div class="media-body"> ' +
    '<h5 class="media-heading text-main-black" name="name">' + name + '</h5> ' +
    '<p class="text-main-black" name="username">@' + username + '</p> ' +
    '</div> ' +
    '</div> ' +
    '</a>'
  );
}

function memCrNode(
  id,
  name
) {

  return $(
    '<div class="alert alert-success" name="gcmemcr" value="' + id + '" style="padding:5px;margin-bottom:5px;"> ' +
    '<b> ' +
    '<span name="name" class="text-main-black">' + name + '</span> ' +
    '<a href="#" class="close" name="close"> ' +
    '&times; ' +
    '</a> ' +
    '<a href="#" name="hide"> ' +
    '<span class="fa fa-chevron-down text-main-green"></span> ' +
    '</a> ' +
    '</b> ' +
    '<div name="mem" style="display:none;"> ' +
    '</div> ' +
    '</div> '
  );
}

function memCrStdNode(
  id,
  name,
  image
) {

  return $(
    '<div name="gcmemcrstd" style="padding:5px;" value="' + id + '"> ' +
    '<input type="checkbox" checked> ' +
    '<span style="padding-bottom:7px;"> ' +
    '<img class="img-circle" src="' + image + '" style="width:20px;height:20px;"> ' +
    '<span class="text-main-black">' + name + '</span> ' +
    '</span> ' +
    '</div> '
  );
}

function memStdNode(
  id,
  name,
  image
) {

  return $(
    '<div class="alert alert-success" name="gcmemstd" value="' + id + '" style="padding:5px;margin-bottom:5px;"> ' +
    '<b> ' +
    '<img class="img-circle" src="' + image + '" style="width:20px;height:20px;"> ' +
    '<span class="text-main-black">' + name + '</span> ' +
    '<a href="#" class="close" name="close"> ' +
    '&times; ' +
    '</a> ' +
    '</b> ' +
    '</div> '
  );
}

function memberNode(
  id,
  name,
  image
) {

  return $(
    '<div class="alert alert-success" name="mmbr" value="' + id + '" style="padding:5px;margin-bottom:5px;"> ' +
    '<b> ' +
    '<img class="img-circle" src="' + image + '" style="width:20px;height:20px;"> ' +
    '<span class="text-main-black">' + name + '</span> ' +
    '<a href="#" class="close" name="remove_button"> ' +
    '&times; ' +
    '</a> ' +
    '</b> ' +
    '</div> '
  );
}

function memberSearchNode(
  id,
  name,
  image,
  username
) {

  return $(
    '<div id="srcmmbr' + id + '" class="media" style="margin:10px 10px 0 10px;"> ' +
    '<div class="media-left"> ' +
    '<img class="img-circle media-object" src="' + image + '" alt="Not Available" style="width:35px; height:35px;"/> ' +
    '</div> ' +
    '<div class="media-body"> ' +
    '<button class="btn btn-success pull-right" type="button" name="add_button"> ' +
    '<span class="fa fa-plus-circle"></span> Add ' +
    '</button> ' +
    '<span> ' +
    '<h5 class="media-heading">' + name + '</h5> ' +
    '<p>@' + username + '</p> ' +
    '</span> ' +
    '</div> ' +
    '</div> '
  );
}

function gcNode(
  id,
  image,
  who,
  name,
  content,
  dateTime,
  seen
) {

  return $(
    '<div id="gcht' + id + '" class="panel panel-default panel-gray"> ' +
    '<div class="panel-body" style="position: relative;"> ' +
    '<div class="media"> ' +
    '<div class="media-left media-middle"> ' +
    '<img class="img-circle inbox-img" src="' + image + '" alt="Not Available" style="width:60px;height:60px;"/> ' +
    '</div> ' +
    '<div class="media-body"> ' +
    '<h4> ' +
    '<span class="inbox-name"> ' + name + '</span> ' +
    '<br class="visible-xs"> ' +
    '<small><i name="date_time"> ' + dateTime + '</i></small> ' +
    '<span class="label label-success" name="new" style="display:' + (seen ? 'none' : '') + ';">' +
    '<span class="fa fa-user"></span> ' +
    '<span>Unread</span> ' +
    '</span> ' +
    '</h4> ' +
    '<p> ' +
    '<b name="who"> ' + who + '</b>: ' +
    '<span name="content"> ' + content + '</span> ' +
    '</p> ' +
    '</div> ' +
    '</div> ' +
    '<hr/> ' +
    '<div> ' +
    '<button class="btn btn-link text-main-green" type="button" name="open_button" style="text-decoration:none;"> ' +
    '<span class="fa fa-folder-open"></span><b class="text-main-black"> Open</b> ' +
    '</button> ' +
    '<button class="btn btn-link text-main-red" type="button" name="delete_button" data-toggle="modal" data-target="#delete_gc_modal" style="text-decoration:none;display:none;"> ' +
    '<span class="fa fa-trash"></span><b class="text-main-black"> Delete</b> ' +
    '</button> ' +
    '</div> ' +
    '</div> ' +
    '</div>'
  );
}