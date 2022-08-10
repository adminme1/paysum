<?php
require_once 'inc/config.inc.php';
if (isset($_SESSION['loggedIn']) && isset($_SESSION['userData'])) {
	unset($_SESSION);
	session_destroy();
	header("location:login.php");
	exit;
}

?>