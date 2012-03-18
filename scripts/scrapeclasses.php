<?php

  require_once('../util/db.php');

  if (($handle = fopen("schedule.csv", "r")) !== FALSE) {
    $data = fgetcsv($handle, 1000, ',');
    while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
      list(,,,$courseid,,$catalognum,$section,$title,$type,,$M,$T,$W,$TH,$F,$SA,$SU,,,$time,$location,$prof,$credits) = $data;
      $dept = '"'.substr($data[4], strpos($data[4], '(')+1, -1).'"';
      $title = '"'.$title.'"';
      $prof = '"'.$prof.'"';
      $time = '"'.$time.'"';
      $location = '"'.$location.'"';
      $type = '"'.$type.'"';
      $M = ($M) ? 1 : 0;
      $T = ($T) ? 1 : 0;
      $W = ($W) ? 1 : 0;
      $TH = ($TH) ? 1 : 0;
      $F = ($F) ? 1 : 0;
      $SA = ($SA) ? 1 : 0;
      $SU = ($SU) ? 1 : 0;
      
      $sql = "INSERT INTO courses (title, courseid, catalognum, dept, prof, section, credits, time, M, T, W, TH, F, SA, SU, location, type) VALUES (".$title.",".$courseid.",".$catalognum.",".$dept.",".$prof.",".$section.",".$credits.",".$time.",".$M.",".$T.",".$W.",".$TH.",".$F.",".$SA.",".$SU.",".$location.",".$type.")";
      echo $dept.$catalognum."\n";
      $result = DBQueryIgnoreError($sql);
    }
	}

?>
