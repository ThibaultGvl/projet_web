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
        <?php include 'assets/php/header.php'?>
        <h1 id="welcome">
            Bienvenue sur mon site de critique musicale !
        </h1>
        <?php
        // Importer la classe Database
        require_once 'assets/php/Database.php';

    // Créer une instance de la classe Database
    $db = new Database();

    // Récupérer tous les albums de la base de données
    $albums = $db->getAlbums();

    ?>
        <div class="page">
            <main>
                <?php for($bloc = 1; $bloc < 4; $bloc++): ?>
                <section class="bloc">
                    <?php for($elem = 0; $elem < 3; $elem++): ?> 
                    <a class="elem" href="details.php?id=<?php echo $album['_id'];?>">
                        <img class="img_elem" src=<?php echo $album['_uri']; ?> alt="Pochette de l'album">
                        <h2 class="tit_elem"><?php echo $album['_title']; ?></h2>
                        <p class="desc_elem"><?php echo $album['_description']; ?></p>
                    </a>
                    <?php endfor; ?>
                </section>
                <?php endfor; ?>
                <button id="affich_btn">Afficher plus d'albums</button>
            </main>
            
        </div>

        <?php include 'assets/php/footer.php'?>
    </body>
</html>