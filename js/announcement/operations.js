
var deletePart = '';
var deleteId = 0;
var editId = 0;

function addAnnouncement(content) {

  $.ajax({
    method: 'POST',
    url: 'database/announcement/add.php',
    data: {
      user_id: myId,
      classroom_id: classroomId,
      content: content
    },
    success: function (data, status) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'successful') {

        $('#announcement_form [name="post_textarea"]').val('');
      }
    }
  });
}

function makeLike(id) {

  $.ajax({
    method: 'POST',
    url: 'database/announcement/like.php',
    data: {
      announcement_id: id,
      user_id: myId,
      classroom_id: classroomId
    }
  });
}

function makeComment(id, content) {

  $.ajax({
    method: 'POST',
    url: 'database/comment/make.php',
    data: {
      announcement_id: id,
      user_id: myId,
      content: content,
      classroom_id: classroomId
    }
  });
}

function makeCommentLike(id) {

  $.ajax({
    method: 'POST',
    url: 'database/comment/like.php',
    data: {
      comment_id: id,
      user_id: myId,
      classroom_id: classroomId
    }
  });
}

function makeReply(id, content) {

  $.ajax({
    method: 'POST',
    url: 'database/reply/make.php',
    data: {
      comment_id: id,
      user_id: myId,
      content: content,
      classroom_id: classroomId
    }
  });
}

function makeReplyLike(id) {

  $.ajax({
    method: 'POST',
    url: 'database/reply/like.php',
    data: {
      reply_id: id,
      user_id: myId,
      classroom_id: classroomId
    }
  });
}

function deleteSomething() {

  var url = '';
  var data = {};

  switch (deletePart) {

    case 'announcement':
      url = 'database/announcement/delete.php';
      data = {
        user_id: myId,
        classroom_id: classroomId,
        user_id: myId,
        announcement_id: deleteId
      };
      break;

    case 'comment':
      url = 'database/comment/delete.php';
      data = {
        user_id: myId,
        classroom_id: classroomId,
        user_id: myId,
        comment_id: deleteId
      };
      break;

    case 'reply':
      url = 'database/reply/delete.php';
      data = {
        user_id: myId,
        classroom_id: classroomId,
        user_id: myId,
        reply_id: deleteId
      };
      break;
  }

  $.ajax({
    method: 'POST',
    url: url,
    data: data
  });
}

function updateSomething(content) {

  $.ajax({
    method: 'POST',
    url: 'database/announcement/update.php',
    data: {
      user_id: myId,
      classroom_id: classroomId,
      announcement_id: editId,
      content: content
    }
  });
}

$(document).ready(function () {

  $('#announcement_form').submit(function (e) {

    e.preventDefault();

    var postTextArea = $('#announcement_form [name="post_textarea"]');
    var content = postTextArea.val();

    if (content !== '') {

      addAnnouncement(content);
    }
  });

  $('#announcement_form [name="post_textarea"]').keyup(function () {

    var value = $(this).val();

    if (value === '') {
      $('#announcement_form [name="cancel_button"]').fadeOut(500);
    } else {
      $('#announcement_form [name="cancel_button"]').fadeIn(500);
    }
  });

  $('#announcement_form [name="cancel_button"]').click(function () {

    var postTextArea = $('#announcement_form [name="post_textarea"]');
    $('#announcement_form [name="cancel_button"]').fadeOut(500);
    clearResult(postTextArea);
  });

  $('#delete_modal [name="confirm_button"]').click(function () {
    deleteSomething();
  });

  $('#edit_modal').on('hidden.bs.modal', function () {
    $('#edit_form [name="announcement_content"]').val('');
  });

  $('#edit_modal [name="save_button"]').click(function () {
    updateSomething($('#edit_form [name="announcement_content"]').val());
  });
});

$(document).on('click', '[name="see_more"]', function () {

  var rootDOM = $(this);

  rootDOM.siblings('div').css('max-height', 'none');
  rootDOM.remove();
});

$(document).on('click', '[name="ann_like_button"]', function () {

  var rootDOM = $(this).parents('[id^="anns"]');
  var announcementId = rootDOM.attr('id').substr(4);

  makeLike(announcementId);

  if (!$(this).hasClass('active')) {
    $(this).addClass('active');
  } else {
    $(this).removeClass('active');
  }
});

$(document).on('click', '[name="com_like_button"]', function () {

  var rootDOM = $(this).parents('[id^="coms"]');
  var commentId = rootDOM.attr('id').substr(4);

  makeCommentLike(commentId);

  $(this).find('.fa').toggleClass('fa-thumbs-up');
  $(this).find('.fa').toggleClass('fa-thumbs-o-up');
});

$(document).on('click', '[name="rep_like_button"]', function () {

  var rootDOM = $(this).parents('[id^="reps"]');
  var replyId = rootDOM.attr('id').substr(4);

  makeReplyLike(replyId);

  $(this).find('.fa').toggleClass('fa-thumbs-up');
  $(this).find('.fa').toggleClass('fa-thumbs-o-up');
});

$(document).on('click', '[name="anns_delete_button"]', function () {

  var rootDOM = $(this).parents('[id^="anns"]');
  var announcementId = rootDOM.attr('id').substr(4);

  deleteId = announcementId;
  deletePart = 'announcement';

  $('#delete_modal [name="delete_message"]').text('Are you sure you want to delete this announcement?');
});

$(document).on('click', '[name="coms_delete_button"]', function () {

  var rootDOM = $(this).parents('[id^="coms"]');
  var commentId = rootDOM.attr('id').substr(4);

  deleteId = commentId;
  deletePart = 'comment';

  $('#delete_modal [name="delete_message"]').text('Are you sure you want to delete this comment?');
});

$(document).on('click', '[name="reps_delete_button"]', function () {

  var rootDOM = $(this).parents('[id^="reps"]');
  var replyId = rootDOM.attr('id').substr(4);

  deleteId = replyId;
  deletePart = 'reply';

  $('#delete_modal [name="delete_message"]').text('Are you sure you want to delete this reply?');
});

$(document).on('click', '[id^="anns"] [name="edit_button"]', function () {

  var rootDOM = $(this).parents('[id^="anns"]');
  var id = rootDOM.attr('id').substr(4);
  var content = rootDOM.find('[name="ann_content"]').text();

  $('#edit_form [name="announcement_content"]').val(content);

  editId = id;
});

$(document).on('submit', '[id^="com_form"]', function (e) {

  e.preventDefault();

  var rootDOM = $(this).parents('[id^="anns"]');
  var announcementId = rootDOM.attr('id').substr(4);
  var content = rootDOM.find('[name="comment_input"]').val();

  if (content !== '') {
    makeComment(announcementId, content);
    rootDOM.find('[name="comment_input"]').val('');
  }
});

$(document).on('submit', '[id^="rep_form"]', function (e) {

  e.preventDefault();

  var rootDOM = $(this);
  var commentId = rootDOM.attr('id').substr(8);
  var content = rootDOM.find('[name="reply_input"]').val();

  if (content !== '') {
    makeReply(commentId, content);
    rootDOM.find('[name="reply_input"]').val('');
  }
});