
var annFirstId = 0;
var annLastId = 0;

function isScrolledIntoView(elem) {

  var docViewTop = $(window).scrollTop();
  var docViewBottom = docViewTop + $(window).height();

  var elemTop = $(elem).offset().top;
  var elemBottom = elemTop + $(elem).height();

  return !(
    (
      (elemBottom > docViewTop) &&
      (elemTop > docViewTop) &&
      (elemBottom > docViewBottom) &&
      (elemTop > docViewBottom)
    )
    ||
    (
      (elemBottom < docViewTop) &&
      (elemTop < docViewTop) &&
      (elemBottom < docViewBottom) &&
      (elemTop < docViewBottom)
    )
  );
}

function announcementNode(
  id,
  content,
  teacherName,
  teacherImage,
  likeCount,
  commentCount,
  liked,
  dateTime,
  version
) {

  var crudButton =
    '<div id="manage_dropdown" class="dropdown"> ' +
    '<button class="btn btn-link dropdown-toggle text-main-green" type="button" data-toggle="dropdown"> ' +
    '<span class="fa fa-gear"></span> <span class="fa fa-chevron-down"></span> ' +
    '</button> ' +
    '<ul class="dropdown-menu dropdown-menu-right"> ' +
    '<li>' +
    '<a href="#edit_modal" data-toggle="modal" name="edit_button"> ' +
    '<span class="fa fa-pencil"></span> <span class="text-main-black">Edit</span> ' +
    '</a> ' +
    '</li> ' +
    '<li> ' +
    '<a href="#delete_modal" data-toggle="modal" name="anns_delete_button"> ' +
    '<span class="fa fa-trash text-main-red"></span> <span class="text-main-black">Delete</span> ' +
    '</a> ' +
    '</li> ' +
    '</ul> ' +
    '</div> ';

  return $(
    '<div id="anns' + id + '" class="panel panel-default panel-gray" value="' + version + '"> ' +
    '<div class="panel-body"> ' +
    (myType === 'Teacher' && crStatus === 'on_going' ? crudButton : '') +
    '<div class="media"> ' +
    '<div class="media-left text-center hidden-xs announcement-image"> ' +
    '<img name="teacher_image" class="img-circle" src=" ' + teacherImage + '" alt=""> ' +
    '</div> ' +
    '<div class="media-body announcement-content"> ' +
    '<div class="col-md-12 col-xs-12 announcement-content-text"> ' +
    '<h4 class="media-heading"><span name="teacher_name"> ' + teacherName + '</span> ' +
    '<br class="visible-xs hidden-md"/> ' +
    '<small><i name="ann_date_time"> ' + dateTime + '</i></small> ' +
    '</h4> ' +
    '<div name="ann_content"><p> ' + content + '</p></div> ' +
    '<a class="text-main-green" name="see_more" href="#">See more...</a> ' +
    '</div> ' +
    '<div class="col-md-12 col-xs-12"> ' +
    '<div class="btn-group"> ' +
    '<button class="btn btn-success ' + (liked ? ' active' : '') + ' btn-like-comment" type="button" name="ann_like_button"> ' +
    '<span class="fa fa-thumbs-up"></span> ' +
    ' Like ' +
    '<span class="badge" name="ann_like"> ' + likeCount + '</span> ' +
    '</button> ' +
    '<button class="btn btn-success btn-like-comment" type="button" name="ann_comment_button" data-toggle="collapse" data-target="#com' + id + '"> ' +
    '<span class="fa fa-comments"></span> ' +
    ' Comment ' +
    '<span class="badge" name="comment"> ' + commentCount + '</span> ' +
    '</button> ' +
    '</div> ' +
    '<br/><br/> ' +
    '</div> ' +
    '<div class="col-md-12 col-xs-12"> ' +
    '<div id="com' + id + '" class="collapse"> ' +
    '<form id="com_form ' + id + '"> ' +
    '<div class="form-group row"> ' +
    '<div class="col-md-6 col-xs-12"> ' +
    '<div class="input-group"> ' +
    '<input class="form-control" type="text" name="comment_input" placeholder="Enter reaction here..." autocomplete="off"> ' +
    '<span class="input-group-btn"> ' +
    '<button class="btn btn-success btn-like-comment" type="submit" name="comment_button"> ' +
    '<span class="fa fa-send"></span> ' +
    '</button> ' +
    '</span> ' +
    '</div> ' +
    '</div> ' +
    '</div> ' +
    '</form> ' +
    '<div name="comment_section"> ' +
    '</div> ' +
    '</div> ' +
    '</div> ' +
    '</div> ' +
    '</div> ' +
    '</div> ' +
    '</div> '
  );
}

