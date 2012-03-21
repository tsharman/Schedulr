<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/lib/model/course.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/lib/model/schedule.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/xhp/init.php');

require_once('uicalendarcourse.php');

class :sc:calendar extends :x:element {
  attribute
    Schedule schedule;

  protected function render() {
    $header = 
      <thead>
        <tr>
          <th style="width: 60px"></th>
          <th style="width: 112px">M</th>
          <th style="width: 112px">Tu</th>
          <th style="width: 112px">W</th>
          <th style="width: 112px">Th</th>
          <th style="width: 112px">F</th>
        </tr>
      </thead>;
    $body = <tbody></tbody>;
    for($i = 8; $i < 19; $i++) {
      $time = ($i == 12) ? $i : $i % 12;
      $row = 
        <tr>
          <th>{$time}</th>
        </tr>;
      for($j = 0; $j < 5; $j++) {
        $cell = <th></th>;
        $row->appendChild($cell);
      }
      $body->appendChild($row);
    }
    $ret = <div id="calendarBackground" style="position: relative;"></div>;
    $ret->appendChild(
      <table class="table table-bordered">
        {$header}
        {$body}
      </table>
    );

    
    // display classes
    if($this->getAttribute("schedule")) {
      $schedule = $this->getAttribute("schedule");
      foreach ($schedule->getCourses() as $course) {
        $ret->appendChild(
          <sc:calendar-course course={$course} />
        );
      }
    }

    return $ret;
  }
}
