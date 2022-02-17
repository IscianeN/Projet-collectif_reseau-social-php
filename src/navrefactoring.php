<!-- nav bar -->

<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>AAAMAzing Social Network</title> 
        <meta name="author" content="Team A IQMS">
        <link rel="stylesheet" href="./style.css"/>
    </head>
    <body id = "body">
        <header id = "header">
            <a href="admin.php"> <img src="logo_php.png" alt="Logo de notre réseau social"/></a>
            <nav id="menu">
                <a href="news.php">News</a>
                <a href="wall.php?user_id=<?php echo $_SESSION['connected_id'] ?>">Wall</a>
                <a href="feed.php?user_id=<?php echo $_SESSION['connected_id'] ?>">Feed</a>
                <!-- <a href="tags.php?tag_id=<?php echo $tag['id'] ?>">Mots-clés</a> -->
            </nav>
            <nav id="user">
                <!-- <div id="login"> -->
                    <a id="login" href="login.php">Login</a>
                <!-- </div> -->
                <div id="profil"> 
                    <a href="#">Profile</a>
                    <ul>
                        <li><a href="settings.php?user_id=<?php echo $_SESSION['connected_id'] ?>">Parameters</a></li>
                        <li><a href="followers.php?user_id=<?php echo $_SESSION['connected_id'] ?>">My Followers</a></li>
                        <li><a href="subscriptions.php?user_id=<?php echo $_SESSION['connected_id'] ?>">Followed</a></li>
                    </ul>
                </div>

            </nav>
        </header>

    </body>