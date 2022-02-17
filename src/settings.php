<?php 
    session_start(); 
    include './navrefactoring.php'
?>

        <div id="wrapper" class='profile'>


            <aside>
                <img src="nft.jpg" alt="Portrait de l'utilisatrice"/>
                <section>
                    <h3>Introduction</h3>
                    <p>You can get all info related to the user on this page. 
                        n° <?php echo intval($_GET['user_id']) ?></p>

                </section>
            </aside>
            <main>
                <?php
   
                $userId = intval($_GET['user_id']);

            
                $mysqli = new mysqli("localhost", "root", "root", "socialnetwork");

                $getUsers = "
                    SELECT users.*, 
                    count(DISTINCT posts.id) as totalpost, 
                    count(DISTINCT given.post_id) as totalgiven, 
                    count(DISTINCT recieved.user_id) as totalrecieved 
                    FROM users 
                    LEFT JOIN posts ON posts.user_id=users.id 
                    LEFT JOIN likes as given ON given.user_id=users.id 
                    LEFT JOIN likes as recieved ON recieved.post_id=posts.id 
                    WHERE users.id = '$userId' 
                    GROUP BY users.id
                    ";
                $usersResult = $mysqli->query($getUsers);
                if ( ! $usersResult)
                {
                    echo("Cannot do the query " . $mysqli->error);
                }
                $user = $usersResult->fetch_assoc();

                ?>                
                <article class='parameters'>
                    <h3>Parameters</h3>
                    <dl>
                        <dt>Pseudo</dt>
                        <dd><?php echo $user['alias'] ?></dd>
                        <dt>Email</dt>
                        <dd><?php echo $user['email'] ?></dd>
                        <dt>Number of messages</dt>
                        <dd><?php echo $user['totalpost'] ?></dd>
                        <dt>Number of likes given</dt>
                        <dd><?php echo $user['totalgiven'] ?></dd>
                        <dt>Number of likes received</dt>
                        <dd><?php echo $user['totalrecieved'] ?></dd>
                    </dl>

                </article>
            </main>
        </div>
    </body>
</html>
