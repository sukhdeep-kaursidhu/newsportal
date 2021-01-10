<?php 
    include 'header.php';

    include 'config.php';

    if(isset($_GET['search'])) {
        $search_term = mysqli_real_escape_string($conn,$_GET['search']);
    } else {
        header("Location: {$hostname}");
    }

    if(isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 1;
    }

    $limit = 2;

    $offset = ($page-1)*$limit;
?>
    <div id="main-content">
      <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- post-container -->
                <div class="post-container">
                  <h2 class="page-heading">Search : <?php echo strtoupper($search_term); ?></h2>
                  <?php 

                    $selectSql = "SELECT * FROM post LEFT JOIN category ON post.category = category.category_id LEFT JOIN user ON post.author = user.user_id WHERE post.title LIKE '%{$search_term}%' OR post.description LIKE '%{$search_term}%' ORDER BY post_id DESC LIMIT {$offset},{$limit}";

                    $selectResult = mysqli_query($conn,$selectSql);

                    if(!$selectResult) {
                        die("ERROR: ".$selectSql."<br/>".mysqli_error($conn));
                    }

                    if(mysqli_num_rows($selectResult)>0) {
                        while ($row = mysqli_fetch_assoc($selectResult)) {

                   ?>
                    <div class="post-content">
                        <div class="row">
                            <div class="col-md-4">
                                <a class="post-img" href="single.php?post=<?php echo $row['post_id']; ?>"><img src="admin/upload/<?php echo $row['post_img']; ?>" alt=""/></a>
                            </div>
                            <div class="col-md-8">
                                <div class="inner-content clearfix">
                                    <h3><a href='single.php?post=<?php echo $row['post_id']; ?>'><?php echo $row['title']; ?></a></h3>
                                    <div class="post-information">
                                        <span>
                                            <i class="fa fa-tags" aria-hidden="true"></i>
                                            <a href='category.php?category=<?php echo $row["category"]; ?>&cname=<?php echo $row["category_name"]; ?>'><?php echo $row['category_name']; ?></a>
                                        </span>
                                        <span>
                                            <i class="fa fa-user" aria-hidden="true"></i>
                                            <a href='author.php?fname=<?php echo $row["first_name"]; ?>&lname=<?php echo $row["last_name"]; ?>&author=<?php echo $row["author"]; ?>'><?php echo $row['username']; ?></a>
                                        </span>
                                        <span>
                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                            <?php echo $row['post_date']; ?>
                                        </span>
                                        <span>
                                            <i class="fa fa-clock-o" aria-hidden="true"></i>
                                            <?php echo $row['post_time']; ?>
                                        </span>
                                    </div>
                                    <p class="description">
                                        <?php echo $row['description']; ?>
                                    </p>
                                    <a class='read-more pull-right' href='single.php?post=<?php echo $row['post_id']; ?>'>read more</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php 

                            }
                        } else {
                            echo "<h3>NO RECORD FOUND</h3>";
                        }

                     ?>
                    <ul class='pagination'>
                        <?php 

                            $selectSql1 = "SELECT * FROM post WHERE title LIKE '%{$search_term}%' OR description LIKE '%{$search_term}%'";

                            $selectResult1 = mysqli_query($conn,$selectSql1);

                            if(!$selectResult1) {
                                die("ERROR: ".$selectSql1."<br/>".mysqli_error($conn));
                            }

                            if(mysqli_num_rows($selectResult1)>0) {
                                $totalRecords = mysqli_num_rows($selectResult1);

                                $totalPages = ceil($totalRecords/$limit);

                                if($page>1) {
                                    echo "<li><a href='search.php?search=$search_term&page=".($page-1)."'>PREV</a></li>";
                                }

                                for ($i = 1; $i <= $totalPages ; $i++) {
                                    if($i == $page) {
                                        $active = "active";
                                    } else {
                                        $active = "";
                                    }

                                    echo "<li class='$active'><a href='search.php?search=$search_term&page=$i'>$i</a></li>";
                                }

                                if($page < $totalPages)
                                {
                                    echo "<li><a href='search.php?search=$search_term&page=".($page+1)."'>NEXT</a></li>";
                                }
                            }

                         ?>
                    </ul>
                </div><!-- /post-container -->
            </div>
            <?php include 'sidebar.php'; ?>
        </div>
      </div>
    </div>
<?php include 'footer.php'; ?>
