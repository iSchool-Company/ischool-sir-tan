
function newsNode(
  id,
  image,
  title,
  caption,
  dateTime
) {

  return $(
    '<div id="nw' + id + '" class="panel panel-default panel-gray"> ' +
    '<div class="panel-body"> ' +
    '<div class="media"> ' +
    '<div class="media-left"> ' +
    '<img class="media-object img-rounded" name="image" src="' + image + '" alt="' + title + '" style="width:100px;"> ' +
    '</div> ' +
    '<div class="media-body"> ' +
    '<h4 class="media-heading"> ' +
    '<span name="title">' + title + '</span> ' +
    '<br class="visible-xs"/> ' +
    '<small><i name="date_time">' + dateTime + '</i></small> ' +
    '</h4> ' +
    '<p name="content">' + caption + '</p> ' +
    '<a class="text-main-green" href="#" name="read_more">Read more...</a> ' +
    '</div> ' +
    '</div> ' +
    '</div> ' +
    '</div>'
  );
}