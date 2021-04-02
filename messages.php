<!DOCTYPE html>
<?php
session_start();
?>
<html>

<head>

  <title>LMS | Messages</title>

  <?php
  require 'meta.php';
  ?>

  <style>
    .btn-link:hover,
    .btn-link:focus {
      background-color: #dfe3ee;
      border-radius: 25px;
    }

    .btn-link>span {
      font-size: 20px;
    }

    #inbox_empty_panel {
      display: none;
    }

    #gc_empty_panel {
      display: none;
    }

    #inbox_empty_panel>h4 {
      margin: 20px 10px;
    }

    #inbox_loading_panel {
      display: none;
      margin-bottom: 5px;
    }

    #inbox_loading_panel>img {
      width: 20px;
    }

    #new_message_modal .modal-body {
      max-height: 390px;
      overflow: auto;
    }

    #gc_convo_modal .modal-body {
      max-height: 390px;
      overflow: auto;
    }

    .search-result:hover {
      background-color: #dcdcdc;
      border-radius: 8px;
      color: #000000;
    }

    .message-sender-content {
      margin: 5px 0;
      white-space: pre-line;
      position: relative;
    }

    .message-sender-content>div {
      color: #000000;
      border-radius: 25px;
      display: inline-block;
      padding: 7px 12px;
      background-color: #dcdcdc;
      font-size: 12px;
      position: relative;
      top: 0;
      left: 0;
      word-wrap: break-word;
    }

    .message-receiver-content {
      margin: 5px 0;
      white-space: pre-line;
    }

    .message-receiver-content>div {
      color: #f7f7f7;
      border-radius: 25px;
      display: inline-block;
      padding: 7px 12px;
      background-color: rgba(0, 143, 149, 0.6);
      font-size: 12px;
      word-wrap: break-word;
    }

    #new_message_search_main>.form-group {
      margin-top: 5px;
      margin-bottom: 0;
    }

    #new_message_heading {
      margin-top: 0;
      margin-bottom: 0;
    }

    #sender_image {
      width: 45px;
      height: 45px;
    }

    #new_message_search_panel {
      width: 100%;
      display: none;
      max-height: 500px;
      overflow: auto;
      position: absolute;
      z-index: 10;
      padding: 0;
      margin: 0;
    }

    #new_gc_search_panel {
      width: 100%;
      display: none;
      max-height: 200px;
      overflow: auto;
      position: relative;
      z-index: 10;
      padding: 0;
      margin: 0;
    }

    #member_search_panel {
      width: 100%;
      display: none;
      max-height: 200px;
      overflow: auto;
      position: relative;
      z-index: 10;
      padding: 0;
      margin: 0;
    }

    #new_message_search_panel>div {
      padding: 5px;
    }

    #new_gc_search_panel>div {
      padding: 5px;
    }

    #member_search_panel>div {
      padding: 5px;
    }

    #new_message_prompt {
      margin: 0;
    }

    #new_gc_prompt {
      margin: 0;
    }

    #member_search_prompt {
      margin: 0;
    }

    #gc_convo_modal .dropdown .btn {
      padding: 0 20px 0 35px;
    }

    #gc_convo_modal .dropdown .btn-link:hover,
    #gc_convo_modal .dropdown .btn-link:focus {
      background-color: transparent;
    }

    #convo_form>.pull-left {
      display: inline;
    }

    [href="#delete_modal"] {
      display: none;
      color: #e24e42;
    }

    #sender_details {
      display: none;
    }

    [id^="msg"] img {
      width: 60px;
      height: 60px;
    }

    [id^="msg"] {
      box-shadow: 5px 5px 5px grey;
    }

    .alert-success {
      background-color: rgba(0, 143, 149, 0.2);
      border-color: #008f95;
    }

    @media screen and (max-width: 768px) {

      #new_message_modal .full-screen-modal-body {
        bottom: 125px;
        top: 56px;
      }

      #gc_convo_modal .full-screen-modal-body {
        bottom: 125px;
        top: 34px;
      }

      #new_gc_modal .full-screen-modal-body {
        bottom: 60px;
      }

      #new_message_modal .modal-body {
        max-height: none;
      }

      #gc_convo_modal .modal-body {
        max-height: none;
      }

      [name="new"] {
        position: absolute;
        top: 0;
        right: 20px;
      }

      .label {
        border-radius: 0 0 .25em .25em;
      }

    }

    @media (min-width: 769px) and (max-width: 1024px) {

      #new_message_modal .modal-body {
        max-height: 250px;
      }

      #gc_convo_modal .modal-body {
        max-height: 270px;
      }

    }
  </style>

