<?php 
    session_start(); 
    include './navrefactoring.php' ?>


        <?php
        $mysqli = new mysqli("localhost", "root", "root", "socialnetwork");
        if ($mysqli->connect_errno)
        {
            echo("Échec de la connexion : " . $mysqli->connect_error);
            exit();
        }
        ?>

        <div id="wrapper" class='admin'>
            <aside>
                <h2>Tags</h2>
                <?php
             
                $getTags = "SELECT * FROM `tags` LIMIT 50";
                $tagsResult = $mysqli->query($getTags);
         
                if ( ! $tagsResult)
                {
                    echo("Cannot do the query: " . $mysqli->error);
                    exit();
                }

            
                while ($tag = $tagsResult->fetch_assoc())
                {
                    
                    ?>
                    <article>
                        <h3><?php echo $tag['label'] ?></h3>
                        <p><?php echo $tag['id'] ?></p>
                        <nav>
                            <a href="tags.php?tag_id=<?php echo $tag['id'] ?>">Messages</a>
                        </nav>
                    </article>
                <?php } ?>
            </aside>
            <main>
                <h2>Users</h2>
                <?php
              
                $getUsers = "SELECT * FROM `users` LIMIT 50";
                $usersResult = $mysqli->query($getUsers);
           
                if ( ! $usersResult)
                {
                    echo("Cannot do the query: " . $mysqli->error);
                    exit();
                }

               
                while ($tag = $usersResult->fetch_assoc())
                {
                    
                    ?>
                    <article>
                        <h3><a href="wall.php?user_id=<?php echo $tag['id'] ?>"><?php echo $tag['alias'] ?></a></h3>
                        <p><?php echo $tag['id'] ?></p>
                        <nav>
                            <a href="wall.php?user_id=<?php echo $_SESSION['connected_id'] ?>">Wall</a>
                            <a href="feed.php?user_id=<?php echo $_SESSION['connected_id'] ?>">Feed</a>
                            <a href="settings.php?user_id=<?php echo $_SESSION['connected_id'] ?>">Parameters</a>
                            <a href="followers.php?user_id=<?php echo $_SESSION['connected_id'] ?>">Followers</a>
                            <a href="subscriptions.php?user_id=<?php echo $_SESSION['connected_id'] ?>">Followed</a>
                        </nav>
                    </article>
                <?php } ?>
            </main>
        </div>
    </body>
</html>
