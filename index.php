<!DOCTYPE html>
    <head>
        <meta charset="utf-8"/>
        <title>Site de critique musicale</title>
        <link rel="icon" href="../projet_web/assets/img/music-band.png">
        <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="assets/css/style.css">
        <script src="assets/js/script.js" defer></script>
    </head>
    <body>
        <?php include 'assets/php/header.php'?>
        <h1 id="welcome">
            Bienvenue sur mon site de critique musicale !
        </h1>
        <div class="page">
            <main>
                <?php for($bloc = 1; $bloc < 4; $bloc++): ?>
                <section class="bloc">
                    <?php for($elem = 0; $elem < 3; $elem++): ?> 
                    <a class="elem" href="details.php" <?php echo ""?>>
                        <img class="img_elem" src=<?php echo "assets/img/disque-vinyle.jpg"?> alt="Pochette de l'album">
                        <h2 class="tit_elem">Element1</h2>
                        <p class="desc_elem">Description rapide de l'élément</p>
                    </a>
                    <?php endfor; ?>
                </section>
                <?php endfor; ?>
                <button id="affich_btn">Afficher plus d'albums</button>
            </main>
            
        </div>

        <?php include 'assets/php/footer.php'?>
    </body>
