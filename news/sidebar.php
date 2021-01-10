<div id="sidebar" class="col-md-4">
    <!-- search box -->
    <div class="search-box-container">
        <h4>Search</h4>
        <form class="search-post" action="<?php echo htmlspecialchars('search.php'); ?>" method ="GET">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search .....">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-danger">Search</button>
                </span>
            </div>
        </form>
    </div>
    <!-- /search box -->
    <!-- recent posts box -->
    <div class="recent-post-container">
        <h4>Recent Posts</h4>
        <?php 

            include 'config.php';

            $selectSql = "SELECT * FROM post LEFT JOIN category ON post.category = category.category_id LEFT JOIN user ON post.author = user.user_id ORDER BY post_id DESC LIMIT 5";

            $selectResult = mysqli_query($conn,$selectSql);

            if(!$selectResult) {
                die("ERROR: ".$selectSql."<br/>".mysqli_error($conn));
            }

            if(mysqli_num_rows($selectResult) > 0) {
                while($row = mysqli_fetch_assoc($selectResult)) {

         ?>
        <div class="recent-post">
            <a class="post-img" href="single.php?post=<?php echo $row['post_id']; ?>">
                <img src="admin/upload/<?php echo $row['post_img']; ?>" alt=""/>
            </a>
            <div class="post-content">
                <h5><a href="single.php?post=<?php echo $row['post_id']; ?>"><?php echo $row['title']; ?></a></h5>
                <span>
                    <i class="fa fa-tags" aria-hidden="true"></i>
                    <a href='category.php?category=<?php echo $row["category"] ?>&cname=<?php echo $row["category_name"] ?>'><?php echo $row['category_name']; ?></a>
                </span>
                <span>
                    <i class="fa fa-calendar" aria-hidden="true"></i>
                    <?php echo $row['post_date']; ?>
                </span>
                <a class="read-more" href="single.php?post=<?php echo $row['post_id']; ?>">read more</a>
            </div>
        </div>
        <?php 

                }
            }

         ?>
    </div>
    <!-- /recent posts box -->
</div>
