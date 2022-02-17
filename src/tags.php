<?php 
    session_start(); 
    include './navrefactoring.php'
?>

        <div id="wrapper">
            <?php

            $tagId = intval($_GET['tag_id']);
            ?>
            <?php

            $mysqli = new mysqli("localhost", "root", "root", "socialnetwork");
            ?>

            <aside>
                <?php
      
                $getTags = "SELECT * FROM tags WHERE id= '$tagId' ";
                $tagsResult = $mysqli->query($getTags);
                $tag = $tagsResult->fetch_assoc();
       
                ?>
                <img src="nft.jpg" alt="User profile image"/>
                <section>
                    <h3>Introduction</h3>
                    <p>On this page you can access all posts with dedicated #<?php echo $tag['label']?>
                        (n° <?php echo $tagId ?>)
                    </p>

                </section>
            </aside>
            <main>
                <?php
            
                $getPosts = "
                    SELECT posts.content,
                    posts.created,
                    users.alias as author_name,
                    users.id as author_id,  
                    count(likes.id) as like_number,  
                    GROUP_CONCAT(DISTINCT tags.label) AS taglist 
                    FROM posts_tags as filter 
                    JOIN posts ON posts.id=filter.post_id
                    JOIN users ON users.id=posts.user_id
                    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
                    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
                    LEFT JOIN likes      ON likes.post_id  = posts.id 
                    WHERE filter.tag_id = '$tagId' 
                    GROUP BY posts.id
                    ORDER BY posts.created DESC  
                    ";
                $postsResult = $mysqli->query($getPosts);
                if ( ! $postsResult)
                {
                    echo("Cannot do the query: " . $mysqli->error);
                }

              
                while ($post = $postsResult->fetch_assoc())
                {

                    /* echo "<pre>" . print_r($post, 1) . "</pre>"; */
                    ?>                
                    <article>
                        <h3>
                        <time><?php echo $post['created'] ?></time>
                        </h3>
                        <address><a href="wall.php?user_id=<?php echo $post['author_id']?>"><?php echo $post['author_name'] ?></a></address>
                        <div>
                            <p><?php echo $post['content'] ?></p>
                        </div>                                            
                        <footer>
                        <small><?php echo $post["like_number"] ?></small>
                        <a href="">#<?php echo $post['taglist']?></a>
                        </footer>
                    </article>
                <?php } ?>


            </main>
        </div>
    </body>
</html>