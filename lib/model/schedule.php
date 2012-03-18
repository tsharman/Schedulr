<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/util/db.php');
require_once('user.php');
require_once('course.php');

class Schedule {
	private 
		$id;
		
	public function __construct($id) {
		$this->id = $id;
	}
	
	public function getID() {
		return $this->id;
	}
	
	public function getOwnerID() {
		$result = mysql_fetch_assoc(DBSelectSchedules("id=".$this->id));
		return $result['owner'];
	}
	
	public function getOwner() {
		return new User($this->getOwnerID());
	}
	
	public function getCourseIDs() {
		$result = 
      DBQuery("SELECT * FROM schedule_to_course WHERE scheduleid=".$this->id);
		$courseIDs = array();
		while($row = mysql_fetch_assoc($result)) {
			$courseIDs[] = $row['courseid'];
		}
		return $courseIDs;
	}
	
	public function getCourses() {
		$courseIDs = $this->getCourseIDs();
		$courses = array();
		foreach($courseIDs as $courseID) {
			$courses[] = new Course($courseID);
		}
		return $courses;
	}
	
	public function addCourse($courseID) {
    // Check if it's already in the schedule
    $courseIDs = $this->getCourseIDs();
    if(!in_array($courseID, $courseIDs)) 
      DBQuery("INSERT INTO schedule_to_course VALUES (".$this->id.",
                                                      ".$courseID.")");
	}

  public function removeCourse($courseID) {
    DBQuery("DELETE FROM schedule_to_course ".
                   "WHERE scheduleid=".$this->id." ". 
                   "AND courseid=".$courseID);
  }

  public function numCredits() {
    $courses = $this->getCourses();
    $credits = 0;
    $coursenum = array();
    foreach ($courses as $course) {
      $num = $course->getDept() . $course->getNum();
      if(!in_array($num, $coursenum)) {
        $coursenum[] = $num;
        $credits += $course->getCredits();
      }
    }
    return $credits;
  }

  public function hasCourse($coursenum) {
    $courses = $this->getCourses();
    foreach ($courses as $course) {
      $num = $course->getDept() + $course->getNum();
      if ($coursenum == $num)
        return true;
    }
    return false;
  }

  public function deleteSchedule() {
		DBQuery("DELETE FROM schedules WHERE id = ".$this->id);
		DBQuery("DELETE FROM schedule_to_course WHERE scheduleid = ".$this->id);
  }
}

?>
