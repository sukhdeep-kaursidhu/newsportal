<?php 
	
	session_start();

	include 'config.php';

	if(!isset($_SESSION["username"])) {
		header("Location: {$hostname}/admin");
	}

	if($_SESSION["role"] != 1) {
    	header("Location: {$hostname}/admin/post.php");
  	}
	
	$userId = $_GET['id'];

	$deleteSql = "DELETE FROM user WHERE user_id = '{$userId}'";

	$deleteResult = mysqli_query($conn,$deleteSql);

	if($deleteResult) {
		header("Location: {$hostname}/admin/users.php");
	} else {
		die("Error: ".$deleteSql."<br/>".mysqli_error($conn));
	}

	mysqli_close($conn);
 ?>