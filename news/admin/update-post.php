<?php 

    include "header.php"; 

    include "config.php";

    if(isset($_GET['id'])) {
        $userId = $_GET['id'];
    } else {
        header("Location: {$hostname}/admin/post.php");
    } 

    $selectSql1 = "SELECT * FROM post WHERE post_id = {$userId}";

    $selectResult1 = mysqli_query($conn,$selectSql1);

    if(!$selectResult1) {
        die("ERROR: ".$selectSql1."<br/>".mysqli_error($conn));
    }

?>
<div id="admin-content">
  <div class="container">
  <div class="row">
    <div class="col-md-12">
        <h1 class="admin-heading">Update Post</h1>
    </div>
    <div class="col-md-offset-3 col-md-6">
        <!-- Form for show edit-->
        <?php 

            if(mysqli_num_rows($selectResult1)>0) {
                while($row1 = mysqli_fetch_assoc($selectResult1)) {

         ?>
        <form action="<?php echo htmlspecialchars('updatePost.php'); ?>" method="POST" enctype="multipart/form-data" autocomplete="off">
            <div class="form-group">
                <input type="hidden" name="post_id"  class="form-control" value="<?php echo $row1['post_id']; ?>" placeholder="">
            </div>
            <div class="form-group">
                <input type="hidden" name="cat_id"  class="form-control" value="<?php echo $row1['category']; ?>" placeholder="">
            </div>
            <div class="form-group">
                <label for="exampleInputTile">Title</label>
                <input type="text" name="post_title"  class="form-control" id="exampleInputUsername" value="<?php echo $row1['title']; ?>">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1"> Description</label>
                <textarea name="post_desc" class="form-control"  required rows="5">
                    <?php echo $row1['description']; ?>
                </textarea>
            </div>
            <div class="form-group">
                <label for="exampleInputCategory">Category</label>
                <?php 

                    $selectSql = "SELECT * FROM category";

                    $selectResult = mysqli_query($conn,$selectSql);

                    if(!$selectResult) {
                        die("ERROR: ".$selectSql."<br/>".mysqli_error($conn));
                    }

                    if(mysqli_num_rows($selectResult)>0)
                    {

                 ?>
                <select class="form-control" name="category">
                    <option disabled>Select Category</option>
                    <?php 

                        while($row = mysqli_fetch_assoc($selectResult)) {

                        if($row['category_id'] == $row1['category'])
                        {
                            $selected = "selected";
                        }  else {
                            $selected = "";
                        }

                     ?>
                    <option value="<?php echo $row['category_id']; ?>" <?php echo $selected; ?> ><?php echo $row['category_name']; ?></option>
                    <?php 

                        }

                     ?>
                </select>
                <?php 

                    }

                 ?>
            </div>
            <div class="form-group">
                <label for="image_post">Post image</label>
                <input type="file" name="new-image">
                <img  src="upload/<?php echo $row1['post_img']; ?>" height="150px">
                <input type="hidden" name="old_image" value="<?php echo $row1['post_img']; ?>">
            </div>
            <input type="submit" name="submit" class="btn btn-primary" value="Update" />
        </form>
        <!-- Form End -->
        <?php 

                }
            }

         ?>
      </div>
    </div>
  </div>
</div>
<?php include "footer.php"; ?>
