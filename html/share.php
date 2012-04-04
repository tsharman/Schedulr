<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/conf/main.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/lib/model/schedule.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/xhp/init.php');

$user = $_GET['user'];
$schedule = $_GET['schedule'];
$filename = $main_base_url."/data/images/".$user.$schedule.".png";


// the schedule needs to belong to the owner
$schedule_obj = new Schedule($schedule);
if($schedule_obj->getOwnerID() != $user)
  header("Location: /");

// User just shared schedule, update or create the image.
if(isset($_POST['img_token'])) {
  session_start();
  $token = $_SESSION['img_token'];

  if($_POST['img_token'] == $token) {
    // write to an image file
    $write_file = $main_directory."/data/images/".$user.$schedule.".png";
    $img_data = $_POST['img_data'];
    $uri = substr($img_data, strpos($img_data, ",") + 1);
    file_put_contents($write_file, base64_decode($uri));
    chmod($filename, 0755);
  } else {
    // CSRF attack!
  }
}

?>

<html>
  <head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="/assets/css/master.css">
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
    <div class="container">
      <div class="page-header">
        <h1>
          schedulr
          <small>
            share your schedule
            <?php 
              // Sign up button for people visiting the page that aren't logged in
              if(!isset($_SESSION['user']))
                echo <a class="pull-right btn" href="/login/">Sign up</a>;
            ?>
          </small>
        </h1>
      </div>

      <!-- Share options -->
      <?php 
        if($user == $_SESSION['user']) { 
          $url = "/html/sharetofb?user=$user&schedule=$schedule";
          echo
            <div class="row">
              <div class="span8 offset2">
                <p>Share this page's URL with your friends or: </p>
                <a class="btn" href={$url}>Post to Facebook</a>
              </div>
            </div>;
          echo <br/>;
      } 

      ?>


      <!-- Calendar -->
      <div class="row">
        <div class="span8 offset2">
          <?php 
            echo "<img src=$filename />"; 
          ?>
        </div>
      </div>

    </div>
  </body>
</html>
