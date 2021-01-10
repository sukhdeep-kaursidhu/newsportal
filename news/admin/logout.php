<?php 
		
	session_start();

	include 'config.php';

	if(!isset($_SESSION["username"])) {
		header("Location: {$hostname}/admin");
	}
	
	session_unset();

	session_destroy();

	header("Location: {$hostname}/admin"); 

 ?>