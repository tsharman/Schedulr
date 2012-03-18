<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/lib/model/course.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/lib/model/schedule.php');

$schedule = new Schedule($_GET['schedule']);
$schedule->removeCourse($_GET['id']);

?>
