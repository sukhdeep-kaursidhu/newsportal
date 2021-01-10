<?php

  include "header.php";

  if($_SESSION["role"] != 1) {
    header("Location: {$hostname}/admin/post.php");
  } 

?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-10">
                  <h1 class="admin-heading">All Users</h1>
              </div>
              <div class="col-md-2">
                  <a class="add-new" href="add-user.php">add user</a>
              </div>
              <div class="col-md-12">
                <?php 

                  include "config.php";

                  $limit = 5;

                  if(isset($_GET['page'])) {
                    $page = $_GET['page'];
                  } else {
                    $page = 1;
                  }

                  $offset = ($page - 1) * $limit;

                  $selectSql = "SELECT * FROM user ORDER BY user_id DESC LIMIT {$offset},{$limit}";

                  $selectResult = mysqli_query($conn,$selectSql);

                  if(!$selectResult) {
                    die("Error: ".$selectSql."<br />".mysql_error($conn));
                  }

                  if(mysqli_num_rows($selectResult) > 0) {

                 ?>
                  <table class="content-table">
                      <thead>
                          <th>S.No.</th>
                          <th>Full Name</th>
                          <th>User Name</th>
                          <th>Role</th>
                          <th>Edit</th>
                          <th>Delete</th>
                      </thead>
                      <tbody>
                        <?php 

                          while($row = mysqli_fetch_assoc($selectResult)) {

                         ?>
                          <tr>
                              <td class='id'><?php echo $row['user_id']; ?></td>
                              <td><?php echo $row['first_name']." ".$row['last_name']; ?></td>
                              <td><?php echo $row['username']; ?></td>
                              <td><?php 

                                if($row['role'] == 1) {
                                  echo "admin";
                                } else {
                                  echo "Normal User";
                                }

                               ?></td>
                              <td class='edit'><a href='update-user.php?id=<?php echo $row["user_id"]; ?>'><i class='fa fa-edit'></i></a></td>
                              <td class='delete'><a href='delete-user.php?id=<?php echo $row["user_id"]; ?>'><i class='fa fa-trash-o'></i></a></td>
                          </tr>
                          <?php 

                            }

                           ?>
                      </tbody>
                  </table>
                  <?php 

                    }

                   ?>
                  <?php 

                    $selectSql1 = "SELECT * FROM user";

                    $selectResult1 = mysqli_query($conn,$selectSql1);

                    if(!$selectResult1) {
                      die("Error: ".$selectSql1."<br/>".mysqli_error($conn));
                    }

                    if(mysqli_num_rows($selectResult1) > 0)
                    {
                      $totalRecords = mysqli_num_rows($selectResult1);

                      $totalPages = ceil($totalRecords / $limit);

                      echo "<ul class='pagination admin-pagination'>";

                      if($page > 1) {
                        echo "<li><a href='users.php?page=".($page - 1)."'>Prev</a></li>";
                      }

                      for($i = 1; $i<=$totalPages; $i++)
                      {

                        if($i == $page) {
                          $active = "active";
                        } else {
                          $active = "";
                        }

                        echo "<li class='$active'><a href='users.php?page=$i'>{$i}</a></li>";
                      }

                      if($totalPages > $page) {
                        echo "<li><a href='users.php?page=".($page + 1)."'>Next</a></li>"; 
                      }

                      echo "</ul>";
                    }

                   ?>
              </div>
          </div>
      </div>
  </div>
<?php include "header.php"; ?>
