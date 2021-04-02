<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">

  <div class="container-fluid">

    <div class="navbar-header">

      <div class="col-xs-4">
        <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#sidebar_navbar">
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

      <div class="col-xs-4">
        <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#settings_navbar">
          <a class="navbar-menu pull-right" href="#">
            <span class="fa fa-ellipsis-v"></span>
          </a>
        </button>
      </div>

      <a class="navbar-brand hidden-xs" href="index.php">
        <img class="ischool-logo" src="pictures/modules/logo_banner.png" alt="LMS" />
      </a>

    </div>

    <ul class="nav navbar-nav navbar-right hidden-xs">

      <li id="nav_home">
        <a class="navbar-menu" href="home.php" data-toggle="tooltip" data-placement="auto" title="Home">
          <span class="glyphicon glyphicon-home"></span>
        </a>
      </li>

      <li id="nav_messages">
        <a class="navbar-menu" href="messages.php" data-toggle="tooltip" data-placement="auto" title="Messages">
          <span class="fa fa-envelope"></span>
          <span class="badge" id="nav_message_count"></span>
        </a>
      </li>

      <li id="nav_notifications">
        <a class="navbar-menu" href="notifications.php" data-toggle="tooltip" data-placement="auto" title="Notifications">
          <span class="fa fa-bell"></span>
          <span class="badge" id="nav_notification_count"></span>
        </a>
      </li>

      <li id="my_profile_dropdown" class="dropdown">

        <a class="navbar-menu dropdown-toggle" href="#" data-toggle="dropdown">
          <span class="fa fa-user"></span>
          <span id="nav_name"></span> <span class="fa fa-caret-down"></span>
        </a>

        <ul class="dropdown-menu">

          <li id="nav_my_profile" class="text-center">
            <a class="navbar-menu" href="my_profile.php">
              <img class="img-circle" src="">
              <br>
              <b>My Profile</b>
            </a>
          </li>

          <li style="display:none;">
            <a class="navbar-menu" id="nav_activity_log" href="activity_log.php">
              <span class="fa fa-history"></span> Activity Log
            </a>
          </li>

          <li class="divider" style="display:none;"></li>

          <li style="display:none;">
            <a class="navbar-menu" id="nav_help" href="#">
              <span class="fa fa-question-circle"></span> Help
            </a>
          </li>

          <li class="divider"></li>

          <li>
            <a class="navbar-menu" id="nav_sign_out" href="#">
              <span class="fa fa-sign-out"></span> Sign Out
            </a>
          </li>

        </ul>

      </li>

    </ul>

    <div id="sidebar_navbar" class="collapse navbar-collapse text-center">

      <ul class="nav navbar-nav visible-xs">

        <li id="back_2">
          <a class="sidebar-menu" href="my_classrooms.php">
            <span class="fa fa-chevron-left"></span> Back
          </a>
        </li>

        <li id="nav_subject_overview_2">
          <a class="sidebar-menu" href="classrooms_subject_overview.php">
            <span class="fa fa-file-text"></span> Classroom Overview
          </a>
        </li>

        <li id="nav_my_classmates_2">
          <a class="sidebar-menu" href="classrooms_my_classmates.php">
            <span class="fa fa-users"></span>
            <span id="nav_my_classmates_text_2"></span>
            <span class="badge"></span>
          </a>
        </li>

        <li id="nav_announcements_2">
          <a class="sidebar-menu" href="classrooms_announcements.php">
            <span class="fa fa-bullhorn"></span> Announcements
            <span class="badge"></span>
          </a>
        </li>

        <li id="nav_assignments_2">
          <a class="sidebar-menu" href="classrooms_assignments.php">
            <span class="fa fa-book"></span> Assignments
            <span class="badge"></span>
          </a>
        </li>

        <li id="nav_quizzes_2">
          <a class="sidebar-menu" href="classrooms_quizzes.php">
            <span class="fa fa-list-ul"></span> Quizzes
            <span class="badge"></span>
          </a>
        </li>

        <li id="nav_materials_2">
          <a class="sidebar-menu" href="classrooms_materials.php">
            <span class="fa fa-cloud-download"></span> Materials
            <span class="badge"></span>
          </a>
        </li>

        <li id="nav_my_progress_2">
          <a class="sidebar-menu" href="classrooms_my_progress.php">
            <span class="fa fa-line-chart"></span> My Progress
            <span class="badge"></span>
          </a>
        </li>

      </ul>

    </div>

    <div id="settings_navbar" class="collapse navbar-collapse text-center">

      <ul class="nav navbar-nav visible-xs">

        <li id="nav_activity_log_2" class="text-center" style="display:none;">
          <a class="navbar-menu" href="activity_log.php">
            <span class="fa fa-history"></span> Activity Log
          </a>
        </li>

        <li class="divider" style="display:none;"></li>

        <li id="nav_help_2" class="text-center" style="display:none;">
          <a class="navbar-menu" href="#">
            <span class="fa fa-question-circle"></span> Help
          </a>
        </li>

        <li class="divider"></li>

        <li class="text-center">
          <a class="navbar-menu" id="nav_sign_out_2" href="#">
            <span class="fa fa-sign-out"></span> Sign Out
          </a>
        </li>

      </ul>

    </div>

  </div>

</nav>

<nav class="navbar navbar-inverse navbar-fixed-bottom visible-xs" role="navigation">

  <ul class="nav navbar-nav">

    <div class="col-xs-3">
      <li id="nav_home_2">
        <a class="navbar-menu" href="home.php">
          <span class="glyphicon glyphicon-home"></span>
        </a>
      </li>
    </div>

    <div class="col-xs-3">
      <li id="nav_messages_2">
        <a class="navbar-menu" href="messages.php">
          <span class="fa fa-envelope"></span>
          <span class="badge" id="nav_message_count_2"></span>
        </a>
      </li>
    </div>

    <div class="col-xs-3">
      <li id="nav_notifications_2">
        <a class="navbar-menu" href="notifications.php">
          <span class="fa fa-bell"></span>
          <span class="badge" id="nav_notification_count_2"></span>
        </a>
      </li>
    </div>

    <div class="col-xs-3">
      <li id="nav_my_profile" class="text-center">
        <a class="navbar-menu" href="my_profile.php">
          <img class="img-circle" src="">
        </a>
      </li>
    </div>

  </ul>

</nav>