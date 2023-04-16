<!DOCTYPE html>
<html>
    <?php 
        include 'assets/php/Traduction.php';
        include 'assets/php/Comment.php';
        //$userLang = Locale::acceptFromHttp($_SERVER['HTTP_ACCEPT_LANGUAGE']);
        $userLang = 'fr';
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
    <body>
        
        <?php 
            include 'assets/php/header.php';
            require_once 'assets/php/Database.php';
            $db = new Database('assets/php/db/');
            $comments = $db->getComments();
            foreach ($comments as $comment) {
                echo '<article class="comment">'.
                        '<h2 class="comment-author">'. 
                            $comment->getUser() .
                        '</h2>' .
                        '<p class="comment-content">' .
                            $comment->getComment() .
                        '</p>' .
                    '</article>';
            }
        ?>
        
        <?php include 'assets/php/footer.php'?>
    </body>
</html>
