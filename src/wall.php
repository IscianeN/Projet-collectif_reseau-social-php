<?php 
    session_start(); 
    include './navrefactoring.php'
?>
        <div id="wrapper">
            <?php

            $userId =intval($_GET['user_id']);

            ?>

            <?php
   
            $mysqli = new mysqli("localhost", "root", "root", "socialnetwork");

            ?>

            <aside>
                <?php          

                $laQuestionEnSql = "SELECT * FROM users WHERE id= '$userId'";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                $user = $lesInformations->fetch_assoc();
    
                ?>
               
                <img src="nft.jpg" alt="Portrait de l'utilisatrice"/>
                <section>
                    <h3>Présentation</h3>
                    <p>Sur cette page vous trouverez tous les message de l'utilisatrice : <?php echo $user['alias']?>
                        (n° <?php echo $userId ?>)
                    </p>
                </section>
            </aside>
            <main>
            <form action="wall.php?user_id=<?php echo $userId ?> " method="post">
                        
                        <dl>
                            <dt><label for='auteur'>Auteur</label></dt>
                            <dd><p name='auteur'>
                                    <?php
                                    echo $user['alias']
                                    ?>
                                </p></dd>
                            <dt><label for='message'>Message</label></dt>
                            <dd><textarea name='message'></textarea></dd>
                            <dt><label for='tag'>Add a tag</label></dt>
                            <dd><input type='text' name='tag' value='add a tag'></dd>
                        </dl>
                        <input type='submit'>
                    </form> 

                <?php

                $enCoursDeTraitement = isset($_POST['message']);
                $tagProcessing = isset($_POST['tag']);

                if ($enCoursDeTraitement && $tagProcessing){
        
                $authorId = $userId ;
                $postContent = $_POST['message'];
                $authorId = intval($mysqli->real_escape_string($authorId));
                $postContent = $mysqli->real_escape_string($postContent);
                $tagContent = $_POST['tag'];
                $tagContent = $mysqli->real_escape_string($tagContent);
                $tagInsert =   "INSERT INTO tags "
                . "(id, label) "
                . "VALUES (NULL, "
                . "'" . $tagContent . "');"
                ;
                 $lInstructionSql = "INSERT INTO posts "
                 . "(id, user_id, content, created, parent_id) "
                 . "VALUES (NULL, "
                 . $authorId . ", "
                 . "'" . $postContent . "', "
                 . "NOW(), "
                 . "NULL);"
                 ;

                $ok = $mysqli->query($lInstructionSql);
                if ( ! $ok)
                {
                    echo "Impossible d'ajouter le message: " . $mysqli->error;
                } else
                {
                    echo "Message posté";
                }
                $tagOK = $mysqli->query($tagInsert);
                if (! $tagOK){
                    echo "Impossible d'ajouter le tag: " . $mysqli->error;
                } else {
                    echo "Tag posté";
                }

                $getPostId = "SELECT posts.id as post_id FROM posts WHERE posts.content = '$postContent'; "; 
                $getTagId = "SELECT tags.id as tag_id FROM tags WHERE tags.label = '$tagContent' ;";
                
                $getPostIdOk = $mysqli->query($getPostId);
                $getTagIdOk = $mysqli->query($getTagId);
                $postResult = $getPostIdOk->fetch_assoc();
                $tagResult = $getTagIdOk->fetch_assoc();
             

              
                  $insertTagPostId = "INSERT INTO posts_tags "
                 . "(id,post_id,tag_id) "
                 . "VALUES (NULL, "
                 . $postResult['post_id'] . ", "
                 . $tagResult['tag_id'] . "); ";
  
                 $tagPostOK = $mysqli->query($insertTagPostId);
                 if (! $tagPostOK){
                     echo "Impossible d'ajouter dans la table: " . $mysqli->error;
                 } else {
                     echo "Réussi";
                 }
            
            }
                 
                $laQuestionEnSql = "
                    SELECT posts.content, posts.created, users.alias as author_name, users.id as author_id, 
                    COUNT(likes.id) as like_number, GROUP_CONCAT(DISTINCT tags.label) AS taglist, GROUP_CONCAT(DISTINCT tags.id) AS taglistid 
                    FROM posts
                    JOIN users ON  users.id=posts.user_id
                    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
                    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
                    LEFT JOIN likes      ON likes.post_id  = posts.id 
                    WHERE posts.user_id='$userId' 
                    GROUP BY posts.id
                    ORDER BY posts.created DESC  
                    ";

                $lesInformations = $mysqli->query($laQuestionEnSql);
                if ( ! $lesInformations)
                {
                    echo("Échec de la requete : " . $mysqli->error);
                }

                while ($post = $lesInformations->fetch_assoc())
                {

                    ?>   
                     
                 
                    <article>
                        <h3>
                        <time><?php echo $post['created']?></time>
                        </h3>
                        <address><a href="wall.php?user_id=<?php echo $post['author_id']?>"><?php echo $post['author_name'] ?></a></address>
                        <div>
                            <p><?php echo $post['content'] ?></p>
                        </div>                                            
                        <footer>
                            <small><?php echo $post["like_number"] ?></small>
                            <a href="tags.php?tag_id=<?php echo $post['taglistid']?>">#<?php echo $post['taglist'] ?></a>
                        </footer>
                    </article>
                <?php } ?>


            </main>
        </div>
    </body>
</html>
