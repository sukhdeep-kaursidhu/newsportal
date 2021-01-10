<?php 

    include 'header.php';

    include 'config.php'; 

    if(isset($_GET['post'])) {
        $postId = $_GET['post'];
    } else {
        header("Location: {$hostname}/index.php");
    }

?>
    <div id="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                  <!-- post-container -->
                    <div class="post-container">
                        <?php 

                            $selectSql = "SELECT * FROM post LEFT JOIN category ON post.category = category.category_id LEFT JOIN user ON post.author = user.user_id WHERE post_id = {$postId}";

                            $selectResult = mysqli_query($conn,$selectSql);

                            if(!$selectResult) {
                                die("ERROR: ".$selectSql."<br/>".mysqli_error($conn));
                            }

                            if(mysqli_num_rows($selectResult) > 0) {
                                while($row = mysqli_fetch_assoc($selectResult)) {

                         ?>
                        <div class="post-content single-post">
                            <h3><?php echo $row['title']; ?></h3>
                            <div class="post-information">
                                <span>
                                    <i class="fa fa-tags" aria-hidden="true"></i>
                                    <?php echo $row['category_name']; ?>
                                </span>
                                <span>
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    <a href='author.php?author=<?php echo $row['author']; ?>'><?php echo $row['username']; ?></a>
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
                            <img class="single-feature-image" src="admin/upload/<?php echo $row['post_img'] ?>" alt=""/>
                            <p class="description">
                                <?php echo $row['description']; ?>
                            </p>
                        </div>
                        <?php 

                                }
                            }

                         ?>
                    </div>
                    <!-- /post-container -->
                </div>
                <?php include 'sidebar.php'; ?>
            </div>
        </div>
    </div>
<?php include 'footer.php'; ?>
