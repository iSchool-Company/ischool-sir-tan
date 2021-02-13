<!DOCTYPE html>
<?php
session_start();
?>
<html>

<head>

  <title>iSchool | Report Print</title>

  <?php
  require 'meta.php';
  ?>

  <style media="all">
    #main {
      margin: 50px 25px;
    }

    .rate-picker {
      margin-left: 350px;
    }

    .rate-button>.rate-icon {
      font-size: 48px;
    }

    .rate-count {
      display: inline-block;
      margin: 0;
    }

    .criteria-table {
      width: 100%;
    }

    .criteria-table td {
      padding: 10px;
    }

    .criteria-table .progress {
      margin: 0;
    }

    .progress-bar-negative {
      background-color: #f44336 !important;
    }

    .progress-bar-neutral {
      background-color: #62757f !important;
    }

    .progress-bar-positive {
      background-color: #4caf50 !important;
    }

    .legend-item {
      display: inline-block;
      width: 24px;
      height: 24px;
      border-radius: 5px;
    }
  </style>

</head>

<body>

  <div id="main" class="panel panel-default" style="border-radius: 0;">
    <div class="panel-body">

      <div class="text-center">
        <img src="./pictures/modules/logo_banner.png" style="width: 150px;">
      </div>

      <br>
      <hr>
      <br>

      <div class="row">

        <div class="col-sm-6">
          <p><b>Material Name:</b> <span id="detailed_material_name"></span></p>
        </div>

        <div class="col-sm-6">
          <p><b>Total Respondents:</b> <b id="detailed_respondents_count">0</b> out of <span id="detailed_total_count">0</span> students</p>
        </div>

      </div>

      <hr>

      <h4><b>Overall Rate for this Material:</b></h4>

      <div class="rate-picker">
        <div class="row">
          <div class="col-xs-4">
            <div class="rate-button rate-negative static">
              <span class="rate-icon fa fa-frown-o"></span>
              <br>
              <h3 class="rate-count"><b id="detailed_rate_neg">0</b></h3>
            </div>
          </div>
          <div class="col-xs-4">
            <div class="rate-button rate-neutral static">
              <span class="rate-icon fa fa-meh-o"></span>
              <br>
              <h3 class="rate-count"><b id="detailed_rate_neu">0</b></h3>
            </div>
          </div>
          <div class="col-xs-4">
            <div class="rate-button rate-positive static">
              <span class="rate-icon fa fa-smile-o"></span>
              <br>
              <h3 class="rate-count"><b id="detailed_rate_pos">0</b></h3>
            </div>
          </div>
        </div>
      </div>

      <hr>

      <h4><b>Rating per Category for this Material:</b></h4>

      <table class="criteria-table">

        <tbody>

          <tr>
            <td style="width:350px;">Objectives are clearly stated</td>
            <td>
              <div class="progress">
                <div id="detailed_rate_1_neg" class="progress-bar progress-bar-negative" role="progressbar" style="width:0%"></div>
                <div id="detailed_rate_1_neu" class="progress-bar progress-bar-neutral" role="progressbar" style="width:0%"></div>
                <div id="detailed_rate_1_pos" class="progress-bar progress-bar-positive" role="progressbar" style="width:0%"></div>
              </div>
            </td>
          </tr>

          <tr>
            <td style="width:350px;">Content is aligned with course</td>
            <td>
              <div class="progress">
                <div id="detailed_rate_2_neg" class="progress-bar progress-bar-negative" role="progressbar" style="width:0%"></div>
                <div id="detailed_rate_2_neu" class="progress-bar progress-bar-neutral" role="progressbar" style="width:0%"></div>
                <div id="detailed_rate_2_pos" class="progress-bar progress-bar-positive" role="progressbar" style="width:0%"></div>
              </div>
            </td>
          </tr>

          <tr>
            <td style="width:350px;">Content is well organized</td>
            <td>
              <div class="progress">
                <div id="detailed_rate_3_neg" class="progress-bar progress-bar-negative" role="progressbar" style="width:0%"></div>
                <div id="detailed_rate_3_neu" class="progress-bar progress-bar-neutral" role="progressbar" style="width:0%"></div>
                <div id="detailed_rate_3_pos" class="progress-bar progress-bar-positive" role="progressbar" style="width:0%"></div>
              </div>
            </td>
          </tr>

          <tr>
            <td style="width:350px;">Instructions are clearly stated</td>
            <td>
              <div class="progress">
                <div id="detailed_rate_4_neg" class="progress-bar progress-bar-negative" role="progressbar" style="width:0%"></div>
                <div id="detailed_rate_4_neu" class="progress-bar progress-bar-neutral" role="progressbar" style="width:0%"></div>
                <div id="detailed_rate_4_pos" class="progress-bar progress-bar-positive" role="progressbar" style="width:0%"></div>
              </div>
            </td>
          </tr>

          <tr>
            <td style="width:350px;">Activities are aligned with content</td>
            <td>
              <div class="progress">
                <div id="detailed_rate_5_neg" class="progress-bar progress-bar-negative" role="progressbar" style="width:0%"></div>
                <div id="detailed_rate_5_neu" class="progress-bar progress-bar-neutral" role="progressbar" style="width:0%"></div>
                <div id="detailed_rate_5_pos" class="progress-bar progress-bar-positive" role="progressbar" style="width:0%"></div>
              </div>
            </td>
          </tr>

        </tbody>

      </table>

      <hr>

      <h4><b>Sentiment Analysis Based on Feedback:</b></h4>

      <table class="criteria-table">

        <tbody>

          <tr>
            <td style="width:350px;">Negative</td>
            <td>
              <div id="detailed_sentiment_analysis_neg" class="progress" style="width:0%">
                <div class="progress-bar progress-bar-negative" role="progressbar" style="width:100%"></div>
              </div>
            </td>
          </tr>

          <tr>
            <td style="width:350px;">Neutral</td>
            <td>
              <div id="detailed_sentiment_analysis_neu" class="progress" style="width:0%">
                <div class="progress-bar progress-bar-neutral" role="progressbar" style="width:100%"></div>
              </div>
            </td>
          </tr>

          <tr>
            <td style="width:350px;">Positive</td>
            <td>
              <div id="detailed_sentiment_analysis_pos" class="progress" style="width:0%">
                <div class="progress-bar progress-bar-positive" role="progressbar" style="width:100%"></div>
              </div>
            </td>
          </tr>

        </tbody>

      </table>

      <hr>

      <p class="text-right" style="width:90%;">
        Legends:
        &nbsp;
        <span class="legend-item progress-bar-negative"></span>
        Negative
        &nbsp;
        <span class="legend-item progress-bar-neutral"></span>
        Neutral
        &nbsp;
        <span class="legend-item progress-bar-positive"></span>
        Positive
      </p>

    </div>
  </div>

  <!-- Main Variables -->
  <script>
    var classroomId = <?php echo isset($_SESSION['classroom_id']) ? $_SESSION['classroom_id'] : '0' ?>;
    var myType = '<?php echo isset($_SESSION['type']) ? $_SESSION['type'] : '' ?>';
    var myId = <?php echo isset($_SESSION['id']) ? $_SESSION['id'] : '0' ?>;
    var myLogInId = <?php echo isset($_SESSION['log_in_id']) ? $_SESSION['log_in_id'] : '0' ?>;
    var crStatus = '';

    $(document).ready(function() {

      $('#back').hover(function() {
        $('.breadcrumb [href="my_classrooms.php"]').css('z-index', '6');
      }, function() {
        setTimeout(function() {
          $('.breadcrumb [href="my_classrooms.php"]').css('z-index', '8');
        }, 300);
      });

      let materialId = decodeURIComponent($.urlParam('material_id'));

      retrieveDetailedReview(materialId, classroomId, function() {

        setTimeout(function() {
          window.print();
        }, 1500);
      });
    });

    $.urlParam = function(name) {
      var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
      return results[1] || 0;
    }
  </script>

  <!-- Main Workers -->
  <script src="js/main_routing.js"></script>
  <script src="js/log_in_updater.js"></script>
  <script src="js/nav_manipulator.js"></script>

  <!-- Materials Workers -->
  <script src="js/progress/displays.js"></script>
  <script src="js/progress/operations/retrieval.js"></script>

</body>

</html>