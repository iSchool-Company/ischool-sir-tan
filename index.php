<!DOCTYPE html>
<?php
session_start();
?>
<html lang="en">

<head>

  <title>LMS</title>

  <link rel="icon" href="pictures/modules/logo.png">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
  <link href="../frameworks/Font Awesome 4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link href="../frameworks/Bootstrap 3.3.7/css/bootstrap.min.css" rel="stylesheet">
  <script src="../frameworks/JQuery 3.1.1/jquery.min.js"></script>
  <script src="../frameworks/Bootstrap 3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/form.css">
  <link rel="manifest" href="manifest.json">

  <style>
    body {
      background-color: #dfe3ee;
    }

    .navbar {
      background-color: rgba(0, 0, 0, 0.5);
      border: 0;
    }

    .navbar-header>.col-xs-4 {
      padding-right: 0px;
      padding-left: 0px;
    }

    .navbar-brand {
      padding: 5px 15px;
    }

    .ischool-logo {
      height: 40px;
      width: 135px;
    }

    .nav>li>a.navbar-menu {
      color: #f7f7f7;
      font-size: 15px;
    }

    .nav>li>a.navbar-menu:hover,
    .nav>li.active>a.navbar-menu {
      background-color: #f7f7f7;
      color: #008f95;
    }

    .dropdown-menu {
      background-color: rgba(0, 0, 0, 0.5);
      min-width: 300px;
      padding: 17px;
    }

    h3.text-center {
      color: #f7f7f7;
    }

    .help-block {
      background-color: rgba(255, 255, 255, 0.5);
    }

    .btn {
      font-size: 12px;
    }

    .item>.container-fluid {
      position: relative;
    }

    .item {
      height: 759px;
    }

    img.carousel-image {
      position: absolute;
      opacity: 0.6;
      width: 100%;
      object-fit: cover;
    }

    .carousel-caption {
      color: #008f95;
      margin-top: 220px;
      max-width: 550px;
      position: static;
    }

    .navbar_content {
      padding-top: 50px;
      min-height: 400px;
    }

    img.media-object {
      height: 85px;
      width: 85px;
    }

    .section-heading::first-letter {
      font-size: 40px;
      font-weight: bold;
      margin-right: 2px;
    }

    .section-heading {
      letter-spacing: 1px;
    }

    .panel-default {
      border: 1px solid #dfe3ee;
      border-radius: 45px;
      background-color: rgba(255, 255, 255, 0.5);
    }

    .image-overview-1 {
      width: 17%;
      float: right;
      margin-left: 10px;
    }

    .image-overview-2 {
      width: 17%;
      float: left;
      margin-right: 10px;
    }

    .row>.col-md-4 {
      padding: 0 30px;
    }

    .a:hover {
      background-color: rgba(0, 0, 255, 0.1);
    }

    .b:hover {
      background-color: rgba(255, 0, 255, 0.1);
    }

    .c:hover {
      background-color: rgba(233, 176, 0, 0.2);
    }

    .col-md-6>.form-group {
      margin-left: 10px;
    }

    .first-row {
      background-color: #2E3436;
    }

    .first-row .center-block {
      height: 75px;
      width: 175px;
      margin-bottom: 15px;
      margin-top: 15px;
    }

    .second-row {
      background-color: #222728;
      color: #f7f7f7;
      font-size: 16px;
      padding: 10px 0;
    }

    @media screen and (max-width: 768px) {

      .navbar>.container-fluid {
        padding-left: 0px;
        padding-right: 0px;
      }

      .container-fluid>.navbar-header {
        margin-left: 0;
        margin-right: 0;
      }

      .container-fluid>.navbar-collapse {
        margin-right: 0;
        margin-left: 0;
      }

      [data-target="#overview_navbar"] {
        float: left;
        margin: 8px;
        padding: 9px 10px;
      }

      .col-xs-4>.navbar-brand {
        float: none;
        padding: 6px 0;
      }

      .ischool-logo {
        display: block;
        height: 35px;
        margin: 8px auto;
        width: 115px;
      }

      .navbar-nav {
        margin: 0 -15px;
      }

      #log_in_panel {
        border: 0px solid #dfe3ee;
        border-radius: 25px;
        background-color: rgba(255, 255, 255, 0.5);
        margin-left: 5px;
        margin-right: 5px;
        margin-top: 55px;
        margin-bottom: -20px;
      }

      h3.text-center {
        color: #008f95;
      }

      .row>.panel-default {
        margin-left: 5px;
        margin-right: 5px;
      }

      .row>.col-md-4 {
        margin-left: 5px;
        margin-right: 5px;
        padding: 0;
      }

      .row>.col-md-6 {
        margin-left: 5px;
        margin-right: 5px;
        padding: 0 3px;
      }

      .col-md-6>.form-group {
        margin-left: 15px;
        margin-right: 15px;
      }

      .item {
        height: 300px;
      }

      .image-overview-1,
      .image-overview-2 {
        width: 70%;
        float: none;
      }

      .section-heading {
        text-align: center;
      }

      .media {
        text-align: center;
      }

      .first-row .center-block {
        height: 50px;
        width: 130px;
        margin-bottom: 5px;
        margin-top: 5px;
      }

      #copyright {
        font-size: 12px;
        padding: 10px 0 0 0;
      }

    }
  </style>

