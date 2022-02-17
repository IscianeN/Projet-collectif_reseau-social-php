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
                    <h2>Login</h2>
                    <?php
                  
                    $getEmail = isset($_POST['email']);
                    if ($getEmail)
                    {
         
                        $emailToCheck = $_POST['email'];
                        $passwdToCheck = $_POST['pwd'];

                        $mysqli = new mysqli("localhost", "root", "root", "socialnetwork");

                        $emailToCheck = $mysqli->real_escape_string($emailToCheck);
                        $passwdToCheck = $mysqli->real_escape_string($passwdToCheck);

                        $passwdToCheck = md5($passwdToCheck);
        
                        $getEmail = "SELECT * "
                                . "FROM users "
                                . "WHERE "
                                . "email LIKE '" . $emailToCheck . "'"
                                ;
             
                        $res = $mysqli->query($getEmail);
                        $user = $res->fetch_assoc();
                        if ( ! $user OR $user["password"] != $passwdToCheck)
                        {
                            echo "Unable to login ";
                            
                        } else
                        {
                            echo "You're logged in as " . $user['alias'] . ".";

                            $_SESSION['connected_id']=$user['id'];
                        }
                    }
                    ?>                     
                    <form action="login.php" method="post">
                        <input type='hidden'name='???' value='achanger'>
                        <dl>
                            <dt><label for='email'>Email</label></dt>
                            <dd><input type='email'name='email'></dd>
                            <dt><label for='pwd'>Password</label></dt>
                            <dd><input type='password'name='pwd'></dd>
                        </dl>
                        <input type='submit'>
                    </form>
                    <br/>
                    <p>
                        You don't have an account?
                        <a href='registration.php'>Sign up now!</a>
                    </p>

                </article>
            </main>
        </div>
    </body>
</html>
