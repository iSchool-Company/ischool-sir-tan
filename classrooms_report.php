<!DOCTYPE html>
<?php
session_start();
?>
<html>

<head>

  <title>iSchool | Report</title>

  <?php
  require 'meta.php';
  ?>
  <link rel="stylesheet" href="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
  <script src="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>

  <style>
    @media print {

      .breadcrumb,
      .btn-success,
      .form-group,
      #choices_panel {
        display: none;
      }

    }
  </style>

</head>

<body>

  <div class="container">

    <div class="row">

      <div class="col-md-12 col-sm-12" style="margin-top:10px;">

        <ul class="breadcrumb">
          <li class="active">
            Quiz Report
          </li>
        </ul>

        <div class="panel panel-default">
          <div class="panel-body">

            <button class="btn btn-success pull-right" onClick="print()">
              <span class="fa fa-print"></span> Print
            </button>

            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-4">
                <div class="form-group">
                  <p><b>Classroom:</b></p>
                  <select class="form-control" id="classroom">

                  </select>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <p><b>Type:</b></p>
                  <select class="form-control" id="type">
                    <option>Assignment</option>
                    <option>Quiz</option>
                  </select>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <p><b>Display:</b></p>
                  <select class="form-control" id="display">
                    <option>Detailed</option>
                    <option>Bar Graph</option>
                    <option>Line Graph</option>
                  </select>
                </div>
              </div>

            </div>

            <div id="choices_panel">

            </div>

            <div id="detailed_panel">

            </div>

            <div class="ct-chart" style="width:100%; height:80vh; margin-bottom:20px; display:none;">

            </div>

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
    var type = '<?php echo isset($_SESSION['rep_type']) ? $_SESSION['rep_type'] : '' ?>';
    var display = '';
    var ids = [<?php echo isset($_SESSION['rep_id']) ? $_SESSION['rep_id'] : '' ?>];
  </script>

  <!-- Main Workers>
    <script src="js/main_routing.js"></script -->

  <!-- Report Workers -->
  <script src="js/report/main.js"></script>

</body>

</html>