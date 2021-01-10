<?php 

	$hostname = "http://localhost/news";

	$conn = mysqli_connect('localhost','root','','news-site');

	if(!$conn) {
		die("Connection Failure: ".mysqli_connect_error($conn));
	}

 ?>