<?php 

  include "header.php";

  include "config.php"; 

  if($_SESSION["role"] != 1) {
    header("Location: {$hostname}/admin/post.php");
  }

  if(isset($_POST['submit'])) {

    $user_id = mysqli_real_escape_string($conn,$_POST['user_id']);

    $fName= mysqli_real_escape_string($conn,$_POST['f_name']);

    $lName = mysqli_real_escape_string($conn,$_POST['l_name']);

    $userName = mysqli_real_escape_string($conn,$_POST['username']);

    $role = mysqli_real_escape_string($conn,$_POST['role']);    

    $updateSql = "UPDATE user SET first_name = '{$fName}', last_name = '{$lName}', username = '{$userName}', role = '{$role}' WHERE user_id = '{$user_id}'";

    $updateResult = mysqli_query($conn,$updateSql);

    if($updateResult) {
      header("Location: {$hostname}/admin/users.php");
    } else {
      die("Error: ".$updateSql."<br/>".mysqli_error($conn));
    }   
  }
?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="admin-heading">Modify User Details</h1>
              </div>
              <div class="col-md-offset-4 col-md-4">
                <!-- Select and update query using php and fetch the value of user_id from the Url using GET Method -->
                <?php 

                  $userId = $_GET['id'];

                  $selectSql = "SELECT * FROM user WHERE user_id = '{$userId}'";

                  $selectResult = mysqli_query($conn,$selectSql);

                  if(!$selectResult) {
                    die("Error: ".$selectSql."<br/>".mysqli_error($conn));
                  }

                  if(mysqli_num_rows($selectResult) > 0) {
                    while($row = mysqli_fetch_assoc($selectResult)) {

                 ?>
                  <!-- Form Start -->
                  <form  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method ="POST">
                      <div class="form-group">
                          <input type="hidden" name="user_id"  class="form-control" value="<?php echo $row['user_id']; ?>" placeholder="" >
                      </div>
                          <div class="form-group">
                          <label>First Name</label>
                          <input type="text" name="f_name" class="form-control" value="<?php echo $row['first_name']; ?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>Last Name</label>
                          <input type="text" name="l_name" class="form-control" value="<?php echo $row['last_name']; ?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>User Name</label>
                          <input type="text" name="username" class="form-control" value="<?php echo $row['username']; ?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>User Role</label>
                          <select class="form-control" name="role">
                              <?php 

                                if($row['role'] == 1) {
                                  echo "<option value='0'>Normal User</option>
                                        <option value='1' selected>Admin</option>";
                                } else {
                                   echo "<option value='0' selected>Normal User</option>
                                         <option value='1'>Admin</option>";
                                }

                               ?>
                          </select>
                      </div>
                      <input type="submit" name="submit" class="btn btn-primary" value="Update" required />
                  </form>
                  <!-- /Form -->
                  <?php 

                      }
                    }

                   ?>
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
