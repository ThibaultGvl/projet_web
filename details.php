<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Site de critique musicale</title>
        <link rel="icon" href="assets/img/music-band.png">
        <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="assets/css/style.css">
        <script src="assets/js/script.js" defer></script>
    </head>
    <body>
        
        <?php 
            include 'assets/php/Traduction.php';
            include 'assets/php/header.php';
            require_once 'assets/php/Database.php';
            $userLang = Locale::acceptFromHttp($_SERVER['HTTP_ACCEPT_LANGUAGE']);
            $db = new Database();
            $id = $_GET['id'];
            $id_int = intval($id);
            $album = $db->getAlbumById($id_int);
        ?>

        <article>
            <section id="section_presentation">
                <img id="img_album" src=<?php echo $album->getUri(); ?> alt="Pochette de l'album">
                <h1 id="title_album"><?php echo $album->getTitle(); ?></h1><br/>
            </section>
            <p id="description_album"><?php echo $album->getDescription(); ?></p>
        </article>
        
        <?php include 'assets/php/footer.php'?>
    </body>
</html>