</head>

<body>

  <?php
  require 'main_header.php';
  ?>

  <div class="container-fluid">

    <div class="row">

      <?php
      require 'main_sidebar.php';
      ?>

      <div class="col-md-11 col-sm-11 main-container">

        <ul class="breadcrumb">

          <li id="messages_active_breadcrumb" class="active">
            Messages
          </li>

        </ul>

        <div class="panel panel-default">

          <div class="panel-body">

            <div class="text-right">

              <span>
                <a class="btn btn-link text-main-green" data-toggle="modal" href="#new_message_modal">
                  <span class="fa fa-pencil-square-o" data-toggle="tooltip" data-placement="auto" title="New Message"></span>
                </a>
              </span>

              <span>
                <a class="btn btn-link text-main-green" data-toggle="modal" href="#new_gc_modal" style="display:none;">
                  <span class="fa fa-users" data-toggle="tooltip" data-placement="auto" title="New Group Chat"></span>
                </a>
              </span>

            </div>

            <hr />

            <ul class="nav nav-tabs" style="display:block;">

              <li class="active" id="personal_message">
                <a data-toggle="tab" href="#personal_message_content">
                  <span class="fa fa-user text-main-green"></span>
                  <span class="hidden-xs text-main-black">Personal Message</span>
                  <span class="visible-xs-inline text-main-black">PM</span>
                </a>
              </li>

              <li id="group_message">
                <a data-toggle="tab" href="#group_message_content">
                  <span class="fa fa-users text-main-green"></span>
                  <span class="hidden-xs text-main-black">Group Message</span>
                  <span class="visible-xs-inline text-main-black">GM</span>
                </a>
              </li>

            </ul>

            <div class="tab-content">

              <div id="personal_message_content" class="tab-pane fade in active">

                <div id="inbox" style="margin-top:20px;">

                  <div id="inbox_empty_panel">
                    <h4 class="text-center">
                      No current message. Try connecting to someone.
                      <span class="fa fa-pencil-square-o text-main-green"></span>
                    </h4>
                  </div>

                  <div id="inbox_panel">

                  </div>

                  <div id="inbox_loading_panel" class="text-center">
                    <img src="pictures/modules/loading.gif">
                  </div>

                  <button id="load_more_message_button" class="btn btn-link btn-block text-main-green" type="button" style="display:none;">
                    Load More
                  </button>

                </div>

              </div>

              <div id="group_message_content" class="tab-pane fade in">

                <div style="margin-top:20px;">

                  <div id="gc_empty_panel">
                    <h4 class="text-center">
                      No current group chat. Try adding one.
                      <span class="fa fa-users text-main-green"></span>
                    </h4>
                  </div>

                  <div id="gc_panel">

                  </div>

                  <div id="gc_loading_panel" class="text-center" style="display:none;">
                    <img src="pictures/modules/loading.gif" style="width:30px;">
                  </div>

                  <button id="load_more_gc_button" class="btn btn-link btn-block text-main-green" type="button" style="display:none;">
                    Load More
                  </button>

                </div>

              </div>

            </div>

          </div>

        </div>

      </div>

    </div>

  </div>

  <div id="new_message_modal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content full-screen-modal-content">

        <div class="modal-header">

          <button class="close" data-dismiss="modal">&times;</button>

          <h4 id="new_message_heading">New Message</h4>

          <div id="sender_details" class="media modal-title">

            <div class="media-left">
              <img id="sender_image" class="img-circle media-object" src="" alt="" />
            </div>

            <div class="media-body">
              <h4 id="sender_name" class="media-heading">
              </h4>
              <p id="sender_username" style="margin-bottom:0;">
              </p>
            </div>

          </div>

          <div id="new_message_search_main">
            <div class="form-group has-feedback">
              <input id="new_message_search_bar" class="form-control" type="text" placeholder="Enter a name, username, or email..." autocomplete="off" />
              <div id="new_message_search_panel" class="panel panel-default">
                <div class="panel-body">
                  <p id="new_message_prompt" class="text-center">
                    Search a friend and you can start sending messages.
                    <span class="fa fa-user text-main-green"></span>
                  </p>
                  <div id="new_message_search_container">
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>

        <div class="modal-body full-screen-modal-body">

          <button id="load_more_convo_button" class="btn btn-link btn-block text-main-green" style="display:none;">
            Load more
          </button>

          <div id="convo_panel">

          </div>

        </div>

        <div class="modal-footer full-screen-modal-footer">

          <form id="convo_form" role="form" autocomplete="off">

            <div class="form-group">
              <textarea class="form-control" rows="1" name="reply_textarea" placeholder="Write a reply..."></textarea>
            </div>

            <div class="pull-left">

              <a class="btn btn-link" href="#delete_modal" data-toggle="modal" style="text-decoration:none;">
                <span class="fa fa-trash text-main-red" data-toggle="tooltip" data-placement="auto" title="Delete Conversation"></span>
              </a>

              <a class="btn btn-link text-main-green" name="image" href="#">
                <span class="fa fa-image" data-toggle="tooltip" data-placement="auto" title="Attach a picture"></span>
              </a>

              <input type="file" name="image_r" accept="image/*" style="display:none;">

              <img name="image_preview" class="img-rounded" src="" style="width:30px;height:30px;display:none;">

              <span name="image_file_name">No current picture</span>

            </div>

            <button class="btn btn-success pull-right" type="submit" name="send_button">
              <span class="fa fa-send"></span> Send
            </button>

          </form>

        </div>

      </div>
    </div>
  </div>

  <div id="new_gc_modal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content full-screen-modal-content">

        <div class="modal-header">
          <button class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">New Group Chat</h4>
        </div>

        <div class="modal-body full-screen-modal-body" sstyle="min-height:300px;">

          <form id="new_gc_form" role="form" autocomplete="off">

            <div class="form-group has-feedback">
              <label>Group Name:</label>
              <input class="form-control" name="name" type="text" placeholder="Enter group name here..." />
              <span class="glyphicon form-control-feedback"></span>
              <span class="help-block"></span>
            </div>

            <div class="form-group has-feedback">
              <label>Message:</label>
              <textarea class="form-control" name="message" type="text" placeholder="Enter message here..."></textarea>
              <span class="glyphicon form-control-feedback"></span>
              <span class="help-block"></span>
            </div>

            <div class="form-group" style="position:relative;">
              <label>Add Group Members:</label>
              <input class="form-control" name="search_bar" type="text" placeholder="Add members here..." />
              <div id="new_gc_search_panel" class="panel panel-default">
                <div class="panel-body">
                  <p id="new_gc_prompt" class="text-center">
                    Search your desired students and you can create a Group Chat.
                    <span class="fa fa-user text-main-green"></span>
                  </p>
                  <div id="new_gc_search_container">
                  </div>
                </div>
              </div>
            </div>

            <div name="gc_members">

            </div>

          </form>

        </div>

        <div class="modal-footer full-screen-modal-footer">
          <button class="btn btn-success" type="submit" form="new_gc_form">
            <span class="fa fa-plus-circle"></span> Add
          </button>
          <button class="btn btn-danger" type="button" data-dismiss="modal">
            <span class="fa fa-remove"></span> Cancel
          </button>
        </div>

      </div>
    </div>
  </div>

  <div id="gc_convo_modal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content full-screen-modal-content">

        <div class="modal-header" style="padding-right:0;">

          <div id="gc_dropdown" class="dropdown" style="display:none;">
            <a class="btn btn-link pull-right dropdown-toggle" data-toggle="dropdown">
              <span class="fa fa-ellipsis-v text-main-green" style="font-size:25px;"></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-right" style="top:26px;">
              <li>
                <a href="#edit_group_name_modal" data-toggle="modal" name="edit_group_name_button">
                  <span class="fa fa-pencil"></span> <span class="text-main-black">Edit Group Name</span>
                </a>
              </li>
              <li>
                <a href="#edit_members_modal" data-toggle="modal" name="edit_members_button">
                  <span class="fa fa-pencil"></span> <span class="text-main-black">Edit Members</span>
                </a>
              </li>
              <li>
                <a href="#delete_gc_modal" data-toggle="modal" name="delete_button" style="color:#e24e42;">
                  <span class="fa fa-trash"></span> <span class="text-main-black">Delete</span>
                </a>
              </li>
            </ul>
          </div>

          <div class="media modal-title" style="padding-top:3px;">

            <div class="media-left">
              <a class="close" href="#" data-dismiss="modal" style="opacity:1;">
                <span class="fa fa-chevron-left text-main-green" style="font-size:20px;"></span>
              </a>
            </div>

            <div class="media-body">
              <h4 class="media-heading" name="gc_name" style="margin-bottom:0; margin-top:0;">

              </h4>
            </div>

          </div>

        </div>

        <div class="modal-body full-screen-modal-body">

          <button id="load_more_gc_convo_button" class="btn btn-link btn-block text-main-green" style="display:none;">
            Load more
          </button>

          <div id="gc_convo_loading_panel" class="text-center" style="display:none;">
            <img src="pictures/modules/loading.gif" style="width:30px;">
          </div>

          <div id="gc_convo_panel">

          </div>

        </div>

        <div class="modal-footer full-screen-modal-footer">

          <form id="gc_convo_form" role="form" autocomplete="off">

            <div class="form-group">
              <textarea class="form-control" rows="1" name="reply_textarea" placeholder="Write a reply..."></textarea>
            </div>

            <div class="pull-left">

              <a class="btn btn-link" href="#delete_modal" data-toggle="modal" style="text-decoration:none;">
                <span class="fa fa-trash" data-toggle="tooltip" data-placement="auto" title="Delete Conversation"></span>
              </a>

              <a class="btn btn-link text-main-green" name="image" href="#" style="display:none;">
                <span class="fa fa-image" data-toggle="tooltip" data-placement="auto" title="Attach a picture"></span>
              </a>

              <input type="file" name="image_r" accept="image/*" style="display:none;">

              <img name="image_preview" class="img-rounded" src="" style="width:30px;height:30px;display:none;">

              <span name="image_file_name" style="display:none;">No current picture</span>

            </div>

            <button class="btn btn-success pull-right" type="submit" name="send_button">
              <span class="fa fa-send"></span> Send
            </button>

          </form>

        </div>

      </div>
    </div>
  </div>

  <div id="edit_group_name_modal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <button class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Group Name</h4>
        </div>

        <div class="modal-body">

          <form id="edit_group_name_form" class="form-horizontal" role="form" autocomplete="off">

            <div class="form-group">
              <label class="control-label col-md-3" style="padding-top:4px;">Group Name:</label>
              <div class="col-md-8">
                <input class="form-control" type="text" name="group_name" placeholder="Search to add student..." />
              </div>
            </div>

          </form>

        </div>

        <div class="modal-footer">
          <button class="btn btn-success" type="button" name="confirm_button">
            <span class="fa fa-save"></span> Save
          </button>
          <button class="btn btn-danger" type="button" data-dismiss="modal">
            <span class="fa fa-remove"></span> Cancel
          </button>
        </div>

      </div>
    </div>
  </div>

  <div id="edit_members_modal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <button class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Members</h4>
        </div>

        <div class="modal-body">

          <form id="edit_members_form" class="form-horizontal" role="form" autocomplete="off">

            <div class="form-group">
              <label class="control-label col-md-2" for="search" style="padding-top:4px;">Search:</label>
              <div class="col-md-9">
                <input class="form-control" type="text" name="search_bar" placeholder="Search to add student..." />
                <div id="member_search_panel" class="panel panel-default">
                  <div class="panel-body">
                    <p id="member_search_prompt" class="text-center">
                      Search your desired students.
                      <span class="fa fa-user text-main-green"></span>
                    </p>
                    <div id="member_search_container">
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </form>

          <div name="members">

          </div>

        </div>

        <div class="modal-footer">
          <button class="btn btn-success" type="button" data-dismiss="modal">
            <span class="fa fa-save"></span> Save
          </button>
          <button class="btn btn-danger" type="button" data-dismiss="modal">
            <span class="fa fa-remove"></span> Cancel
          </button>
        </div>

      </div>
    </div>
  </div>

  <div id="delete_modal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header bg-danger">
          <button class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title text-danger">Warning!</h4>
        </div>

        <div class="modal-body">
          <p class="lead text-center" style="margin-bottom:10px;">Are you sure you want to delete this conversation?</p>
          <small>
            <strong>Note:</strong> Once you delete this conversation, you cannot undo it but you can still receive message from this person and you can send him a message again.
          </small>
        </div>

        <div class="modal-footer">
          <button class="btn btn-success" type="button" name="confirm_button" data-dismiss="modal">
            <span class="fa fa-check"></span> Yes
          </button>
          <button class="btn btn-danger" type="button" name="cancel_button" data-dismiss="modal">
            <span class="fa fa-remove"></span> No
          </button>
        </div>

      </div>
    </div>
  </div>

  <div id="delete_gc_modal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header bg-danger">
          <button class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title text-danger">Warning!</h4>
        </div>

        <div class="modal-body">
          <p class="lead text-center" style="margin-bottom:10px;">Are you sure you want to delete this group chat?</p>
          <small>
            <strong>Note:</strong> Once you delete this conversation, you cannot undo it but you can create a group chat again.
          </small>
        </div>

        <div class="modal-footer">
          <button class="btn btn-success" type="button" name="confirm_button" data-dismiss="modal">
            <span class="fa fa-check"></span> Yes
          </button>
          <button class="btn btn-danger" type="button" name="cancel_button" data-dismiss="modal">
            <span class="fa fa-remove"></span> No
          </button>
        </div>

      </div>
    </div>
  </div>

  <div id="loading_modal" class="modal fade" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">

        <div class="modal-body">
          <div class="text-center">
            <img src="pictures/modules/loading2.gif" style="width:50px;">
            <h4>Please Wait.....</h4>
          </div>
        </div>

      </div>
    </div>
  </div>

  <div id="prompt_modal" class="modal fade">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">

        <div class="modal-body">
          <p class="text-center" name="message"></p>
        </div>

        <div class="modal-footer">
          <button class="btn btn-success btn-sm" type="button" name="ok_button" data-dismiss="modal">
            <span class="fa fa-thumbs-up"></span> Ok
          </button>
        </div>

      </div>
    </div>
  </div>

  <!-- Main Variables -->
  <script>
    var myType = '<?php echo isset($_SESSION['type']) ? $_SESSION['type'] : '' ?>';
    var myId = <?php echo isset($_SESSION['id']) ? $_SESSION['id'] : '0' ?>;
    var myImage = '<?php echo isset($_SESSION['image']) ? $_SESSION['image'] : '' ?>';
    var myLogInId = <?php echo isset($_SESSION['log_in_id']) ? $_SESSION['log_in_id'] : '0' ?>;
  </script>

  <!-- Main Workers -->
  <script src="js/main_routing.js"></script>
  <script src="js/log_in_updater.js"></script>
  <script src="js/nav_manipulator.js"></script>

  <!-- Classroom Unsetter -->
  <script src="js/unset_classroom.js"></script>

  <!-- Utilities -->
  <script src="js/utilities/input.js"></script>
  <script src="js/utilities/array.js"></script>
  <script src="js/utilities/viewport.js"></script>

  <!-- Addon -->
  <script src="js/user_profile_retriever.js"></script>

  <!-- Main Notification Worker -->
  <script src="js/notification/events/init.js"></script>
  <script src="js/notification/operations/retrieval.js"></script>

  <!-- PM Workers -->
  <script src="js/message/view.js"></script>
  <script src="js/message/variables.js"></script>
  <script src="js/message/inbox_manager.js"></script>
  <script src="js/message/convo_manager.js"></script>
  <script src="js/message/new_message_manager.js"></script>

  <!-- GM Workers -->
  <script src="js/gc/variables.js"></script>
  <script src="js/gc/nodes.js"></script>
  <script src="js/gc/resets.js"></script>
  <script src="js/gc/view.js"></script>
  <script src="js/gc/displays.js"></script>
  <script src="js/gc/operations/retrieval.js"></script>
  <script src="js/gc/operations/manipulation.js"></script>
  <script src="js/gc/events/init.js"></script>
  <script src="js/gc/events/creation.js"></script>
  <script src="js/gc/events/deleting.js"></script>
  <script src="js/gc/events/editing.js"></script>
  <script src="js/gc/events/convo.js"></script>

</body>

</html>