function commentNode(id, name, image, content, likeCount, replyCount, liked, dateTime, version, isOwner) {

  var deleteButton =
    '<a href="#delete_modal" name="coms_delete_button" data-toggle="modal"> ' +
    '<span class="fa fa-trash text-main-green" title="Delete" data-toggle="tooltip" data-placement="auto"></span>' +
    '</a>';

  return $(
    '<div id="coms' + id + '" class="media" value=" ' + version + '"> ' +
    '<div class="media-left hidden-xs"> ' +
    '<img name="com_image" class="img-circle media-object" src=" ' + image + '" alt=""> ' +
    '</div> ' +
    '<div class="media-body"> ' +
    '<h5 class="media-heading"> ' +
    '<b name="com_name"> ' + name + '</b> <br class="visible-xs hidden-md"/><small><i name="com_date_time"> ' + dateTime + '</i></small> ' +
    '</h5> ' +
    '<small name="com_content"> ' + content + '</small> ' +
    '<br/> ' +
    '<span class="badge" name="com_like"> ' + likeCount + '</span> ' +
    '<a href="#" name="com_like_button"> ' +
    '<span class="fa fa-thumbs-o-up text-main-green" title="Like" data-toggle="tooltip" data-placement="auto"></span>' +
    '</a>&nbsp;&nbsp;&nbsp; ' +
    '<span class="badge" name="reply"> ' + replyCount + '</span> ' +
    '<a href="#ann_rep' + id + '" data-toggle="collapse"> ' +
    '<span class="fa fa-reply text-main-green" title="Reply" data-toggle="tooltip" data-placement="auto"></span>' +
    '</a>&nbsp;&nbsp;&nbsp; ' +
    (isOwner ? deleteButton : '') +
    '<div id="ann_rep' + id + '" class="collapse"> ' +
    '<form id="rep_form' + id + '"> ' +
    '<div class="form-group row"> ' +
    '<div class="col-md-6 col-xs-12"> ' +
    '<div class="input-group"> ' +
    '<input class="form-control" type="text" name="reply_input" placeholder="Enter response here..." autocomplete="off">' +
    '<span class="input-group-btn"> ' +
    '<button class="btn btn-success btn-like-comment" type="submit" name="reply_button"> ' +
    '<span class="fa fa-send"></span> ' +
    '</button> ' +
    '</span> ' +
    '</div> ' +
    '</div> ' +
    '</div> ' +
    '</form> ' +
    '<div name="reply_section"> ' +
    '</div> ' +
    '</div> ' +
    '</div> ' +
    '</div>'
  );
}

function replyNode(id, name, image, content, likeCount, liked, dateTime, version, isOwner) {

  var deleteButton =
    '<a href="#delete_modal" name="reps_delete_button" data-toggle="modal"> ' +
    '<span class="fa fa-trash text-main-green" title="Delete" data-toggle="tooltip" data-placement="auto"></span>' +
    '</a>';

  return $(
    '<div id="reps' + id + '" class="media" value="' + version + '"> ' +
    '<div class="media-left hidden-xs"> ' +
    '<img name="rep_image" class="img-circle media-object" src="' + image + '" alt=""> ' +
    '</div> ' +
    '<div class="media-body"> ' +
    '<h5 class="media-heading"> ' +
    '<b name="rep_name">' + name + '</b> <br class="visible-xs hidden-md"/><small><i name="rep_date_time">' + dateTime + '</i></small> ' +
    '</h5> ' +
    '<small name="rep_content">' + content + '</small> ' +
    '<br/> ' +
    '<span class="badge" name="rep_like">' + likeCount + '</span> ' +
    '<a href="#" name="rep_like_button"> ' +
    '<span class="fa fa-thumbs-o-up text-main-green" title="Like" data-toggle="tooltip" data-placement="auto"></span>' +
    '</a>&nbsp;&nbsp;&nbsp; ' +
    (isOwner ? deleteButton : '') +
    '</div> ' +
    '</div> '
  );
}

