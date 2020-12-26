<!DOCTYPE html>
<?php
session_start();
?>
<html>

<head>

  <title>iSchool | News</title>

  <link rel="icon" href="../pictures/modules/logo.png">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
  <link href="../frameworks/Font Awesome 4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link href="../frameworks/Bootstrap 3.3.7/css/bootstrap.min.css" rel="stylesheet">
  <script src="../frameworks/JQuery 3.1.1/jquery.min.js"></script>
  <script src="../frameworks/Bootstrap 3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/navbar.css">
  <link rel="stylesheet" href="css/sidebar.css">
  <link rel="stylesheet" href="css/form.css">

</head>

<body>

  <?php
  require 'main_header.php';
  ?>

  <div class="container-fluid main-container-fluid">

    <br /><br />

    <?php
    require 'main_sidebar.php';
    ?>

    <br />

    <div class="col-md-11">

      <ul class="breadcrumb">
        <li class="active">
          News
        </li>
      </ul>

      <a class="btn btn-success pull-right" href="#add_modal" type="button" data-toggle="modal" style="margin-bottom:20px;">
        <span class="fa fa-plus-circle"></span> Add News
      </a>

      <div class="clearfix"></div>

      <div id="news_panel">
      </div>

      <div class="panel panel-default">
        <div class="panel-body" style="padding:0;">
          <a id="load_more_button" class="btn btn-link btn-block" type="button">Load More...</a>
        </div>
      </div>

    </div>

  </div>

  <div id="add_modal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <button class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add News</h4>
        </div>

        <div class="modal-body">

          <form id="add_form" class="form-horizontal" role="form" autocomplete="off">

            <div class="form-group has-feedback">
              <label class="control-label col-md-2" for="news_title">Title:</label>
              <div class="col-md-9">
                <input id="news_title" class="form-control" type="text" name="title" placeholder="Enter news title..." />
                <span class="glyphicon form-control-feedback"></span>
                <span class="help-block"></span>
              </div>
            </div>

            <div class="form-group has-feedback">
              <label class="control-label col-md-2" for="news_content">Content:</label>
              <div class="col-md-9">
                <textarea id="news_content" class="form-control" name="content" rows="5" placeholder="Enter news content..."></textarea>
                <span class="glyphicon form-control-feedback"></span>
                <span class="help-block"></span>
              </div>
            </div>

            <div class="form-group has-feedback">
              <div class="col-md-offset-2">
                <a class="btn btn-success" href="#" type="button" name="file">
                  <span class="fa fa-image"></span> Browse
                </a>
                <input type="file" name="file_r" accept="image/*" style="display:none;">
                <i name="file_msg">No file chosen</i>
                <span name="file_name"></span>
                <span class="help-block"></span>
              </div>
            </div>

          </form>

        </div>

        <div class="modal-footer">
          <button class="btn btn-success" type="submit" form="add_form">
            <span class="fa fa-check"></span> Post
          </button>
          <a class="btn btn-danger" href="#" type="button" data-dismiss="modal">
            <span class="fa fa-remove"></span> Cancel
          </a>
        </div>

      </div>
    </div>
  </div>

  <div id="edit_modal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <button class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit News</h4>
        </div>

        <div class="modal-body">

          <form class="form-horizontal" role="form">

            <div class="form-group">
              <label class="control-label col-md-2" for="news_title">Title:</label>
              <div class="col-md-9">
                <input id="news_title" class="form-control" type="text" name="news_title" placeholder="Enter news title..." />
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-2" for="news_content">Content:</label>
              <div class="col-md-9">
                <textarea id="news_content" class="form-control" name="news_content" rows="5" placeholder="Enter news content..."></textarea>
              </div>
            </div>

            <div class="form-group">
              <div class="col-md-2 col-md-offset-2">
                <a class="btn btn-success" href="#" type="button" name="browse_image">
                  <span class="fa fa-image"></span> Browse
                </a>
              </div>
              <p class="form-control-static col-md-8" name="image_name">Image</p>
            </div>

          </form>

        </div>

        <div class="modal-footer">
          <a class="btn btn-success" href="#" type="button" data-dismiss="modal">
            <span class="fa fa-save"></span> Save
          </a>
          <a class="btn btn-danger" href="#" type="button" data-dismiss="modal">
            <span class="fa fa-remove"></span> Cancel
          </a>
        </div>

      </div>
    </div>
  </div>

  <div id="delete_modal" class="modal fade">

    <div class="modal-dialog">

      <div class="modal-content">

        <div class="modal-header bg-danger">

          <button class="close" data-dismiss="modal">&times;</button>

          <h2 class="modal-title text-danger">Warning!</h2>

        </div>

        <div class="modal-body">
          <p class="lead text-center">Are you sure you want to delete this news?</p>
        </div>

        <div class="modal-footer">

          <a class="btn btn-success" href="#" type="button" name="confirm_button">
            <span class="fa fa-check"></span> Confirm
          </a>

          <a class="btn btn-danger" href="#" type="button" data-dismiss="modal">
            <span class="fa fa-remove"></span> Cancel
          </a>

        </div>

      </div>

    </div>

  </div>

  <div id="loading_modal" class="modal fade" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">

        <div class="modal-body">
          <div class="text-center">
            <img src="../pictures/modules/loading2.gif" style="width:50px;">
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
          <a class="btn btn-success btn-sm" href="#" type="button" name="ok_button" data-dismiss="modal">
            <span class="fa fa-thumbs-up"></span> Ok
          </a>
        </div>

      </div>
    </div>
  </div>

  <script>
    var myId = <?php echo isset($_SESSION['id']) ? $_SESSION['id'] : '0' ?>;
  </script>

  <script src="js/nav_manipulator.js"></script>
  <script src="js/main_routing.js"></script>

  <script src="js/utilities/files.js"></script>
  <script src="js/utilities/input.js"></script>

  <script src="js/news/nodes.js"></script>
  <script src="js/news/displays.js"></script>
  <script src="js/news/operations/manipulation.js"></script>
  <script src="js/news/operations/retrieval.js"></script>
  <script src="js/news/events/init.js"></script>
  <script src="js/news/events/creation.js"></script>
  <script src="js/news/events/deleting.js"></script>

</body>

</html>