<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/lib/model/user.php');
session_start();
$user = new User($_SESSION['user']);
$user->removeNewUser();

?>
