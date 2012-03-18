<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/util/db.php');

echo mysql_num_rows(DBSelectUsers("uniqname='".$_GET['uniqname']."'"));

?>
