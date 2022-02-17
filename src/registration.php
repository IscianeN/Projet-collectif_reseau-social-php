<?php 
    session_start(); 
    include './navrefactoring.php'
?>



        <div id="wrapper" >

            <aside>
                <h2>Introduction</h2>
                <p>Welcome to the AAAMAzing social network.</p>
            </aside>
            <main>
                <article>
                    <h2>Sign up</h2>
                    <?php
  
                    $getEmail = isset($_POST['email']);
                    if ($getEmail)
                    {
                
                        $new_email = $_POST['email'];
                        $new_alias = $_POST['pseudo'];
                        $new_passwd = $_POST['pwd'];

                        $mysqli = new mysqli("localhost", "root", "root","socialnetwork");

                        $new_email = $mysqli->real_escape_string($new_email);
                        $new_alias = $mysqli->real_escape_string($new_alias);
                        $new_passwd = $mysqli->real_escape_string($new_passwd);
                        $new_passwd = md5($new_passwd);
           
                        $accountInsert = "INSERT INTO users (id, email, password, alias) "
                                . "VALUES (NULL, "
                                . "'" . $new_email . "', "
                                . "'" . $new_passwd . "', "
                                . "'" . $new_alias . "'"
                                . ");";
                        // Etape 6: exécution de la requete
                        $accountResult = $mysqli->query($accountInsert);
                        if ( ! $accountResult)
                        {
                            echo "Failed to sign up: " . $mysqli->error;
                        } else
                        {
                            echo "Your account has been created " . $new_alias;
                            echo " <a href='login.php'>Login</a>";
                        }
                    }
                    ?>                     
                    <form action="registration.php" method="post">
                        <input type='hidden'name='???' value='achanger'>
                        <dl>
                            <dt><label for='pseudo'>Pseudo</label></dt>
                            <dd><input type='text'name='pseudo'></dd>
                            <dt><label for='email'>Email</label></dt>
                            <dd><input type='email'name='email'></dd>
                            <dt><label for='motpasse'>Password</label></dt>
                            <dd><input type='password'name='pwd'></dd>
                        </dl>
                        <input type='submit'>
                    </form>
                </article>
            </main>
        </div>
    </body>
</html>
