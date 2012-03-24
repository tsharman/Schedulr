<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/lib/model/course.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/lib/model/schedule.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/xhp/init.php');

class :sc:course-info extends :x:element {
  attribute
    Course course @required;

  protected function render() {
    $course = $this->getAttribute("course");
    $jsarray = json_encode($course->getDays());
    $coursenum = $course->getDept()." ".$course->getNum();
    $time = $course->getCalendarTime();
    
    $class = "courseInfo well ".$course->getType();
    $ret = 
      <div class={$class}>
        <div class="courseName">
          {$course->getDept()." ".$course->getNum()." - ".$course->getTitle()}
        </div>
        <div class="courseType">{$course->getTypeFull()}</div>
        <div class="courseReq">Reqs: {$course->getReq()}</div>
        <div class="courseSection">Section: {$course->getSection()}</div>
      </div>;

    $ret->setAttribute("data-id", $course->getID());
    return $ret;
  }
}
