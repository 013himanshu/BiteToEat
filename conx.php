<?php

	$user='root';
	$pass='root';
	$db='bitetoeat';
	
	$conn=@mysqli_connect('localhost', $user, $pass, $db);
	if(!$conn){
		die('Sorry! Please Try Again Later.');
	}

?>