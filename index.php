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
        <header>
            <nav>
                <img class="icon" src="assets/img/music-band.png" alt="Icone groupe de musique"/>
                <ul class="nav_list">
                    <li><a class="nav_elem" href="./index.php">Accueil</a></li>
                    <li><a class="nav_elem" href="./details.php">Album au hasard</a></li>
                    <li> <a class="nav_elem" href="./index.php">Contact</a></li>
                </ul>
            </nav>
        </header>
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

        <footer>
            <form action="mailto:thibault.grivel@etu.unistra.fr" method="POST" enctype="text/plain">
                <div class="form_div">
                    <label for="name">Entrez votre nom : </label>
                    <input type="text" name="name">
                  </div>
                  <div class="form_div">
                    <label for="email">Entrez votre email: </label>
                    <input id="email" type="email" name="email" >
                    <p class="text_error" id="email_error"></p>
                  </div>
                  <div class="form_div">
                    <label for="text">Entrez un commentaire : </label>
                    <textarea id="commentaire" type="text" name="commentaire" ></textarea>
                    <p class="text_error" id="comment_error"></p>
                  </div>
                  <div class="form_div">
                    <input type="submit" value="Envoyer">
                  </div>
            </form>
        </footer>
    </body>