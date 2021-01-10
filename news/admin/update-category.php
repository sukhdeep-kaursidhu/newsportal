<?php

  include "header.php"; 

  if($_SESSION["role"] != 1) {
    header("Location: {$hostname}/admin/post.php");
  }

  include 'config.php';

  if(isset($_POST['update'])) {
    $cat_id = mysqli_real_escape_string($conn,$_POST['cat_id']);
    $cat_name = mysqli_real_escape_string($conn,$_POST['cat_name']);

    $updateSql = "UPDATE category SET category_name = '{$cat_name}' WHERE category_id = '{$cat_id}'";

    $updateResult = mysqli_query($conn,$updateSql);

    if($updateResult) {
      header("Location: {$hostname}/admin/category.php");
    } else {
      die("ERROR: ".$updateSql."<br/>".mysqli_error($conn));
    }    
  }

 ?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="adin-heading"> Update Category</h1>
              </div>
              <div class="col-md-offset-3 col-md-6">
                  <?php 

                    if(isset($_GET['id'])) {
                      $ctid = $_GET['id'];
                    } else {
                      $ctid = "1";
                    }

                    $selectSql = "SELECT * FROM category WHERE category_id = '{$ctid}'";

                    $selectResult = mysqli_query($conn,$selectSql);

                    if(!$selectResult) {
                      die("Error: ".$selectSql."<br/>".mysqli_error($conn));
                    }

                    if(mysqli_num_rows($selectResult)>0) {
                      while ($row = mysqli_fetch_assoc($selectResult)) {

                  ?>
                  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post">
                      <div class="form-group">
                          <input type="hidden" name="cat_id"  class="form-control" value="<?php echo $row['category_id']; ?>" placeholder="">
                      </div>
                      <div class="form-group">
                          <label>Category Name</label>
                          <input type="text" name="cat_name" class="form-control" value="<?php 
                          echo $row['category_name']; ?>"  placeholder="" required>
                      </div>
                      <input type="submit" name="update" class="btn btn-primary" value="Update" />
                  </form>
                  <?php 

                      }
                    }

                   ?>
                </div>
              </div>
            </div>
          </div>
<?php include "footer.php"; ?>
