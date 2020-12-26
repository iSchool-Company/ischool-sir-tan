<!DOCTYPE html>
<?php
session_start();
?>
<html>

<head>

  <title>iSchool | Home</title>

  <?php
  require 'meta.php';
  ?>

  <style>
    #new_news_button,
    #news_full_content_panel {
      display: none;
    }

    #new_news_button:hover {
      background-color: #dfe3ee;
      border-radius: 8px;
      color: #000000;
    }

    #news_panel [name="content"] {
      max-height: 50px;
      overflow: hidden;
    }

    #news_full_content_panel [name="caption"] {
      margin: 0 20px;
      white-space: pre-line;
    }

    #back_button {
      position: absolute;
      z-index: 8;
      top: 55px;
      left: 25px;
    }

    #back_button>span {
      font-size: 16px;
    }

    @media screen and (max-width: 768px) {

      h4 {
        text-align: center;
      }

      .panel-body-mobile {
        padding: 15px 0;
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
          <li class="active">
            Home
          </li>
        </ul>

        <div class="panel panel-default">

          <div class="panel-heading">
            <button id="new_news_button" class="btn btn-link btn-block" type="button">1 New News</button>
          </div>

          <div id="news_panel" class="panel-body">

          </div>

          <div id="news_full_content_panel" class="panel-body">

            <a id="back_button" href="#" style="text-decoration:nones; color:#333333;">
              <span class="fa fa-arrow-circle-left text-main-green"></span> <b class="text-main-black">Back</b>
            </a>

            <div class="row">
              <div class="col-md-12 text-center">
                <img name="image" class="img-rounded" src="" alt="Not Available" style="width:50%;">
              </div>
            </div>

            <div class="row">
              <div class="panel-body-mobile col-md-12">
                <h4 class="text-center" style="margin-bottom:30px;">
                  <span name="title"></span>
                  <br class="visible-xs" />
                  <small><i name="date_time"></i></small>
                </h4>
                <p name="caption"></p>
              </div>
            </div>

          </div>

          <div class="panel-footer text-center">
            <a id="load_more_button" class="btn btn-link btn-block text-main-green" type="button">Load More...</a>
          </div>

        </div>

      </div>

    </div>

  </div>

  <!-- Main Variables -->
  <script>
    var myType = '<?php echo isset($_SESSION['type']) ? $_SESSION['type'] : '' ?>';
    var myId = <?php echo isset($_SESSION['id']) ? $_SESSION['id'] : '0' ?>;
    var myLogInId = <?php echo isset($_SESSION['log_in_id']) ? $_SESSION['log_in_id'] : '0' ?>;

    $(document).ready(function() {
      $('#nav_backpack').hover(function() {
        $('#back_button').css('z-index', '6');
      }, function() {
        setTimeout(function() {
          $('#back_button').css('z-index', '8');
        }, 300);
      });
    });
  </script>

  <!-- Main Workers -->
  <script src="js/main_routing.js"></script>
  <script src="js/log_in_updater.js"></script>
  <script src="js/nav_manipulator.js"></script>

  <!-- Utilities -->
  <script src="js/utilities/viewport.js"></script>

  <!-- Classroom Unsetter -->
  <script src="js/unset_classroom.js"></script>

  <!-- Main Notification Worker -->
  <script src="js/notification/events/init.js"></script>
  <script src="js/notification/operations/retrieval.js"></script>

  <!-- News Workers -->
  <script src="js/news/variables.js"></script>
  <script src="js/news/nodes.js"></script>
  <script src="js/news/display_manager.js"></script>
  <script src="js/news/operation_manager.js"></script>
  <script src="js/news/interaction_manager.js"></script>

</body>

</html>