<?php 

	session_start();

	include 'config.php';

	if(!isset($_SESSION["username"])) {
		header("Location: {$hostname}/admin");
	}

	if($_SESSION["role"] != 1) {
    	header("Location: {$hostname}/admin/post.php");
  	}

	include 'config.php';

	$ctid = $_GET['id'];

	$deleteSql = "DELETE FROM category WHERE category_id = '{$ctid}'";

	$deleteResult = mysqli_query($conn,$deleteSql);

	if($deleteResult) {
		header("Location: {$hostname}/admin/category.php");
	} else {
		die("ERROR: ".$deleteSql."<br/>".mysqli_error($conn));
	}
 ?>