<?php

session_start();
if (!$_SESSION['user'])
  header("Location: /login");

require_once($_SERVER['DOCUMENT_ROOT'].'/lib/model/user.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/lib/model/schedule.php');

$user = new User($_SESSION['user']);

// Create a new schedule
if(isset($_GET['new'])) {
  $schedule_id = $user->newSchedule();
  header("Location: /schedule/$schedule_id");
  exit;
}

if(isset($_GET['schedule'])) {
  $schedule_id = $_GET['schedule'];
  $schedule = new Schedule($schedule_id);

  if($schedule->getOwnerID() != $_SESSION['user'] && $_SESSION['user'] != 'kgaurav') {
    // Not correct owner, go to home
    header("Location: /"); 
    exit;
  }
}

require_once($_SERVER['DOCUMENT_ROOT'].'/lib/ui/uicalendar.php');

// Create token for posting image data through share button
$token = md5(uniqid());
$_SESSION['img_token'] = $token;
session_write_close();

?>
 
<html>
  <head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <script type="text/javascript">
      var trial = false;
      <?php
        echo "var user = '".$_SESSION['user']."';"; 
        echo "var newuser = ".$user->isNewUser().";";
        if($schedule_id)
          echo "var schedule = ".$schedule_id.";"; 
      ?>
    </script>
    <script 
      type="text/javascript" 
      src="http://code.jquery.com/jquery-latest.min.js">
    </script>
    <script type="text/javascript" src="/assets/js/schedule.js"></script>
    <script type="text/javascript" src="/assets/js/calendar.js"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/master.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/calendar.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.min.css">

    <!-- Google Analytics Code -->
    <script type="text/javascript">

      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-18888523-4']);
      _gaq.push(['_trackPageview']);

      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();

    </script>
  </head>
  <body>
    <div id="shadow" class="hidden">
    </div>
    <div id="alert-message" class="hidden">
    </div>
    <div class="container">
      <div class="page-header">
        <h1>schedulr</h1>
      </div>
      <?php 
        if($_GET['from'] == "fb")
          echo <h3>Successfully posted to Facebook!</h3>;
      ?>

      <!-- Top row buttons -->
      <div class="row">
        <div class="span12">
        <?php
          $header_buttons = <div class="btn-toolbar"></div>;
          $list = <div class="pull-left btn-group"></div>;
          
          $user = new User($_SESSION['user']);
          $schedules = $user->getScheduleIDs();

          foreach($schedules as $i => $schedule) {
            $name = "Schedule #".($i+1);
            $url = "/schedule/$schedule";
            $item = <a class="btn" href={$url}>{$name}</a>;
            if($_GET['schedule'] == $schedule)
              $item->addClass("btn-info");
            $list->appendChild($item);
          }
          $list->appendChild(<a class="btn" href="/schedule/new">New</a>);

          $header_buttons->appendChild($list);
          $right_buttons = <div class="pull-right"></div>;
          if(isset($_GET['schedule'])) {
            $url = "/delete/".$_GET['schedule'];
            $right_buttons->appendChild(
              <div class="btn-group">
                <a onclick="shareSchedule()" class="btn">
                  Share
                </a>
              </div>
            );
            $right_buttons->appendChild(
              <div class="btn-group">
                <a onclick="showSignup()" class="btn">
                  Register
                </a>
              </div>
            );
            $right_buttons->appendChild(
              <div class="btn-group">
                <a href={$url} class="btn btn-danger">
                  Delete
                </a>
              </div>
            );
          }
          $header_buttons->appendChild($right_buttons);
          echo $header_buttons;
        ?>
        </div>
      </div>

      <?php if($schedule_id) { ?>
      <br/>

      <!-- Hidden form for sharing schedule -->
      <?php
      
      $url = "/share/".$_SESSION['user']."/".$schedule_id;

      echo
        <form id="share_form" action={$url} method="post">
          <input type="hidden" name="img_data" id="img_data"></input>
          <input type="hidden" name="img_token" value={$token}></input>
        </form>;
    
      ?>

      <div class="row">

        <!-- Calendar -->
        <div class="span8">
          <div id="div-calendar" style="position: absolute"></div>
          <canvas id="canvas-calendar" width="620px"></canvas>
        </div>

        <!-- Search -->
        <div class="span4">
          <input id="search-type" type="hidden" value="basic">

          <!-- Basic Search Form -->
          <div id="basic-search"> 
            <input id="query" type="text" class="input-medium search-query">
            <span class="pull-right btn-group">
              <button class="btn" onclick="search()">Search</button>
              <button class="btn" onclick="showAdvancedSearch()">Advanced</button>
            </span>
          </div>

          <!-- Advanced Search Form -->
          <div class="form-horizontal hidden" id="advanced-search" >
            <fieldset>
              <div class="control-group">
                <label class="control-label" for="in_dept">Department:</label>
                <div class="controls">
                  <input id="in_dept" type="text" class="input-medium" placeholder="department" />
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="in_num">Course Number:</label>
                <div class="controls">
                  <select id="num_select" style="width: 50px">
                    <option><</option>
                    <option selected>=</option>
                    <option>></option>
                  </select>
                  <input id="in_num" type="text" class="input-small" placeholder="num" />
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="in_dist">Distributions:</label>
                <div class="controls">
                  <select style="width: 145px" multiple="multiple" id="in_dist">
                    <option>CE</option>
                    <option>HU</option>
                    <option>SS</option>
                    <option>ID</option>
                    <option>MSA</option>
                    <option>NS</option>
                  </select>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="in_credits">Credits:</label>
                <div class="controls">
                  <select style="width: 145px" multiple="multiple" id="in_credits">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5+</option>
                  </select>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="in_prof">Professor:</label>
                <div class="controls">
                  <input id="in_prof" type="text" class="input-medium" placeholder="professor" />
                </div>
              </div>
              <div class="form-actions">
                <button class="btn" onclick="search()">Search</button>
              </div>
            </fieldset>
          </div>
          
          <!-- New User Tour -->
          <div id="nux1">
            <br/>
            <h3>Search for a class to get started</h3>
          </div>

          <!-- Search Results -->
          <div id="results"></div>
        </div>
      </div>
      <?php } ?>
    </div>
  </body>
</html>
