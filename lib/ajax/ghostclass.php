<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/lib/model/course.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/lib/model/schedule.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/lib/ui/uicalendarcourse.php');

$id = $_GET['id'];

echo <sc:calendar-course ghost={true} course={new Course($id)} schedule={$_GET['schedule']} />;

?>
