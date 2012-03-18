<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/util/db.php');
require_once('user.php');
require_once('schedule.php');

class Course {
	private 
		$id,
		$title,
		$num,
		$dept,
		$prof,
		$req,
		$section,
		$credits,
		$time,
		$location,
		$type,
		$days;
		
	private static $typeMap = array(
		"DIS"=>"Discussion",
		"IND"=>"Individual Instruction",
		"LAB"=>"Laboratory",
		"LEC"=>"Lecture",
		"PSI"=>"Personalized System of Instruction",
		"REC"=>"Recitation",
		"SEM"=>"Seminar"
	);
	
	public function __construct($id) {
		$this->id = $id;
		
		// load all data
		$result = mysql_fetch_assoc(DBSelectCourses("courseid=".$id));
		$this->title = $result['title'];
		$this->num = $result['catalognum'];
		$this->dept = $result['dept'];
		$this->prof = $result['prof'];
		$this->section = $result['section'];
		$this->credits = $result['credits'];
		$this->time = $result['time'];
		$this->location = $result['location'];
		$this->type = $result['type'];
		$this->req = $result['req'];
		
		//add days
		$this->days = array();
		if($result['M']) {$this->days[] = "0";}
		if($result['T']) {$this->days[] = "1";}
		if($result['W']) {$this->days[] = "2";}
		if($result['TH']) {$this->days[] = "3";}
		if($result['F']) {$this->days[] = "4";}
		if($result['SA']) {$this->days[] = "5";}
		if($result['SU']) {$this->days[] = "6";}		
	}
	
	public function getID() {
		return $this->id;
	}
	
	public function getTitle() {
		return $this->title;
	}
	
	public function getDept() {
		return $this->dept;
	}
	
	public function getNum() {
		return $this->num;
	}
	
	public function getSection() {
		return str_pad($this->section, 3, "0", STR_PAD_LEFT);
	}
	
	public function getType() {
		return $this->type;
	}
	
	public function getTypeFull() {
		return self::$typeMap[$this->type];
	}
	
	public function getProf() {
		return $this->prof;
	}
	
	public function getReq() {
		return $this->req;
	}

	public function getTime() {
		return $this->time;
	}

  public function getDays() {
		return $this->days;
	}

  public function getCalendarTime() {
    list($start, $end) = explode("-", $this->time);
		
    // grab am/pm info
		$am_pm = substr($end, -2) == "PM";
    $end = substr($end, 0, -2); 
    
    // deal with half hours
		if(strlen($start) > 2) {
			$start = substr($start, 0, -2) + 0.5;
		}
		if(strlen($end) > 2) {
			$end = substr($end, 0, -2) + 0.5;
		}
    
    // set start am
		$start = 
      ($end > $start && $am_pm && $start!=12 && $start!=12.5 && $end!=12 
       && $end!=12.5) 
        ? $start+12 : $start;
    
    if ($am_pm && $end!=12 && $end!=12.5) {
      $end += 12;
    }
    $duration = ($end - $start);

    return array($start, $duration);
    
  }
	
	public function getLocation() {
		return $this->location;
	}
	
	public function getCredits() {
		return $this->credits;
	}
}

?>
