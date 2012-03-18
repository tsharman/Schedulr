<?php

session_start();
if (!$_SESSION['user'])
  header("Location: /login.php");

require_once($_SERVER['DOCUMENT_ROOT'].'/lib/model/user.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/lib/model/schedule.php');

$user = new User($_SESSION['user']);

// Create a new schedule
if(isset($_GET['new'])) {
  $schedule_id = $user->newSchedule();
  header("Location: /?schedule=".$schedule_id);
  exit;
}

if(isset($_GET['schedule'])) {
  $schedule_id = $_GET['schedule'];
  $schedule = new Schedule($schedule_id);

  if($schedule->getOwnerID() != $_SESSION['user']) {
    // Not correct owner, go to home
    header("Location: /"); 
    exit;
  }
}

require_once($_SERVER['DOCUMENT_ROOT'].'/lib/ui/uicalendar.php');

?>
 
<html>
  <head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
 		<script type="text/javascript">
      <?php
        echo "var user = '".$_SESSION['user']."';"; 
        if($schedule_id)
          echo "var schedule = ".$schedule_id.";"; 
      ?>
    </script>
    <script 
      type="text/javascript" 
      src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js">
    </script>
    <script type="text/javascript" src="/assets/js/schedule.js"></script>
	  <link rel="stylesheet" type="text/css" href="/assets/css/master.css">
	  <link rel="stylesheet" type="text/css" href="/assets/css/calendar.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.min.css">
  </head>
  <body>
    <div class="container">
      <div class="page-header">
        <h1>schedulr</h1>
      </div>
        <div class="row">
          <div class="span12">
        <?php
          $header_buttons = <div class="btn-toolbar"></div>;
          $list = <div class="pull-left btn-group" style="width:500px"></div>;
          
          $user = new User($_SESSION['user']);
          $schedules = $user->getScheduleIDs();

          foreach($schedules as $i => $schedule) {
            $name = "Schedule #".($i+1);
            $url = "/?schedule=".$schedule;
            $item = <a class="btn" href={$url}>{$name}</a>;
            if($_GET['schedule'] == $schedule)
              $item->addClass("btn-info");
            $list->appendChild($item);
          }
          $list->appendChild(<a class="btn" href="/?new=1">New</a>);

          $header_buttons->appendChild($list);
          if(isset($_GET['schedule'])) {
            $url = "/delete.php?schedule=".$_GET['schedule'];
            $header_buttons->appendChild(
              <div class="pull-right btn-group">
                <a href={$url} class="btn btn-danger">
                  Delete this schedule
                </a>
              </div>
            );
          }
          echo $header_buttons;
        ?>
        </div></div>
      <?php if($schedule_id) { ?>
      <br/>
      <div class="row">
        <div class="span8">
          <? echo <sc:calendar schedule={new Schedule($schedule_id)} /> ?>
        </div>
        <div class="span4">
          <input id="search-type" type="hidden" value="basic">
          <div id="basic-search"> 
            <input id="query" type="text" class="input-medium search-query">
            <span class="pull-right btn-group">
              <button class="btn" onclick="search()">Search</button>
              <button class="btn" onclick="showAdvancedSearch()">Advanced</button>
            </span>
          </div>

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
                    <option>=</option>
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
          
          <div id="results" style="margin-top: 20px; height:520px; overflow-y:scroll">
        </div>
      </div>
      <?php } ?>
    </div>
  </body>
</html>
