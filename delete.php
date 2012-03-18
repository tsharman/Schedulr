<?php

session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/lib/model/schedule.php');

$schedule = new Schedule($_GET['schedule']);
if($schedule->getOwnerID() == $_SESSION['user'])
  $schedule->deleteSchedule();
header('Location: /');

?>
