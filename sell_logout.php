<?php 
	session_start();
	session_unset();
	session_destroy();
	header("Location:sell.php");
	exit(0);
?>