function retrieveAnnouncements(way, refId) {

  $.ajax({
    url: 'database/announcement/retrieve/announcements.php',
    data: {
      method: way,
      user_id: myId,
      classroom_id: classroomId,
      ref_id: refId
    },
    success: function (data, status) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'found') {

        var announcements = responseJSON.announcements;

        if (annFirstId == 0) {
          annFirstId = announcements[0].id;
        }

        showAnnouncements(way, announcements);
      } else if (way == 'later') {
        $('#load_more_button').text('You\'ve reached the oldest announcement!');
      } else if (way == 'fresh') {
        $('#load_more_button').remove();
      }
    }
  });
}

function showAnnouncements(way, announcements) {

  var annLength = announcements.length;

  if (way != 'newer' && annLength < 5) {
    $('#load_more_button').text('You\'ve reached the oldest announcement!');
  }

  for (var i = 0; i < annLength; i++) {

    var announcementNodeTemp = announcementNode(
      announcements[i].id,
      announcements[i].content,
      announcements[i].teacherName,
      announcements[i].teacherImage,
      announcements[i].likeCount,
      announcements[i].commentCount,
      announcements[i].liked,
      announcements[i].dateTime,
      announcements[i].version,
      announcements[i].isOwner
    );

    if (crStatus === 'archived') {
      announcementNodeTemp.find('[name="ann_like_button"]').attr('disabled', true);
      announcementNodeTemp.find('[name="comment_input"]').attr('disabled', true);
      announcementNodeTemp.find('[name="comment_button"]').attr('disabled', true);
    }

    var comments = announcements[i].comments;
    var comLength = comments.length;

    for (var j = 0; j < comLength; j++) {

      var commentNodeTemp = commentNode(
        comments[j].id,
        comments[j].name,
        comments[j].image,
        comments[j].content,
        comments[j].likeCount,
        comments[j].replyCount,
        comments[j].liked,
        comments[j].dateTime,
        comments[j].version,
        comments[j].isOwner
      );

      if (crStatus === 'archived') {
        commentNodeTemp.find('[name="com_like_button"]').attr('name', '');
        commentNodeTemp.find('[name="reply_input"]').attr('disabled', true);
        commentNodeTemp.find('[name="reply_button"]').attr('disabled', true);
        commentNodeTemp.find('[name="coms_delete_button"]').remove();
      }

      announcementNodeTemp.find('[name="comment_section"]').append(commentNodeTemp);

      var replies = comments[j].replies;
      var repLength = replies.length;

      for (var k = 0; k < repLength; k++) {

        var replyNodeTemp = replyNode(
          replies[k].id,
          replies[k].name,
          replies[k].image,
          replies[k].content,
          replies[k].likeCount,
          replies[k].liked,
          replies[k].dateTime,
          replies[k].version,
          replies[k].isOwner
        );

        if (crStatus === 'archived') {
          replyNodeTemp.find('[name="rep_like_button"]').attr('name', '');
          replyNodeTemp.find('[name="reps_delete_button"]').remove();
        }

        commentNodeTemp.find('[name="reply_section"]').append(replyNodeTemp);
      }
    }

    if (way === 'newer') {

      $('#announcement_panel').prepend(announcementNodeTemp);

      $('#anns' + announcements[i].id).hide();
      $('#anns' + announcements[i].id).slideDown(400);

      annFirstId = announcements[i].id;
    } else {

      $('#announcement_panel').append(announcementNodeTemp);

      $('#anns' + announcements[i].id).hide();
      $('#anns' + announcements[i].id).slideDown(400);

      annLastId = announcements[i].id;
    }

    $('[data-toggle="tooltip"]').tooltip();
  }
}

function announcementUpdater() {

  $('[id^="anns"]').each(function () {

    var rootDOM = $(this);

    if (isScrolledIntoView(rootDOM)) {

      var id = rootDOM.attr('id').substr(4);
      var commentId = rootDOM.find('[name="comment_section"] > [id^="coms"]').last().length == 0 ? 0 : rootDOM.find('[name="comment_section"] > [id^="coms"]').last().attr('id').substr(4);
      var version = rootDOM.attr('value');

      retrieveAnnouncement(id, commentId, version);
    }
  });
}

