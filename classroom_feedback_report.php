<!DOCTYPE html>
<?php
session_start();
?>
<html>

<head>

  <title>LMS | Report Print</title>

  <?php
  require 'meta.php';
  ?>

  <script src="../frameworks/html2canvas 1.0.0-rc.7/html2canvas.min.js"></script>

  <style media="all">
    #main {
      margin: 25px;
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
          <p><b>Material Name:</b> <span id="feedback_material_name"></span></p>
        </div>

        <div class="col-sm-6">
          <p><b>Total Respondents:</b> <b id="feedback_respondents_count">0</b> out of <span id="feedback_total_count">0</span> students</p>
        </div>

      </div>

      <hr>

      <table class="table table-bordered table-condensed">
        <tbody>
          <tr>
            <td style="width: 200px">Sad</td>
            <td id="negative_feedbacks"></td>
          </tr>
          <tr>
            <td>Neutral</td>
            <td id="neutral_feedbacks"></td>
          </tr>
          <tr>
            <td>Happy</td>
            <td id="positive_feedbacks"></td>
          </tr>
        </tbody>
      </table>

    </div>
  </div>

  <div id="loading_modal" class="modal fade" style="margin-top:72px;" data-backdrop="static" data-keyboard="false">
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

  <!-- Main Variables -->
  <script>
    var classroomId = <?php echo isset($_SESSION['classroom_id']) ? $_SESSION['classroom_id'] : '0' ?>;
    var myType = '<?php echo isset($_SESSION['type']) ? $_SESSION['type'] : '' ?>';
    var myId = <?php echo isset($_SESSION['id']) ? $_SESSION['id'] : '0' ?>;
    var myLogInId = <?php echo isset($_SESSION['log_in_id']) ? $_SESSION['log_in_id'] : '0' ?>;
    var crStatus = '';

    $(document).ready(function() {

      $('#loading_modal').modal();

      $('#back').hover(function() {
        $('.breadcrumb [href="my_classrooms.php"]').css('z-index', '6');
      }, function() {
        setTimeout(function() {
          $('.breadcrumb [href="my_classrooms.php"]').css('z-index', '8');
        }, 300);
      });

      let materialId = decodeURIComponent($.urlParam('material_id'));

      retrieveFeedbacks(materialId, classroomId, () => {

        $('#loading_modal').modal('hide');

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
  <script src="js/progress/nodes.js"></script>
  <script src="js/progress/operations/retrieval.js"></script>

</body>

</html>