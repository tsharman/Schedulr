<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/lib/model/course.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/lib/model/schedule.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/xhp/init.php');

class :sc:calendar-course extends :x:element {
  attribute
    Course course @required,
    int schedule @required,
    bool ghost = false;

  protected function render() {
    $course = $this->getAttribute("course");
    $schedule = $this->getAttribute("schedule");
    $time = $course->getCalendarTime();
    $top = (($time[0]-8) * 50) + 35;
    $length = ($time[1] * 50) - 11;
    $days = $course->getDays();
    $class = "calendarCourse ".$course->getID();
    if($this->getAttribute("ghost"))
      $class .= " ghost";
    $ret = <x:frag></x:frag>;
    foreach($days as $day) {
      $left = ($day * 112) + 60;
      $style = "left: ".$left."px; top: ".$top."px; height: ".$length."px;";
      $title = $course->getDept()." ".$course->getNum()." - ".$course->getTitle();
      $onclick = "removeClass(".$course->getID().")";
      $course_markup = 
        <div class={$class} style={$style}>
          <a style="margin-top: -5px;" class="close" onclick={$onclick}>&times;</a>
          <div class="calendarCourseName">
            {$course->getDept()." ".$course->getNum()}
          </div>
          <div class="calendarCourseLoc">{$course->getLocation()}</div>
        </div>;
      $ret->appendChild($course_markup);
    }
    return $ret;
  }
}
