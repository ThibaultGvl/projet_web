<footer>
    <?php 
        //$userLang = Locale::acceptFromHttp($_SERVER['HTTP_ACCEPT_LANGUAGE']);
        $userLang = 'fr';
        if (isset($_SESSION['success_message'])) {
            echo '<p>' . $_SESSION['success_message'] . '</p>';
            unset($_SESSION['success_message']);
        }
    ?>
    <h3>
        <?php
                $leaveComment = new Traduction("Vous Aimez le site, laissez un commentaire !", "You like the website ? Leave a comment !");
                if (strpos($userLang, 'fr') !== false) {
                    echo $leaveComment->getFr();
                } else {
                    echo $leaveComment->getEn();
                } 
        ?>
    </h3>
    <form id="email_form" action="assets/php/envoi_form.php" method="POST" enctype="multipart/form-data">
        <label for="name">
            <?php
                $name = new Traduction("Entrez votre nom :", "Enter your name :");
                if (strpos($userLang, 'fr') !== false) {
                    echo $name->getFr();
                } else {
                    echo $name->getEn();
                } 
            ?>
         </label>
        <input id="name" type="text" name="name"><br>
        <p class="text_error" id="name_error"></p><br>
        <label for="email">
            <?php
                $email = new Traduction("Entrez votre email :", "Enter your email :");
                if (strpos($userLang, 'fr') !== false) {
                    echo $email->getFr();
                } else {
                    echo $email->getEn();
                } 
            ?> 
        </label>
        <input id="email" type="email" name="email" >
        <p class="text_error" id="email_error"></p><br>
        <label for="text">
            <?php
                $comment = new Traduction("Entrez un commentaire : ", "Enter your comment :");
                if (strpos($userLang, 'fr') !== false) {
                    echo $comment->getFr();
                } else {
                    echo $comment->getEn();
                } 
            ?> 
        </label>
        <textarea id="commentaire" type="text" name="commentaire" ></textarea>
        <p class="text_error" id="comment_error"></p><br>
        <input type="submit" name="submit_button" value="Envoyer">
    </form>

</footer>