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
  <link rel="stylesheet" href="../frameworks/Chartist 0.11.0/chartist.min.css">
  <script src="../frameworks/Chartist 0.11.0/chartist.min.js"></script>

  <style>
    #main {
      margin: 25px;
    }

    .ct-series-a .ct-bar,
    .ct-series-a .ct-line,
    .ct-series-a .ct-point,
    .ct-series-a .ct-slice-donut {
      stroke: #f44336;
    }

    .ct-series-b .ct-bar,
    .ct-series-b .ct-line,
    .ct-series-b .ct-point,
    .ct-series-b .ct-slice-donut {
      stroke: #62757f;
    }

    .ct-series-c .ct-bar,
    .ct-series-c .ct-line,
    .ct-series-c .ct-point,
    .ct-series-c .ct-slice-donut {
      stroke: #4caf50;
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

      <h4 id="summary_loading" class="text-center">Retrieving data please wait...</h4>

      <div id="summary_bar"></div>

      <div id="summary_line"></div>

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

      let classroomId = decodeURIComponent($.urlParam('classroom_id'));

      retrieveSummarizedReview(classroomId, function() {

        $('#loading_modal').modal('hide');

        renderCharts();

        setTimeout(function() {
          window.print();
        }, 1500);
      });
    });

    $.urlParam = function(name) {
      var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
      return results[1] || 0;
    }

    const barChartOptions = {
      seriesBarDistance: 10,
      fullWidth: true,
      chartPadding: {
        left: 50,
        right: 50
      }
    };

    const lineChartOptions = {
      fullWidth: true,
      chartPadding: {
        left: 50,
        right: 50
      }
    };

    const responsiveOptions = [
      ['screen and (max-width: 640px)', {
        axisX: {
          labelInterpolationFnc: function(value) {
            return value[0];
          }
        }
      }]
    ];
  </script>

  <!-- Main Workers -->
  <script src="js/main_routing.js"></script>
  <script src="js/log_in_updater.js"></script>
  <script src="js/nav_manipulator.js"></script>

  <!-- Materials Workers -->
  <script src="js/progress/variables.js"></script>
  <script src="js/progress/displays.js"></script>
  <script src="js/progress/operations/retrieval.js"></script>

</body>

</html>