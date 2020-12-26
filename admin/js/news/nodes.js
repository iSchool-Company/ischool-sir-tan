
function newsNode(
  id,
  image,
  title,
  dateTime,
  admin,
  content
) {

  return $(
    '<div id="nws' + id + '" class="panel panel-default"> ' +
    '<div class="panel-body"> ' +
    '<div class="pull-right"> ' +
    '<a href="#edit_modal" data-toggle="modal" style="text-decoration:none; margin-right:15px; display:none;"> ' +
    '<span class="fa fa-pencil text-main-green" title="Edit" data-toggle="tooltip" data-placement="auto" style="font-size:18px;"></span> ' +
    '</a> ' +
    '<a href="#delete_modal" data-toggle="modal" style="text-decoration:none;"> ' +
    '<span class="fa fa-trash text-main-red" title="Delete" data-toggle="tooltip" data-placement="auto" style="font-size:18px;"></span> ' +
    '</a> ' +
    '</div> ' +
    '<div class="media" style="margin-top:0;"> ' +
    '<div class="media-left"> ' +
    '<img class="img-rounded media-object" name="image" src="' + image + '" alt="Not Available" width="85px" height="85px"/> ' +
    '</div> ' +
    '<div class="media-body"> ' +
    '<div class="col-md-2"> ' +
    '<p class="media-heading"><b>Title:</b></p> ' +
    '</div> ' +
    '<div class="col-md-10"> ' +
    '<p name="title">' + title + '</p> ' +
    '</div> ' +
    '<div class="col-md-2"> ' +
    '<p class="media-heading"><b>Date Posted:</b></p> ' +
    '</div> ' +
    '<div class="col-md-10"> ' +
    '<p name="date_time">' + dateTime + '</p> ' +
    '</div> ' +
    '<div class="col-md-2"> ' +
    '<p class="media-heading"><b>Posted by:</b></p> ' +
    '</div> ' +
    '<div class="col-md-10"> ' +
    '<p name="admin">' + admin + '</p> ' +
    '</div> ' +
    '<div class="col-md-2"> ' +
    '<p class="media-heading"><b>Content:</b></p> ' +
    '</div> ' +
    '<div class="col-md-10"> ' +
    '<p name="content">' + content + ' <a href="#">Read full story...</a></p> ' +
    '</div> ' +
    '</div> ' +
    '</div> ' +
    '</div> ' +
    '</div> '
  );
}