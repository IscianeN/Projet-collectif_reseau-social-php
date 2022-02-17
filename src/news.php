<?php 
    session_start(); 
    include './navrefactoring.php'
?>

        <div id="wrapper">
            <aside>
                <img src="nft.jpg" alt="User profile image"/>
                <section>
                    <h3>Introduction</h3>
                    <p>You can check all messages posted by all users of this social network.</p>
                </section>
            </aside>
            <main>
              
                <?php
           
                $mysqli = new mysqli("localhost", "root", "root", "socialnetwork" );
            
                if ($mysqli->connect_errno)
                {
                    echo "<article>";
                    echo("Login error: " . $mysqli->connect_error);
                    echo("<p>Hint: Check the parameters of <code>new mysqli(...</code></p>");
                    echo "</article>";
                    exit();
                }

                $getNews = "
                SELECT posts.content, posts.created, 
                users.alias as author_name, 
                users.id as user_id,
                COUNT(likes.id) as like_number, GROUP_CONCAT(DISTINCT tags.label) AS taglist,
                GROUP_CONCAT(DISTINCT tags.id) AS taglistid
                FROM posts
                JOIN users ON  users.id=posts.user_id
                LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
                LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
                LEFT JOIN likes      ON likes.post_id  = posts.id 
                
                GROUP BY posts.id
                ORDER BY posts.created DESC  
            ";
                $newsResult = $mysqli->query($getNews);
                // Vérification
                if ( ! $newsResult)
                {
                    echo "<article>";
                    echo("Cannot do the query: " . $mysqli->error);
                    echo("<p>Hint: Check your SQL queries on phpmyadmin<code>$getNews</code></p>");
                    exit();
                }

 
                while ($post = $newsResult->fetch_assoc())
                {
                   
                    ?>
                    <article>
                        <h3>
                            <time><?php echo $post['created'] ?></time>
                        </h3>
                        <address><a href="wall.php?user_id=<?php echo $post['user_id']?>"><?php echo $post['author_name'] ?></a></address>
                        <div>
                            <p><?php echo $post['content'] ?></p>
                        </div>
                        <footer>
                            <small>♥ <?php echo $post['like_number'] ?></small>
                            <a href="tags.php?tag_id=<?php echo $post['taglistid']?>">#<?php echo $post['taglist'] ?></a>,
                        </footer>
                    </article>
                    <?php
             
                }
                ?>

            </main>
        </div>
    </body>
</html>
