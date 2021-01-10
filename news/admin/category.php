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
                <h1 class="admin-heading">All Categories</h1>
            </div>
            <div class="col-md-2">
                <a class="add-new" href="add-category.php">add category</a>
            </div>
            <div class="col-md-12">
                <table class="content-table">
                    <thead>
                        <th>S.No.</th>
                        <th>Category Name</th>
                        <th>No. of Posts</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </thead>
                    <?php 

                        include 'config.php';

                        if(isset($_GET['page'])) {
                            $page = $_GET['page'];
                        } else {
                            $page = 1;
                        }

                        $limit = 3;

                        $offset = ($page-1)*$limit;

                        $selectSql = "SELECT * FROM category ORDER BY category_id DESC LIMIT {$offset},{$limit}";

                        $selectResult = mysqli_query($conn,$selectSql);

                        if(!$selectResult) {
                            die("ERROR: ".$selectSql."<br />".mysqli_error($conn));
                        }

                        if(mysqli_num_rows($selectResult)>0) {

                     ?>
                    <tbody>
                        <?php 

                            while($row = mysqli_fetch_assoc($selectResult)) {

                        ?>
                        <tr>
                            <td class='id'><?php echo $row['category_id']; ?></td>
                            <td><?php echo $row['category_name']; ?></td>
                            <td><?php echo $row['post']; ?></td>
                            <td class='edit'><a href='update-category.php?id=<?php echo $row["category_id"]; ?>'><i class='fa fa-edit'></i></a></td>
                            <td class='delete'><a href='delete-category.php?id=<?php echo $row['category_id']; ?>'><i class='fa fa-trash-o'></i></a></td>
                        </tr>
                        <?php 

                            }

                        ?>
                    </tbody>
                    <?php 

                        }

                     ?>
                </table>
                <?php 

                    $selectSql1 = "SELECT * FROM category";

                    $selectResult1 = mysqli_query($conn,$selectSql1);

                    if(!$selectResult1) {
                        die("ERROR: ".$selectSql1."<br />".mysqli_error($conn));
                    }

                 ?>
                <ul class='pagination admin-pagination'>
                    <?php 

                        if(mysqli_num_rows($selectResult1)>0) {
                            $totalRecords = mysqli_num_rows($selectResult1);

                            $totalPages = ceil($totalRecords/$limit);

                            if($page>1) {
                                echo "<li><a href='category.php?page=".($page-1)."'>Prev</a></li>";                                
                            }

                            for($i = 1;$i <= $totalPages;$i++) {

                                if($i == $page) {
                                    $active = "active";
                                } else {
                                    $active = "";
                                }

                                echo "<li class='$active'><a href='category.php?page=$i'>$i</a></li>";
                            }

                            if($page<$totalPages) {
                                echo "<li><a href='category.php?page=".($page+1)."'>Next</a></li>";                                
                            }
                        }

                     ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>
