<?php 

	include 'config.php';

	if(isset($_POST['submit'])) {

		$postId = mysqli_real_escape_string($conn,$_POST['post_id']);

		$postTitle = mysqli_real_escape_string($conn,$_POST['post_title']);

		$postDesc = mysqli_real_escape_string($conn,$_POST['post_desc']);

		$catId = mysqli_real_escape_string($conn,$_POST['cat_id']); 

		$category = mysqli_real_escape_string($conn,$_POST['category']);

		if(empty($_FILES['new-image']['name'])) {
			$newName = $_POST['old_image'];
		} else {
			$errors = array();

			$image_name = $_FILES['new-image']['name'];
			$image_size = $_FILES['new-image']['size'];
			$image_tmp = $_FILES['new-image']['tmp_name'];
			$image_type = $_FILES['new-image']['type'];
			$image_ext = explode(".",$image_name);
			$image_ext = end($image_ext);
			$image_ext = strtolower($image_ext);
			$extensions = array("jpeg","png","jpg");

			if(in_array($image_ext,$extensions) === false) {
				$errors[] = "File Format not Supported, Please choose jpg or png file";
			}

			if($image_size > (1024*1024*2)) {
				$errors[] = "File should be 2MB or lower.";
			}

			$newName = $newName = date("d.m.Y").date("h:i:s")."-".$image_name;

			if(empty($errors) == true) {
				move_uploaded_file($image_tmp,"upload/".$newName);
			} else {
				for ($i = 0; $i <= (count($errors)-1); $i++) {
          			echo $errors[$i]."<br/>";
        		}
        		die();
			}
			
		}

		$updateSql = "UPDATE post SET title='{$postTitle}',description='{$postDesc}',category='{$category}',post_img='{$newName}' WHERE post_id = {$postId};";

		$updateSql .= "UPDATE category SET post = post-1 WHERE category_id = {$catId};";

		$updateSql .= "UPDATE category SET post = post+1 WHERE category_id = {$category}";

		$updateResult = mysqli_multi_query($conn,$updateSql);

		if($updateResult) {
			header("Location: {$hostname}/admin/post.php");
		} else {
			die("ERROR: ".$updateSql."<br/>".mysqli_error($conn));
		}

	}

 ?>