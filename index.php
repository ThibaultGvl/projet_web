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
                if ($userLang == 'fr') {
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
        require_once 'assets/php/Database.php';
        $db = new Database();
        $comments = $db->getComments();
        $albums = $db->getAlbums();
        if(isset($_GET['query'])) {
            $query = $_GET['query'];
            $albums = $db->getAlbumsByName($query);
        } 
        if (is_null($albums) || empty($albums)) {
            $albums = $db->getAlbums();
        }
    ?>
    <body>
        <?php 
            if (isset($_SESSION['success_message'])) {
                echo '<p>' . $_SESSION['success_message'] . '</p>';
            // Supprimer le message de confirmation de la variable de session
                unset($_SESSION['success_message']);
            }
        ?>
        <h1 id="welcome">
            <?php
                $welcomeText = new Traduction("Bienvenue sur mon site de critique musicale !", "Welcome to my music review website!");
                if ($userLang == 'fr') {
                    echo $welcomeText->getFr();
                } else {
                    echo $welcomeText->getEn();
                } 
                if(isset($comments[0]) && $comments[0] != "") {
                    echo $comments[0]->getComment();
                }
            ?>
        </h1>
        <div class="search">
        <form id="search_form" action="index.php" method="GET">
            <?php $search = new Traduction("Rechercher", "Search");
                $search_trad = $search->getEn();
                if ($userLang == 'fr') {
                    $search_trad = $search->getFr();
                } 
            ?>
            <input id="search_input" type="text" name="query" placeholder=<?php echo $search_trad, "...";?>>
            <button type="submit"><?php echo $search_trad;?></button>
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
