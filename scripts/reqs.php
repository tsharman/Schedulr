<?php
  require_once('../util/db.php');

  $select = "
    SELECT dept, catalognum, section
    FROM courses
    GROUP BY dept, catalognum;
  ";
  $result = DBQuery($select);
  while($row = mysql_fetch_assoc($result)) {
    $dept = $row['dept'];
    $num = $row['catalognum'];
    $section = str_pad($row['section'], 3, "0", STR_PAD_LEFT);
    $filename = 'http://www.lsa.umich.edu/cg/cg_detail.aspx?content=1910';

    $file = file_get_contents($filename.$dept.$num.$section);
    $startpos = strpos($file, "lblDist");
    if($startpos === false) {
      $req = "";
    } else {
      $startpos = strpos($file, ">", $startpos) + 1;
      $endpos = strpos($file, "</span>", $startpos);
      $length = $endpos - $startpos;
      $req = substr($file, $startpos, $length);
      $write = "UPDATE courses SET req='".$req."' WHERE dept='".$dept."' AND catalognum='".$num."'";
      DBQueryIgnoreError($write);
  
    }
      echo "req : ".$req."\n";
      echo "class : ".$dept.$num."\n\n";
  }
  echo "I'm Done";
?>
  
