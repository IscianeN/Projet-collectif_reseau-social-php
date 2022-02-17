<?php 
    session_start(); 
    include './navrefactoring.php'
?>

        <div id="wrapper">
            <aside>
                <img src="nft.jpg" alt="Portrait de l'utilisatrice"/>
                <section>
                    <h3>Introduction</h3>
                    <p>You can find the list of all users, including you. 
                        n° <?php echo intval($_GET['user_id']) ?>
                        follow the messages
                    </p>

                </section>
            </aside>
            <main class='contacts'>
                <?php

                $userId = intval($_GET['user_id']);

                $mysqli = new mysqli("localhost", "root", "root", "socialnetwork");

                $getUsers = "
                    SELECT users.* 
                    FROM followers 
                    LEFT JOIN users ON users.id=followers.followed_user_id 
                    WHERE followers.following_user_id='$userId'
                    GROUP BY users.id
                    ";
                $usersResult = $mysqli->query($getUsers);
                // Etape 4: à vous de jouer
                //@todo: faire la boucle while de parcours des abonnés et mettre les bonnes valeurs ci dessous 
                while ($post = $usersResult->fetch_assoc())
                {
                ?>
                <article>
                    <img src="nft.jpg" alt="blason"/>
                    <h3><a href="wall.php?user_id=<?php echo $post['id']?>"><?php echo $post['alias']?></a></h3>
                    <p>id:<?php echo $post['id']?></p>                    
                </article>
                <?php } ?>
            </main>
        </div>
    </body>
</html>
