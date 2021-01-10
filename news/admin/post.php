<?php 

  include "header.php";

  include "config.php"; 

  if(isset($_GET['page'])) {
    $page = $_GET['page'];
  } else {
    $page = 1;
  }

  $limit = 10;

  $offset = ($page-1)*$limit;

?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-10">
                  <h1 class="admin-heading">All Posts</h1>
              </div>
              <div class="col-md-2">
                  <a class="add-new" href="add-post.php">add post</a>
              </div>
              <div class="col-md-12">
                  <table class="content-table">
                      <thead>
                          <th>S.No.</th>
                          <th>Title</th>
                          <th>Category</th>
                          <th>Date</th>
                          <th>Author</th>
                          <th>Edit</th>
                          <th>Delete</th>
                      </thead>
                      <tbody>
                        <?php 

                          if($_SESSION["role"] == 1) {
                            $selectSql = "SELECT * FROM post LEFT JOIN category ON post.category = category.category_id LEFT JOIN user ON post.author = user.user_id ORDER BY post_id DESC LIMIT {$offset},{$limit}";
                          } else {
                            $selectSql = "SELECT * FROM post LEFT JOIN category ON post.category = category.category_id LEFT JOIN user ON post.author = user.user_id WHERE author = {$_SESSION['user_id']} ORDER BY post_id DESC LIMIT {$offset},{$limit}";
                          }

                          

                          $selectResult = mysqli_query($conn,$selectSql);

                          if(!$selectResult) {
                            die("ERROR: ".$selectSql."<br/>".mysqli_error($conn));
                          }

                          if(mysqli_num_rows($selectResult)>0) {
                            while($row = mysqli_fetch_assoc($selectResult)) {

                         ?>
                          <tr>
                              <td class='id'><?php echo $row['post_id']; ?></td>
                              <td><?php echo $row['title']; ?></td>
                              <td><?php echo $row['category_name']; ?></td>
                              <td><?php echo $row['post_date']; ?></td>
                              <td><?php echo $row['username']; ?></td>
                              <td class='edit'><a href='update-post.php?id=<?php echo $row["post_id"]; ?>'><i class='fa fa-edit'></i></a></td>
                              <td class='delete'><a href='delete-post.php?id=<?php echo $row["post_id"]; ?>&catid=<?php echo $row["category"] ?>'><i class='fa fa-trash-o'></i></a></td>
                          </tr>
                          <?php 

                            }
                          }

                          ?>
                      </tbody>
                  </table>
                  <ul class='pagination admin-pagination'>
                      <?php 

                        $selectSql1 = "SELECT * FROM post";

                        $selectResult1 = mysqli_query($conn,$selectSql1);

                        if(!$selectResult1) {
                          die("ERROR: ".$selectSql1."<br/>".mysqli_error($conn));
                        }

                        if($page >1) {
                          echo "<li><a href='post.php?page=".($page-1)."'>PREV</a></li>";
                        }

                        if(mysqli_num_rows($selectResult1)>0)
                        {
                          $totalRecords = mysqli_num_rows($selectResult1);

                          $totalPages = ceil($totalRecords/$limit);

                          for($i = 1; $i <= $totalPages; $i++)
                          {

                            if($i == $page) {
                              $active = "active";
                            } else {
                              $active = "";
                            }

                            echo "<li class='$active'><a href='post.php?page=$i'>$i</a></li>";
                          }
                        }

                        if($page < $totalPages) {
                          echo "<li><a href='post.php?page=".($page+1)."'>NEXT</a></li>";
                        }

                       ?>
                  </ul>
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
