<!DOCTYPE html>
<html>
    <?php 
        include 'assets/php/Traduction.php';
        $userLang = Locale::acceptFromHttp($_SERVER['HTTP_ACCEPT_LANGUAGE']);
    ?>
    <head>
        <meta charset="utf-8"/>
        <title>
            <?php
                $title = new Traduction("Site de critique musicale", "Review website");
                if (strpos($userLang, 'fr') !== false) {
                    echo $title->getFr();
                } else {
                    echo $title->getEn();
                } 
            ?>
        </title>
        <link rel="icon" href="assets/img/music-band.png">
        <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="assets/css/style.css">
        <script src="assets/js/script.js" defer></script>
    </head>
    <body>
        
        <?php 
            include 'assets/php/header.php';
            require_once 'assets/php/Database.php';
            $db = new Database('assets/php/db/');
            $id_int = -1;
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $id_int = intval($id);
            }
            $album = $db->getAlbumById($id_int);
        ?>

        <section>
            <article>
                <img id="img_album" src=<?php echo $album->getUri(); ?> alt="Pochette de l'album">
                <h2 id="title_album"><?php echo $album->getTitle(); ?></h1><br/>
                <p><?php echo $album->getRank(); ?>/5</p>
            </article>
            <p id="description_album"><?php echo $album->getDescription(); ?></p>
        </section>
        
        <?php include 'assets/php/footer.php'?>
    </body>
</html>
