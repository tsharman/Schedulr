<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/conf/main.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/util/db.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/xhp/init.php');

session_start();
if($_SESSION['user'] != $main_admin)
  header("Location: /login");

?>

<html>
  <head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <script type="text/javascript" src="/assets/js/schedule.js"></script>
    <script type="text/javascript" src="/assets/js/calendar.js"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/master.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/calendar.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.min.css">
  </head>
  <body>
    <div class="container">
      <div class="page-header">
        <h2>
          schedulr
          <small>admin dashboard</small>
        </h2>
      </div>
      <?php
        
        $numUsers = mysql_fetch_row(DBQuery("SELECT COUNT(*) FROM users"));
        $numUsers = $numUsers[0];
        $numUsersText = "Number of Users: $numUsers";
        echo <h2>{$numUsersText}</h2>;

        $numSchedules = mysql_fetch_row(DBQuery("SELECT COUNT(*) FROM schedules"));
        $numSchedules = $numSchedules[0];
        $numSchedulesText = "Number of Schedules: $numSchedules";
        echo <h2>{$numSchedulesText}</h2>;

        $avgSchedules = ($numSchedules)/($numUsers);
        $avgSchedulesText = "Average number of schedules per user: ".round($avgSchedules, 2);
        echo <h2>{$avgSchedulesText}</h2>;

        $numWithSchedules = mysql_fetch_row(DBQuery("SELECT COUNT(DISTINCT owner) FROM schedules"));
        $numWithSchedules = $numWithSchedules[0];
        $percentWithSchedules = ($numWithSchedules / $numUsers) * 100;
        $percentWithSchedulesText = "Percent of users with schedules: ".round($percentWithSchedules)."%";
        echo <h2>{$percentWithSchedulesText}</h2>;

        $numWithClasses = mysql_fetch_row(DBQuery("SELECT COUNT(DISTINCT owner) FROM schedules WHERE id IN (SELECT scheduleid FROM schedule_to_course)"));
        $numWithClasses = $numWithClasses[0];
        $percentWithClasses = ($numWithClasses / $numUsers) * 100;
        $percentWithClassesText = "Percent of users that have added a class: ".round($percentWithClasses)."%";
        echo <h2>{$percentWithClassesText}</h2>;
        
      ?>
    </div>
  </body>
</html>
