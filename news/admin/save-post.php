<?php 

	session_start();

	include 'config.php';


  if(isset($_POST['submit'])) {

    if(isset($_FILES['fileToUpload'])) {

      $errors = array();

      $file_name = $_FILES['fileToUpload']['name'];
      $file_size = $_FILES['fileToUpload']['size'];
      $file_tmp = $_FILES['fileToUpload']['tmp_name'];
      $file_type = $_FILES['fileToUpload']['type'];
      $file_ext = explode(".",$file_name);
      $file_ext = end($file_ext);
      $file_ext = strtolower($file_ext);
      $extensions = array("jpeg","jpg","png");

      if(in_array($file_ext,$extensions) === false) {
        $errors[] = "The extension is not allowed, Please choose a jpg or png file";
      }

      if($file_size > (1024*1024*2)) {
        $errors[] = "Your file must be 2MB or lower";
      }

      $newName = date("d.m.Y").date("h:i:s")."-".$file_name;

      if(empty($errors) == true) {
        move_uploaded_file($file_tmp,"upload/".$newName);
      } else {
        for ($i = 0; $i <= (count($errors)-1); $i++) {
          echo $errors[$i]."<br/>";
        }
        die();
      }

    }

    $title = mysqli_real_escape_string($conn,$_POST['post_title']);

    $description = mysqli_real_escape_string($conn,$_POST['postdesc']);

    $category = mysqli_real_escape_string($conn,$_POST['category']);

    $date = date("d M, Y");

    $time = date("h:i A");

    $author = $_SESSION['user_id'];

    $insertSql = "INSERT INTO post(title,description,category,post_date,post_time,author,post_img)VALUES('{$title}','{$description}','{$category}','{$date}','{$time}','{$author}','{$newName}');";

    $insertSql .= "UPDATE category SET post = post + 1 WHERE category_id = {$category}";

    $insertResult = mysqli_multi_query($conn,$insertSql);

    if($insertResult) {
      header("Location: {$hostname}/admin/post.php");
    } else {
      die("ERROR: ".$insertSql."<br/>".mysqli_error($conn));
    }

  }

 ?>