function commentUpdater() {

  $('[id^="coms"]').each(function () {

    var rootDOM = $(this);
    var parentDOM = rootDOM.parents('.collapse').first();

    if (isScrolledIntoView(rootDOM) && parentDOM.hasClass('in')) {

      var id = rootDOM.attr('id').substr(4);
      var replyId = rootDOM.find('[name="reply_section"] > [id^="reps"]').last().length == 0 ? 0 : rootDOM.find('[name="reply_section"] > [id^="reps"]').last().attr('id').substr(4);
      var version = rootDOM.attr('value');

      retrieveComment(id, replyId, version);
    }
  });
}

function replyUpdater() {

  $('[id^="reps"]').each(function () {

    var rootDOM = $(this);
    var parentDOM = rootDOM.parents('.collapse').first();

    if (isScrolledIntoView(rootDOM) && parentDOM.hasClass('in')) {

      var id = rootDOM.attr('id').substr(4);
      var version = rootDOM.attr('value');

      retrieveReply(id, version);
    }
  });
}

function retrieveAnnouncement(id, commentId, version) {

  $.ajax({
    url: 'database/announcement/retrieve/announcement.php',
    data: {
      user_id: myId,
      announcement_id: id,
      comment_ref_id: commentId,
      version: version
    },
    success: function (data, status) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'found' || response === 'same') {

        var info = responseJSON.info;

        updateAnnouncement(info);
      } else if (response === 'nothing') {

        $('#anns' + id).fadeOut(1000);

        setTimeout(function () {
          $('#anns' + id).remove();
        }, 900);
      }
    }
  });
}

function retrieveComment(id, replyId, version) {

  $.ajax({
    url: 'database/comment/retrieve/display.php',
    data: {
      user_id: myId,
      comment_id: id,
      reply_ref_id: replyId,
      version: version
    },
    success: function (data, status) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'found' || response === 'same') {

        var info = responseJSON.info;

        updateComment(info);
      } else if (response === 'nothing') {

        $('#coms' + id).fadeOut(1000);

        setTimeout(function () {
          $('#coms' + id).remove();
        }, 900);
      }
    }
  });
}

function retrieveReply(id, version) {

  $.ajax({
    url: 'database/reply/retrieve/display.php',
    data: {
      user_id: myId,
      reply_id: id,
      version: version
    },
    success: function (data, status) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'found' || response === 'same') {

        var info = responseJSON.info;

        updateReply(info);
      } else if (response === 'nothing') {

        $('#reps' + id).fadeOut(1000);

        setTimeout(function () {
          $('#reps' + id).remove();
        }, 900);
      }
    }
  });
}

function updateAnnouncement(info) {

  var rootDOM = $('#anns' + info.id);
  var teacherImage = rootDOM.find('[name="teacher_image"]');
  var teacherName = rootDOM.find('[name="teacher_name"]');
  var content = rootDOM.find('[name="ann_content"]');
  var dateTime = rootDOM.find('[name="ann_date_time"]');
  var likeCount = rootDOM.find('[name="ann_like"]');
  var commentCount = rootDOM.find('[name="comment"]');

  if (likeCount.text() != info.likeCount) {
    likeCount.text(info.likeCount);
  }

  if (commentCount.text() != info.commentCount) {
    commentCount.text(info.commentCount);
  }

  if (info.liked && !likeCount.parent().hasClass('active')) {
    likeCount.parent().addClass('active');
  }

  if (!info.liked && likeCount.parent().hasClass('active')) {
    likeCount.parent().removeClass('active');
  }

  if (info.content != content.text()) {
    content.text(info.content);
  }

  var comments = info.comments;
  var length = comments.length;

  for (var i = 0; i < length; i++) {

    if (rootDOM.find('#coms' + comments[i].id).length === 0) {

      var commentNodeTemp = commentNode(
        comments[i].id,
        comments[i].name,
        comments[i].image,
        comments[i].content,
        comments[i].likeCount,
        comments[i].replyCount,
        comments[i].liked,
        comments[i].dateTime,
        comments[i].version,
        comments[i].isOwner
      );

      if (crStatus === 'archived') {
        commentNodeTemp.find('[name="com_like_button"]').attr('name', '');
        commentNodeTemp.find('[name="reply_input"]').attr('disabled', true);
        commentNodeTemp.find('[name="reply_button"]').attr('disabled', true);
        commentNodeTemp.find('[name="coms_delete_button"]').remove();
      }

      rootDOM.find('[name="comment_section"]').append(commentNodeTemp);
      $('[data-toggle="tooltip"]').tooltip();

      $('#coms' + comments[i].id).hide();
      $('#coms' + comments[i].id).slideDown(200);
    }
  }

  rootDOM.attr('value', info.version);
}

