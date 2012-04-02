<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/util/db.php');
require_once('schedule.php');
require_once('course.php');

class User {
  private 
    $uniqname;
  
  public function __construct($uniqname) {
    $this->uniqname = $uniqname;
  }
  
  public function getUniqname() {
    return $this->uniqname;
  }
  
  public function getScheduleIDs() {
    $result = DBSelectSchedules("owner='".$this->uniqname."' order by id");
    $scheduleIDs = array();
    while ($row = mysql_fetch_assoc($result)) {
      $scheduleIDs[] = $row['id'];
    }
    return $scheduleIDs;
  }
  
  public function getSchedules() {
    $scheduleIDs = $this->getScheduleIDs();
    $schedules = array();
    foreach ($scheduleIDs as $scheduleID) {
      $schedules[] = new Schedule($scheduleID);
    }
    
    return $schedules;
  }
  
  public function newSchedule() {
    DBQuery("INSERT INTO schedules VALUES ('','".$this->uniqname."')");
    return mysql_insert_id();
  }
  
  public function cloneSchedule(Schedule $schedule) {
    $query = "INSERT INTO schedules VALUES ('','".$this->uniqname."')";
    DBQuery($query);
    $new_id = mysql_insert_id();
    $courses = $schedule->getCourseIDs();
    foreach($courses as $course) {
      $query = "INSERT INTO schedule_to_course VALUES (".$new_id.",".$course.")";
      DBQuery($query);
    }
    return $new_id;
  }
}

?>
