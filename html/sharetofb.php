<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/conf/fb.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/conf/main.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/lib/model/schedule.php');

$user = $_GET['user'];
$schedule = $_GET['schedule'];
$filename = $main_directory."/data/images/".$user.$schedule.".png";

// You can only post your own schedules
session_start();
if($user != $_SESSION['user']) {
  header("Location: /");
}

// Schedule must belong to user
$schedule_obj = new Schedule($schedule);
if($schedule_obj->getOwnerID() != $user) {
  header("Location: /");
}

$code = $_REQUEST["code"];

// Obtain the access_token with publish_stream permission 
if(empty($code)){ 
  $state = md5(uniqid());
  session_start();
  $_SESSION['state_token'] = $state;
  session_write_close();

  $redirect_url = $main_base_url . "/html/sharetofb.php?user=" . $user . "&schedule=" . $schedule;
  $dialog_url= "http://www.facebook.com/dialog/oauth?"
    . "client_id=" .  $fb_app_id 
    . "&redirect_uri=" . urlencode($redirect_url)
    . "&state=" . $state
    . "&scope=publish_stream";
  echo("<script>top.location.href='" . $dialog_url 
      . "'</script>");
} else {
  if($_REQUEST['state'] == $_SESSION['state_token']) {
    $redirect_url = $main_base_url . "/html/sharetofb.php?user=" . $user . "&schedule=" . $schedule;
    $token_url="https://graph.facebook.com/oauth/access_token?"
      . "client_id=" . $fb_app_id 
      . "&client_secret=" . $fb_app_secret
      . "&redirect_uri=" . urlencode($redirect_url)
      . "&code=" . $code;
    $response = file_get_contents($token_url);
    $params = null;
    parse_str($response, $params);
    $access_token = $params['access_token'];
    
    // Show photo upload form to user and post to the Graph URL
    $graph_url= "https://graph.facebook.com/me/photos?"
      . "access_token=" .$access_token;

    // post photo
    $message = "I planned this schedule out on Schedulr. Check it out at http://theschedulr.com";
    $ch = curl_init($graph_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, array("source"=>"@".$filename, "message"=>$message));
    $result = curl_exec($ch);
    curl_close($ch);
  } else {
    // CSRF attack
  }
  header("Location: /?from=fb");
}