function updateComment(info) {

  var rootDOM = $('#coms' + info.id);
  var image = rootDOM.find('[name="com_image"]');
  var name = rootDOM.find('[name="com_name"]');
  var content = rootDOM.find('[name="com_content"]');
  var dateTime = rootDOM.find('[name="com_date_time"]');
  var likeCount = rootDOM.find('[name="com_like"]');
  var replyCount = rootDOM.find('[name="reply"]');

  if (likeCount.text() != info.likeCount) {
    likeCount.text(info.likeCount);
  }

  if (replyCount.text() != info.replyCount) {
    replyCount.text(info.replyCount);
  }

  if (info.liked && !likeCount.next().find('.fa').hasClass('fa-thumbs-up')) {
    likeCount.next().find('.fa').removeClass('fa-thumbs-o-up');
    likeCount.next().find('.fa').addClass('fa-thumbs-up');
  }

  if (!info.liked && !likeCount.next().find('.fa').hasClass('fa-thumbs-o-up')) {
    likeCount.next().find('.fa').removeClass('fa-thumbs-up');
    likeCount.next().find('.fa').addClass('fa-thumbs-o-up');
  }

  var replies = info.replies;
  var length = replies.length;

  for (var i = 0; i < length; i++) {

    if (rootDOM.find('#reps' + replies[i].id).length === 0) {

      var replyNodeTemp = replyNode(
        replies[i].id,
        replies[i].name,
        replies[i].image,
        replies[i].content,
        replies[i].likeCount,
        replies[i].liked,
        replies[i].dateTime,
        replies[i].version,
        replies[i].isOwner
      );

      if (crStatus === 'archived') {
        replyNodeTemp.find('[name="rep_like_button"]').attr('name', '');
        replyNodeTemp.find('[name="reps_delete_button"]').remove();
      }

      rootDOM.find('[name="reply_section"]').append(replyNodeTemp);
      $('[data-toggle="tooltip"]').tooltip();

      $('#reps' + replies[i].id).hide();
      $('#reps' + replies[i].id).slideDown(200);
    }
  }

  rootDOM.attr('value', info.version);
}

function updateReply(info) {

  var rootDOM = $('#reps' + info.id);
  var image = rootDOM.find('[name="rep_image"]');
  var name = rootDOM.find('[name="rep_name"]');
  var content = rootDOM.find('[name="rep_content"]');
  var dateTime = rootDOM.find('[name="rep_date_time"]');
  var likeCount = rootDOM.find('[name="rep_like"]');

  if (likeCount.text() != info.likeCount) {
    likeCount.text(info.likeCount);
  }

  if (info.liked && !likeCount.parent().hasClass('active')) {
    likeCount.parent().addClass('active');
  }

  if (!info.liked && likeCount.parent().hasClass('active')) {
    likeCount.parent().removeClass('active');
  }

  if (info.content != content.text()) {
    content.text(info.content);
  }

  rootDOM.attr('value', info.version);
}

$(document).ready(function () {

  retrieveAnnouncements('fresh', 0);
  setInterval(function () { retrieveAnnouncements('newer', annFirstId) }, 3000);
  setInterval(announcementUpdater, 500);
  setInterval(commentUpdater, 500);
  setInterval(replyUpdater, 500);

  $('#load_more_button').click(function () {

    retrieveAnnouncements('later', annLastId)
  });
});

$(document).on('click', '[href="#"]', function (e) {
  e.preventDefault();
});