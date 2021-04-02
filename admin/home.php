<!DOCTYPE html>
<?php
session_start();
?>
<html>

<head>

  <title>LMS | Dashboard</title>

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
          Dashboard
        </li>
      </ul>

    </div>

  </div>

  <script>
    var myId = <?php echo isset($_SESSION['id']) ? $_SESSION['id'] : '0' ?>;
  </script>

  <script src="js/nav_manipulator.js"></script>
  <script src="js/main_routing.js"></script>

</body>

</html>