</head>

<body data-spy="scroll" data-target=".navbar" data-offset="50">

  <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">

    <div class="container-fluid">

      <div class="navbar-header">

        <div class="col-xs-4">
          <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#overview_navbar">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>

        <div class="col-xs-4 visible-xs">
          <a class="navbar-brand" href="index.php">
            <img class="ischool-logo" src="pictures/modules/logo_banner.png" alt="LMS" />
          </a>
        </div>

        <a class="navbar-brand hidden-xs" href="index.php">
          <img class="ischool-logo" src="pictures/modules/logo_banner.png" alt="LMS" />
        </a>

      </div>

      <div id="overview_navbar" class="collapse navbar-collapse text-center">

        <ul class="nav navbar-nav">

          <li>
            <a class="navbar-menu" href="#overview">
              <span class="fa fa-file-text-o"></span> Overview
            </a>
          </li>

          <li>
            <a class="navbar-menu" href="#about_us">
              <span class="fa fa-info-circle"></span> About Us
            </a>
          </li>

          <li>
            <a class="navbar-menu" href="#contact_us">
              <span class="fa fa-phone"></span> Contact Us
            </a>
          </li>

          <li style="display:none;">
            <a class="navbar-menu" id="nav_help" href="#">
              <span class="fa fa-question-circle"></span> Help
            </a>
          </li>

        </ul>

        <ul class="nav navbar-nav navbar-right hidden-xs">

          <li class="dropdown">

            <a id="log_in_dropdown" class="dropdown-toggle navbar-menu" href="#" data-toggle="dropdown">
              <span class="fa fa-sign-in"></span> Sign In
            </a>

            <div class="dropdown-menu">

              <h3 class="text-center">Get Started Now</h3>

              <form id="log_in_form_main" method="post" role="form" autocomplete="off" style="margin-bottom:20px;">

                <div class="form-group has-feedback">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="fa fa-user"></i>
                    </span>
                    <input class="form-control" type="text" name="username" placeholder="Username" />
                  </div>
                  <span class="glyphicon form-control-feedback"></span>
                  <span class="help-block"></span>
                </div>

                <div class="form-group has-feedback">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="fa fa-lock"></i>
                    </span>
                    <input class="form-control" type="password" name="password" placeholder="Password" />
                  </div>
                  <span class="glyphicon form-control-feedback"></span>
                  <span class="help-block"></span>
                </div>

                <button class="btn btn-success btn-block" type="submit" style="margin-top:40px;">
                  <span class="fa fa-sign-in"></span> Sign in
                </button>

              </form>

            </div>

          </li>

          <li class="dropdown">

            <a class="dropdown-toggle navbar-menu" href="#" data-toggle="dropdown">
              <span class="fa fa-user-circle-o"></span> Sign Up
            </a>

            <div class="dropdown-menu">

              <h3 class="text-center">Create an Account</h3>

              <form action="sign_up.php" method="get" role="form" style="margin-bottom:15px;">
                <button class="btn btn-success btn-block" type="submit" name="register_type" value="Teacher">
                  <span class="fa fa-user"></span> Teacher
                </button>
              </form>

              <form action="sign_up.php" method="get" role="form" style="margin-bottom:20px;">
                <button class="btn btn-success btn-block" type="submit" name="register_type" value="Student">
                  <span class="fa fa-user"></span> Student
                </button>
              </form>

            </div>

          </li>

        </ul>

      </div>

    </div>

  </nav>

  <div id="log_in_panel" class="panel panel-default visible-xs">

    <div class="panel-body">

      <h3 class="text-center">Get Started Now</h3>

      <form id="log_in_form_phone" method="post" role="form" autocomplete="off" style="margin-bottom:15px;">

        <div class="form-group has-feedback">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-user"></i>
            </span>
            <input class="form-control" type="text" name="username" placeholder="Username" />
          </div>
          <span class="glyphicon form-control-feedback"></span>
          <span class="help-block"></span>
        </div>

        <div class="form-group has-feedback">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-lock"></i>
            </span>
            <input class="form-control" type="password" name="password" placeholder="Password" />
          </div>
          <span class="glyphicon form-control-feedback"></span>
          <span class="help-block"></span>
        </div>

        <button class="btn btn-success btn-block" type="submit" style="margin-top:20px;">
          <span class="fa fa-sign-in"></span> Sign in
        </button>

      </form>

      <p class="text-center" style="font-size:15px; margin-bottom:0; margin-top:20px;">Not yet registered?</p>

      <div class="text-center">

        <form action="sign_up.php" method="get" role="form" style="display:inline;">
          <button class="btn btn-link text-main-green" type="submit" name="register_type" value="Teacher" style="font-size:14px; font-weight:bold;">
            I'm a Teacher
          </button>
        </form>

        <form action="sign_up.php" method="get" role="form" style="display:inline;">
          <button class="btn btn-link text-main-green" type="submit" name="register_type" value="Student" style="font-size:14px; font-weight:bold;">
            I'm a Student
          </button>
        </form>

      </div>

    </div>

  </div>

  <div id="carousel_images" class="carousel slide hidden-xs" data-ride="carousel" data-interval="3000">

    <div class="carousel-inner">

      <div class="item active">
        <img class="carousel-image" src="pictures/modules/image_carousel_1.jpg" alt="Carousel" />
        <div class="container-fluid">
          <div class="carousel-caption">
            <h1 style="letter-spacing:5px;">Wanted to find an easy way to get your students connected?</h1>
          </div>
        </div>
      </div>

      <div class="item">
        <img class="carousel-image" src="pictures/modules/image_carousel_2.jpg" alt="Carousel" />
        <div class="container-fluid">
          <div class="carousel-caption">
            <h1 style="letter-spacing:5px;">In need of a reliable and user-friendly platform for your online classroom?</h1>
          </div>
        </div>
      </div>

      <div class="item">
        <img class="carousel-image" src="pictures/modules/image_carousel_3.jpg" alt="Carousel" />
        <div class="container-fluid">
          <div class="carousel-caption">
            <h1 style="letter-spacing:5px;">Wanted to have a real-time communications and sharing of materials?</h1>
          </div>
        </div>
      </div>

      <div class="item">
        <img class="carousel-image" src="pictures/modules/image_carousel_4.jpg" alt="Carousel" />
        <div class="container-fluid">
          <div class="carousel-caption">
            <h1 style="letter-spacing:5px;">Building connections anytime, anywhere with the use of the modern technology?</h1>
          </div>
        </div>
      </div>

      <div class="item">
        <img class="carousel-image" src="pictures/modules/image_carousel_5.jpg" alt="Carousel" />
        <div class="container-fluid">
          <div class="carousel-caption">
            <h1 style="letter-spacing:5px;">Making it possible to learn regardless of the place?</h1>
          </div>
        </div>
      </div>

      <div class="item">
        <img class="carousel-image" src="pictures/modules/image_carousel_6.jpg" alt="Carousel" />
        <div class="container-fluid">
          <div class="carousel-caption">
            <h1 style="letter-spacing:5px;">Course Management</h1>
          </div>
        </div>
      </div>

      <div class="item">
        <img class="carousel-image" src="pictures/modules/image_carousel_7.jpg" alt="Carousel" />
        <div class="container-fluid">
          <div class="carousel-caption">
            <h1 style="letter-spacing:5px;">Student Management</h1>
          </div>
        </div>
      </div>

      <div class="item">
        <img class="carousel-image" src="pictures/modules/image_carousel_8.jpg" alt="Carousel" />
        <div class="container-fluid">
          <div class="carousel-caption">
            <h1 style="letter-spacing:5px;">Examination Management</h1>
          </div>
        </div>
      </div>

      <div class="item">
        <img class="carousel-image" src="pictures/modules/image_carousel_9.jpg" alt="Carousel" />
        <div class="container-fluid">
          <div class="carousel-caption">
            <h1 style="letter-spacing:5px;">Assessment of Activities</h1>
          </div>
        </div>
      </div>

      <div class="item">
        <img class="carousel-image" src="pictures/modules/image_carousel_10.jpg" alt="Carousel" />
        <div class="container-fluid">
          <div class="carousel-caption">
            <h1 style="letter-spacing:5px;">Course Material Managment</h1>
          </div>
        </div>
      </div>

      <div class="item">
        <img class="carousel-image" src="pictures/modules/image_carousel_11.jpg" alt="Carousel" />
        <div class="container-fluid">
          <div class="carousel-caption">
            <h1 style="letter-spacing:5px;">Feedback Management</h1>
          </div>
        </div>
      </div>

    </div>

  </div>

  <div class="container">

    <div id="overview" class="navbar_content">

      <hr />

      <div class="row">

        <div class="col-md-10 col-sm-12 col-md-offset-1 text-center">
          <h2 class="section-main-heading text-main-green">About LMS</h2>
          <p class="text-muted">
            LMS allow instructors and students to share instructional materials, make class announcements, submit and return course assignments, and communicate with each other online. This study investigated how students use LMS to interact, collaborate, and construct knowledge within the context of a group project but without mediation by the instructor.
          </p>
        </div>

      </div>

      <hr />

      <div class="row" style="margin-top:35px;">

        <div class="col-md-10 col-sm-12 col-md-offset-1">

          <div class="text-center">
            <img class="img-circle img-thumbnail image-overview-1" src="pictures/overview/interactive.jpg" alt="Not Available" />
          </div>

          <div>
            <h2 class="section-heading text-main-green">Interactive</h2>
            <p class="text-justify">
              LMS is an easy way to get your students connected so they can safely collaborate, get and stay organized, and access assignments, quizzes, students progress and announcements. It is also an easier way to communicate to your students through messaging.
            </p>
          </div>

        </div>

      </div>

      <div class="row">

        <div class="panel panel-default" style="margin-top:25px;">

          <div class="panel-body overview_panel">

            <div class="text-center">
              <img class="img-circle img-thumbnail image-overview-2" src="pictures/overview/userfriendly.jpg" alt="Not Available" />
            </div>

            <div class="media">
              <h2 class="section-heading text-main-green" style="position:relative;">User Friendly</h2>
              <p class="text-justify">
                LMS provides a reliable, user friendly learning management platform that everyone can use for free. As a teaching tool, you can use it for quick activities to start a class, post assignments, take an online quiz. It is also an organized way to store files uploaded/downloaded by users.
              </p>
            </div>

          </div>

        </div>

      </div>

      <div class="row">

        <div class="col-md-10 col-sm-12 col-md-offset-1" style="margin-top:25px;">

          <div class="text-center">
            <img class="img-circle img-thumbnail image-overview-1" src="pictures/overview/realtime.jpg" alt="Not Available" />
          </div>

          <div class="media">
            <h2 class="section-heading text-main-green">Real Time</h2>
            <p class="text-justify">
              LMS is a free social learning network where teachers and students can have a real-time communications and sharing of materials. LMS update information at the same rate as they receive data.
            </p>
          </div>

        </div>

      </div>

      <div class="row">

        <div class="panel panel-default" style="margin-top:25px;">

          <div class="panel-body overview_panel">

            <div class="text-center">
              <img class="img-circle img-thumbnail image-overview-2" src="pictures/overview/connect.jpg" alt="Not Available" />
            </div>

            <div class="media">
              <h2 class="section-heading text-main-green" style="position:relative;">Building Connections</h2>
              <p class="text-justify">
                Adding teacher connections is an important step in building your network of resources. Once you find a teacher you would like to connect with, you can request to connect with them by simply clicking the join connection button. Or the teacher can add his/her students. This is one great function that LMS offers.
              </p>
            </div>

          </div>

        </div>

      </div>

      <div class="row">

        <div class="col-md-10 col-sm-12 col-md-offset-1" style="margin-top:25px;">

          <div class="text-center">
            <img class="img-circle img-thumbnail image-overview-1" src="pictures/overview/secured.jpg" alt="Not Available" />
          </div>

          <div class="media">
            <h2 class="section-heading text-main-green">Security and Privacy</h2>
            <p class="text-justify">
              You want your private information to stay that way. LMS is dedicated to keeping you protected - online and off. We make sure that every detail and information you give is secured and private.
            </p>
          </div>

        </div>

      </div>

      <div class="row">

        <div class="panel panel-default" style="margin-top:25px;">

          <div class="panel-body overview_panel">

            <div class="text-center">
              <img class="img-circle img-thumbnail image-overview-2" src="pictures/overview/reliable.jpg" alt="Not Available" />
            </div>

            <div class="media">
              <h2 class="section-heading text-main-green" style="position:relative;">Reliability</h2>
              <p class="text-justify">
                LMS offers a great communication tools to help a teacher to plan. It save lots of time and really engages students. It's all great for teacher to organize leaning materials.
              </p>
            </div>

          </div>

        </div>

      </div>

    </div>

  </div>

  <div class="container">

    <div id="contact_us" class="navbar_content">

      <div class="row">

        <div class="col-md-6 col-sm-12">

          <div class="panel panel-default">

            <div class="panel-body contact_panel">
              <h3 class="text text-main-green" style="margin-left:15px;"><strong>CONTACT DETAILS</strong></h3>

              <a class="text-main-black" href="#" style="text-decoration:none; font-size:15px;">
                <p style="margin-left:25px;"><span class="fa fa-map-marker"></span> <strong>Address:</strong> Alkalde Jose St. Kapasigan, Pasig City</p>
              </a>

              <a class="text-main-black" href="#" style="text-decoration:none; font-size:15px;">
                <p style="margin-left:25px;"><span class="fa fa-envelope"></span> <strong>Email:</strong> tan_riegie@plpasig.edu.ph</p>
              </a>

              <a class="text-main-black" href="#" style="text-decoration:none; font-size:15px;">
                <p style="margin-left:25px;"><span class="fa fa-phone"></span> <strong>Phone:</strong> 888-9999 </p>
              </a>

              <a class="text-main-black" href="#" style="text-decoration:none; font-size:15px;">
                <p style="margin-left:25px;"><span class="fa fa-twitter-square"></span> <strong>Twitter</strong></p>
              </a>

              <a class="text-main-black" href="#" style="text-decoration:none; font-size:15px;">
                <p style="margin-left:25px;"><span class="fa fa-facebook-square"></span> <strong>Facebook</strong></p>
              </a>

            </div>

          </div>

        </div>

        <div class="col-md-6 col-sm-12">

          <div class="panel panel-default">

            <div class="panel-body contact_panel">
              <h4 class="text text-main-green" style="margin-left:15px;"><strong>LEAVE A MESSAGE</strong></h4>

              <form id="contact_form" autocomplete="off">

                <div class="row">

                  <div class="col-md-6">

                    <div class="form-group">
                      <input type="text" class="form-control" placeholder="Your Name *" id="name" required>
                    </div>

                    <div class="form-group">
                      <input type="email" class="form-control" placeholder="Your Email *" id="email" required>
                    </div>

                    <div class="form-group">
                      <input type="text" class="form-control" placeholder="Your Phone *" id="phone" required>
                    </div>

                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <textarea class="form-control" rows="7" placeholder="Your Message *" id="message" required></textarea>
                    </div>
                  </div>

                  <div class="col-md-12 col-sm-12 text-center">
                    <button class="btn btn-success" type="submit">
                      <span class="fa fa-sign-in"></span> Send Message
                    </button>
                  </div>

                </div>

              </form>

            </div>

          </div>

        </div>

      </div>

    </div>

  </div>

  <?php
  require 'footer.php';
  ?>

  <!-- Login Workers -->
  <script src="js/account/login_manager.js"></script>

  <!-- Main Workers -->
  <script src="js/utilities/input.js"></script>

  <script>
    var myId = <?php echo isset($_SESSION['id']) ? $_SESSION['id'] : '0' ?>;

    <?php
    if (isset($_GET['action']) && $_GET['action'] === 'login') {
      echo '$("#log_in_dropdown").click();';
    }
    ?>

    if (myId !== 0) {
      window.location = 'home.php';
    }

    $(document).ready(function() {
      $('.navbar-collapse').on('show.bs.collapse', function(e) {
        $('.navbar-collapse').not(this).collapse('hide');
      });
    });

    $(document).on('click', '[href="#"]', function(e) {
      e.preventDefault();
    });
  </script>

</body>

</html>