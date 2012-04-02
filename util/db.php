<?php

require_once "config.php";

function DBConnect() {
  global $db_server, $db_username, $db_password, $db_database;
  $db_handle=mysql_connect($db_server, $db_username, $db_password) or die("mrah");
  $db_found=mysql_select_db($db_database, $db_handle);
  if (!$db_found) {
    echo "failure";
  }
}

function DBQuery($query) {
  DBConnect();
  mysql_real_escape_string($query);
  $result = mysql_query($query) or die(mysql_error());
  return $result;
}

function DBQueryIgnoreError($query) {
  DBConnect();
  mysql_real_escape_string($query);
  $result = mysql_query($query);
  return $result;
}

function DBSelectUsers($params) {
  return DBQuery("SELECT * FROM users WHERE ".$params);
}

function DBSelectSchedules($params) {
  return DBQuery("SELECT * FROM schedules WHERE ".$params);
}

function DBSelectCourses($params) {
  return DBQuery("SELECT * FROM courses WHERE ".$params);
}

?>
