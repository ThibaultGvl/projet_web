<!DOCTYPE html>
<html>
    <?php 
        include 'assets/php/models/Traduction.php';
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
    <?php 
        session_start();
        include 'assets/php/header.php';
        require_once 'assets/php/models/Database.php';
        $db = new Database("assets/php/db/");
        $albums = $db->getAlbums();
        $albumInex = false;
        if(isset($_GET['query'])) {
            $query = $_GET['query'];
            $albums = $db->getAlbumsByName($query);
            if (empty($albums)) {
                $albumInex = true;
            }
        } 
        if (is_null($albums) || empty($albums)) {
            $albums = $db->getAlbums();
        }
    ?>
    <body>
        <h1 id="welcome">
            <?php
                $welcomeText = new Traduction("Bienvenue sur mon site de critique musicale!", "Welcome to my music review website!");
                if (strpos($userLang, 'fr') !== false) {
                    echo $welcomeText->getFr();
                } else {
                    echo $welcomeText->getEn();
                }
            ?>
        </h1>
        <div class="search">
        <form id="search_form" action="index.php" method="GET">
            <?php $search = new Traduction("Rechercher", "Search");
                $search_trad = $search->getEn();
                if (strpos($userLang, 'fr') !== false) {
                    $search_trad = $search->getFr();
                }
            ?>
            <input id="search_input" type="text" name="query" placeholder=<?php echo $search_trad, "...";?>>
            <button type="submit"><?php echo $search_trad;?></button>
            <p id="search_error">
                <?php 
                    if ($albumInex) {
                        if (strpos($userLang, 'fr') !== false) {
                            echo "Cet album n'a pas encore été noté";
                        }
                        else {
                            echo "This album has not been rated yet";
                        }
                    }
                    else {
                        echo "";
                    }
                ?>
            </p>
        </form>
        </div>
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
                                    <!--p class="desc_elem"><?php echo $albums[$index]->getDescription(); ?></p!-->
                                </a>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </section>
                <?php endfor; ?>
                    <button id="affich_btn" data-page="1">
                        <?php
                            $affich_btn_text = new Traduction("Afficher plus d'albums", "See more albums");
                            if (strpos($userLang, 'fr') !== false) {
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
