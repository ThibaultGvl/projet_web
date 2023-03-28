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
            $db = new Database();
            $albums = $db->getAlbums();
            $userLang = Locale::acceptFromHttp($_SERVER['HTTP_ACCEPT_LANGUAGE']);
        ?>
        <h1 id="welcome">
            <?php
                $welcomeText = new Traduction("Bienvenue sur mon site de critique musicale !", "Welcome to my music review website!");
                if ($userLang == 'fr') {
                    echo $welcomeText->getFr();
                } else {
                    echo $welcomeText->getEn();
                } 
            ?>
        </h1>
        <div class="page">
            <main>
                <?php for ($sec = 1; $sec < 4; $sec++): ?>
                    <section class="bloc">
                        <?php for($elem = 0; $elem < 3; $elem++): ?> 
                            <?php $index = ($sec - 1) * 3 + $elem; ?>
                            <?php if (isset($albums[$index])): ?>
                                <a class="elem" href="details.php?id=<?php echo $albums[$index]->getId();?>">
                                    <img class="img_elem" src=<?php echo $albums[$index]->getUri(); ?> alt="Pochette de l'album">
                                    <h2 class="tit_elem"><?php echo $albums[$index]->getTitle(); ?></h2>
                                    <p class="desc_elem"><?php echo $albums[$index]->getDescription(); ?></p>
                                </a>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </section>
                <?php endfor; ?>
                <button id="affich_btn">
                    <?php
                        $affich_btn_text = new Traduction("Afficher plus d'albums", "See more albums");
                        if ($userLang == 'fr') {
                            echo $affich_btn_text->getFr();
                        } else {
                            echo $affich_btn_text->getEn();
                        } 
                    ?>
                </button>
            </main>
            
        </div>

        <?php include 'assets/php/footer.php'?>
    </body>
</html>
