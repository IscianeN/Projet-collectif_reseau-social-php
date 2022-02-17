<?php 
    session_start(); 
    include './navrefactoring.php'
?>

        <div id="wrapper">
            <?php
            $userId = intval($_GET['user_id']);
            ?>

            <?php
           
            $mysqli = new mysqli("localhost", "root", "root", "socialnetwork");
            ?>

            <aside>
                <?php
               
                $getUsers = "SELECT * FROM `users` WHERE id= '$userId' ";
                $usersResult = $mysqli->query($getUsers);
                $user = $usersResult->fetch_assoc();
            
                ?>
                <img class = "avatar" src="nft.jpg" alt="User profile image"/>
                <section>
                    <h3>Introduction</h3>
                    <p>You can find all users' messages that you follow.
                        <?php echo $user['alias'] ?> (n° <?php echo $userId ?>)
                    </p>

                </section>
            </aside>
            <main>
                <?php
                
                $postQuery = "
                    SELECT posts.content,
                    posts.created,
                    users.alias as author_name,  
                    count(likes.id) as like_number,  
                    GROUP_CONCAT(DISTINCT tags.label) AS taglist 
                    FROM followers 
                    JOIN users ON users.id=followers.followed_user_id
                    JOIN posts ON posts.user_id=users.id
                    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
                    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
                    LEFT JOIN likes      ON likes.post_id  = posts.id 
                    WHERE followers.following_user_id='$userId' 
                    GROUP BY posts.id
                    ORDER BY posts.created DESC  
                    ";
                $queryResult = $mysqli->query($postQuery);
                if ( ! $queryResult)
                {
                    echo("Cannot do the query: " . $mysqli->error);
                }

                while ($post = $queryResult->fetch_assoc())
                {
                ?>   
                    <article>
                        <h3>
                            <time><?php echo $post['created']?></time>
                        </h3>
                        <address><?php echo $post['author_name'] ?></address>
                        <div>
                            <p><?php echo $post['content'] ?></p>
                        </div>                                            
                        <footer>
                            <small>♥ <?php echo $post['like_number'] ?></small>
                            <a href="tags.php?tag_id=<?php echo $post['tags.id']?>">#<?php echo $post['taglist'] ?></a>, 
                        </footer>
                    </article>
                <?php } ?> 
            

            </main>
        </div>
    </body>
</html>
