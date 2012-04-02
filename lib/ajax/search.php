<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/util/db.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/xhp/init.php');

$search = strtoupper($_GET['query']);
  
// let's get through our special cases first:
// tech comm
$search = str_replace(array("TECH COMM", "TECHCOMM"), "TCHNCLCM", $search); 
// calc
if(strstr($search, "CALC")) {
  if($search == "CALC 1" || $search == "CALC1") {
    $query = 'dept="MATH" AND (catalognum=115 OR catalognum=185)';
    echo search($query);
  } else if($search == "CALC 2" || $search == "CALC2") {
    $query = 'dept="MATH" AND (catalognum=116 OR catalognum=186)';
    echo search($query);
  } else if($search == "CALC 3" || $search == "CALC3") {
    $query = 'dept="MATH" AND (catalognum=215 OR catalognum=255 OR catalognum=285)';
    echo search($query);
  } else if($search == "CALC 4" || $search == "CALC4") {
    $query = 'dept="MATH" AND (catalognum=216 OR catalognum=256 OR catalognum=286)';
    echo search($query);
  } else {
    $search = str_replace("CALC", "MATH", $search);
  }     
}
// orgo
if(strstr($search, "ORGO")) {
  if($search == "ORGO 1" || $search == "ORGO1") {
    $query = 'dept="CHEM" AND (catalognum=210 OR catalognum=211)';
    echo search($query);
  } else if($search == "ORGO 2" || $search == "ORGO2") {
    $query = 'dept="CHEM" AND (catalognum=215 OR catalognum=216)';
    echo search($query);
  } else {
    $search = str_replace("ORGO", "CHEM", $search);
  }
}

$searchtry = explode(" ", $search);
if(count($searchtry) == 1) {
  $split = preg_split("/[0-9]/", $search, null, PREG_SPLIT_OFFSET_CAPTURE);
  $dept = $split[0][0];
  if($split[1][1]) {
    $num = substr($search, $split[1][1]-1);
  }
} else if(count($searchtry) == 2) {
  list($dept, $num) = $searchtry;
}
if($dept) {
  // bio
  if($dept == "BIO")
    $dept = "BIOLOGY";
  if($dept == "ANTHRO")
    $dept = "ANTHRCUL";
  $query = 'dept="'.$dept.'"';
  if($num) {
    $query.='AND catalognum='.$num;
  }
  echo search($query);
}

return null;

function search($query) {
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
  return $ret;
}
  
?>
