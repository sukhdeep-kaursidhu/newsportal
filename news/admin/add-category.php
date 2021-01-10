<?php
  
  include "header.php";

  if($_SESSION["role"] != 1) {
    header("Location: {$hostname}/admin/post.php");
  } 

  include 'config.php';

  if(isset($_POST['save'])) {

    $category = mysqli_real_escape_string($conn,$_POST['cat']);

    $selectSql = "SELECT * FROM category WHERE category_name = '{$category}'";

    $selectResult = mysqli_query($conn,$selectSql);

    if(!$selectResult) {
      die("ERROR: ".$selectSql."<br/>".mysqli_error($conn));
    }

    if(mysqli_num_rows($selectResult)>0) {
      echo "<script>alert('Category Exist');</script>";
    } else {
      $insertSql = "INSERT INTO category(category_name) VALUES ('{$category}')";

      $insertResult = mysqli_query($conn,$insertSql);

      if($insertResult) {
        header("Location: {$hostname}/admin/category.php");
      } else {
        die("ERROR: ".$inserSql."<br/>".mysqli_error($conn));
      }
    }

  }

?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="admin-heading">Add New Category</h1>
              </div>
              <div class="col-md-offset-3 col-md-6">
                  <!-- Form Start -->
                  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" autocomplete="off">
                      <div class="form-group">
                          <label>Category Name</label>
                          <input type="text" name="cat" class="form-control" placeholder="Category Name" required>
                      </div>
                      <input type="submit" name="save" class="btn btn-primary" value="Save" required />
                  </form>
                  <!-- /Form End -->
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
