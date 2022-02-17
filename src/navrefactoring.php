<!-- nav bar -->

<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>ReSoC - Administration</title> 
        <meta name="author" content="Julien Falconnet">
        <link rel="stylesheet" href="./style.css"/>
    </head>
    <body id = "body">
        <header id = "header">
            <a href="admin.php"> <img src="logo_php.png" alt="Logo de notre réseau social"/></a>
            <nav id="menu">
                <a href="news.php">Actualités</a>
                <a href="wall.php?user_id=<?php echo $_SESSION['connected_id'] ?>">Mur</a>
                <a href="feed.php?user_id=<?php echo $_SESSION['connected_id'] ?>">Flux</a>
                <!-- <a href="tags.php?tag_id=<?php echo $tag['id'] ?>">Mots-clés</a> -->
            </nav>
            <nav id="user">
                <!-- <div id="login"> -->
                    <a id="login" href="login.php">Login</a>
                <!-- </div> -->
                <div id="profil"> 
                    <a href="#">Profil</a>
                    <ul>
                        <li><a href="settings.php?user_id=<?php echo $_SESSION['connected_id'] ?>">Paramètres</a></li>
                        <li><a href="followers.php?user_id=<?php echo $_SESSION['connected_id'] ?>">Mes suiveurs</a></li>
                        <li><a href="subscriptions.php?user_id=<?php echo $_SESSION['connected_id'] ?>">Mes abonnements</a></li>
                    </ul>
                </div>

            </nav>
        </header>

    </body>