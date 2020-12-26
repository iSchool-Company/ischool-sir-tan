
function notifNode(
  id,
  crId,
  srcId,
  code,
  fa,
  message,
  dateTime,
  seen
) {

  return $(
    '<div id="ntf' + id + '" class="row" value="' + srcId + '" style="margin:2px 0; border-radius:4px; background-color:' + (seen == 1 ? '' : '#dfe3ee') + ';"> ' +
    '<div class="col-md-12" value="' + code + '">' +
    '<a class="notif-content" href="#" value="' + crId + '">' +
    '<p>' +
    '<span class="fa ' + fa + ' text-main-green"></span> <span>' + message + '</span>' +
    '<br/>' +
    '<small class="text-muted">' +
    '<i>' + dateTime + '</i>' +
    '</small>' +
    '</p>' +
    '</a>' +
    '</div>' +
    '</div>' +
    '<hr/>'
  );
}