<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/util/db.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/xhp/init.php');

$dept = $_GET['dept'];
$num_cmp = $_GET['num_select'];
$num = $_GET['num'];
$dist = $_GET['dist'];
$credits = $_GET['credits'];
$prof = $_GET['prof'];

if($dept) {
  $query .= "dept='".strtoupper($dept)."'";
}
if($num) {
  if($query)
    $query .= " AND ";
  $query .= "catalognum".$num_cmp.$num;
}
if($dist && $dist != "null") {
  if($query)
    $query .= " AND ";

  $dist_arr = explode(",", $dist);
  $query .= "(";
  foreach($dist_arr as $i => $dist_single) {
    if($i > 0) {
      $query .= " OR ";
    }
    $query .= "req='".$dist_single."'";
  }
  $query .= ")";
}
if($credits && $credits != "null") {
  if($query)
    $query .= " AND ";

  $credits_arr = explode(",", $credits);
  $query .= "(";
  foreach($credits_arr as $i => $credits_single) {
    if($i > 0) {
      $query .= " OR ";
    }
    $query .= "credits=".$credits_single;
  }
  $query .= ")";
}
if($prof) {
  if($query)
    $query .= " AND ";
  
  $query .= "prof LIKE '".$prof."'";
}

$query .= " GROUP BY courseid";
$query .= " ORDER BY dept, catalognum, section";
$result = DBSelectCourses($query);
$ret = <x:frag></x:frag>;
if(mysql_num_rows($result) == 0) {
  return null;
}
while($row = mysql_fetch_assoc($result)) {
  $courseID = $row['courseid'];
  require_once($_SERVER['DOCUMENT_ROOT'].'/lib/model/course.php');
  require_once($_SERVER['DOCUMENT_ROOT'].'/lib/ui/uiCourseInfo.php');
  $ret->appendChild(
      <sc:course-info course={new Course($courseID)} />
  );
}	

echo $ret;

