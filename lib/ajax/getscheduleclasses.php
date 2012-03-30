<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/lib/model/course.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/lib/model/schedule.php');

$schedule = new Schedule($_GET['id']);
$courses = $schedule->getCoursesJSON();
echo json_encode($courses);

?>
