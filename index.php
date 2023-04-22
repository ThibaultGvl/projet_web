<!DOCTYPE html>
<html>
    <?php 
        include 'assets/php/models/Traduction.php';
        //$userLang = Locale::acceptFromHttp($_SERVER['HTTP_ACCEPT_LANGUAGE']);
        $userLang = 'fr';
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
        <h1>
            <?php
                $welcomeText = new Traduction("Bienvenue sur mon site de critique musicale!", "Welcome to my music review website!");
                if (strpos($userLang, 'fr') !== false) {
                    echo $welcomeText->getFr();
                } else {
                    echo $welcomeText->getEn();
                }
            ?>
        </h1>
        <section class="search">
            <form id="search_form" action="index.php" method="GET">
                <?php $search = new Traduction("Rechercher", "Search");
                    $search_trad = $search->getEn();
                    if (strpos($userLang, 'fr') !== false) {
                        $search_trad = $search->getFr();
                    }
                ?>
                <input id="search_input" type="text" name="query" placeholder=<?php echo $search_trad, "...";?>>
                <input type="submit" value=<?php echo $search_trad;?>>
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
        </section>
        <main>
            <ul>
                <?php for ($sec = 1; $sec < 4; $sec++): ?>
                    <li>
                        <?php for($elem = 0; $elem < 3; $elem++): ?> 
                            <?php $index = ($sec - 1) * 3 + $elem; ?>
                            <?php if (isset($albums[$index])): ?>
                                <a href="details.php?id=<?php echo $albums[$index]->getId();?>">
                                    <img src=<?php echo $albums[$index]->getUri(); ?> alt="Pochette de l'album">
                                    <h2><?php echo $albums[$index]->getTitle(); ?></h2>
                                </a>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </li>
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
            </ul>
        </main>

        <?php include 'assets/php/footer.php'?>
    </body>
</html>
