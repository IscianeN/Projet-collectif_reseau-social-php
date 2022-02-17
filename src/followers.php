<?php 
    session_start(); 
    include './navrefactoring.php'
?>


        <div id="wrapper">          
            <aside>
                <img src = "nft.jpg" alt = "User profile image"/>
                <section>
                    <h3>Introduction</h3>
                    <p>You can find all users' messages that you follow.
                        n° <?php echo intval($_GET['user_id']) ?></p>

                </section>
            </aside>
            <main class='contacts'>
                <?php
            
                $userId = intval($_GET['user_id']);
         
                $mysqli = new mysqli("localhost", "root", "root", "socialnetwork");

                $getUserName = "
                    SELECT users.*
                    FROM followers
                    LEFT JOIN users ON users.id=followers.following_user_id
                    WHERE followers.followed_user_id='$userId'
                    GROUP BY users.id
                    ";
                $userNameResult = $mysqli->query($getUserName);
                while ($user = $userNameResult->fetch_assoc())
                {
 
                ?>
                <article>
                    <img src="nft.jpg" alt="blason"/>
                    <p><a href="wall.php?user_id=<?php echo $user['id']?>"><?php echo $user['alias'] ?></a></p>
                    <p>id: <?php echo $user['id'] ?></p>                    
                </article>
                <?php } ?>
            </main>
        </div>
    </body>
</html>