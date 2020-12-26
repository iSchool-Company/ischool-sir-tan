
function classroomNode(
  id,
  className,
  subjectName,
  teacherImage,
  teacherName,
  status,
  statusColor,
  count,
  dateCreated,
  endDate,
  timeRemaining
) {

  var negativeButton = myType === 'Student' ? (status === 'Pending' ? 'fa-remove' : 'fa-sign-out') : 'fa-trash';
  var negativeTooltip = myType === 'Student' ? (status === 'Pending' ? 'Cancel this request' : 'Leave this classroom') : 'Delete this Classroom';

  var teacherPart =
    '<p>' +
    '<img class="img-circle" name="teacher_image" src="' + teacherImage + '" alt="Not Available"> ' +
    '<a href="#" name="teacher_name"> ' +
    teacherName +
    '</a> ' +
    '</p>';

  return $(
    '<div id="cr' + id + '" class="col-xs-12 col-sm-6 col-md-6"> ' +
    '<div class="panel panel-default panel-gray"> ' +
    '<div class="panel-body panel-classroom"> ' +
    '<a class="btn btn-link" href="#" name="negative_button" style="float:right;">' +
    '<span class="fa ' + negativeButton + '" title="' + negativeTooltip + '" data-toggle="tooltip" data-placement="auto"></span>' +
    '</a> ' +
    '<p class="text-center" style="margin-top:10px;"> ' +
    '<a href="#" name="classroom_name">' + className + ' - ' + subjectName + '</a> ' +
    '</p> ' +
    (myType === 'Student' ? teacherPart : '') +
    '<p> ' +
    '<span class="fa fa-calendar text-main-green"></span> ' +
    '<span name="date_created">' + dateCreated + '</span> ' +
    '</p> ' +
    '<p> ' +
    '<span class="fa fa-hourglass-end text-main-green"></span> ' +
    '<span name="end_date">' + endDate + '</span> ' +
    '<br class="visible-xs"/> ' +
    '<small name="time_remaining">' + timeRemaining + '</small> ' +
    '</p> ' +
    '<p> ' +
    '<span class="hidden-xs">Status:</span> ' +
    '<span class="fa fa-circle" name="status_color" style="color:' + statusColor + ';"></span> ' +
    '<span name="status"">' + status + '</span> ' +
    '</p> ' +
    '<p name="num"> ' +
    '<span class="text-main-black" name="stdnum">' + count.std + '</span> ' +
    '<span class="fa fa-users" title="Students" data-toggle="tooltip"></span> &nbsp;&nbsp; ' +
    '<span class="text-main-black" name="annnum">' + count.ann + '</span> ' +
    '<span class="fa fa-bullhorn" title="Announcements" data-toggle="tooltip"></span> &nbsp;&nbsp; ' +
    '<span class="text-main-black" name="assnum">' + count.ass + '</span> ' +
    '<span class="fa fa-book" title="Assignments" data-toggle="tooltip"></span> &nbsp;&nbsp; ' +
    '<span class="text-main-black" name="qznum">' + count.qz + '</span> ' +
    '<span class="fa fa-list-ul" title="Quizzes" data-toggle="tooltip"></span> &nbsp;&nbsp; ' +
    '<span class="text-main-black" name="matnum">' + count.mat + '</span> ' +
    '<span class="fa fa-cloud-download" title="Materials" data-toggle="tooltip"></span> ' +
    '</p> ' +
    '</div> ' +
    '</div> ' +
    '</div>'
  );
}

function requestNode(
  csdId,
  crId,
  stdId,
  image,
  name,
  username,
  cName,
  sName
) {

  return $(
    '<div id="reqcr' + csdId + '" class="media"> ' +
    '<div class="media-left media-middle"> ' +
    '<img class="img-circle media-object" src=" ' + image + '" alt=" ' + username + ' " style="width:60px; height:60px;"/> ' +
    '</div> ' +
    '<div class="media-body"> ' +
    '<span class="pull-right"> ' +
    '<button class="btn btn-success" type="button" name="accept_button"> ' +
    '<span class="fa fa-check"></span> ' +
    '</button> ' +
    '<button class="btn btn-danger" type="button" name="decline_button"> ' +
    '<span class="fa fa-remove"></span> ' +
    '</button> ' +
    '<img src="pictures/modules/loading.gif" name="loading" style="width:20px; display:none;"> ' +
    '</span> ' +
    '<p name="student" value=" ' + stdId + ' "> ' + name + '</p> ' +
    '<p> ' + '@' + username + '</p> ' +
    '<p name="classroom" value=" ' + crId + ' "> ' + cName + ' - ' + sName + '</p> ' +
    '</div> ' +
    '<hr> ' +
    '</div>'
  );
}

function searchNode(
  id,
  image,
  name,
  cName,
  sName
) {

  return $(
    '<div id="srchcr' + id + '"> ' +
    '<div class="media"> ' +
    '<div class="media-left"> ' +
    '<img class="img-circle media-object" src="' + image + '" alt="' + name + '" style="width:35px; height:35px;"/> ' +
    '</div> ' +
    '<div class="media-body"> ' +
    '<button class="btn btn-success pull-right" name="join_button" type="button"> ' +
    '<span class="fa fa-sign-in"></span> Join' +
    '</button> ' +
    '<h5 class="media-heading">' + cName + ' - ' + sName + '</h5> ' +
    '<p> ' + name + '</p> ' +
    '</div> ' +
    '</div> ' +
    '<hr> ' +
    '</div>'
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