<footer>
    <?php 
        if (isset($_SESSION['success_message'])) {
            echo '<p>' . $_SESSION['success_message'] . '</p>';
            unset($_SESSION['success_message']);
        }
    ?>
    <h3>Vous Aimez le site, laissez un commentaire !</h3>
    <form id="email_form" action="assets/php/envoi_form.php" method="POST" enctype="multipart/form-data">
        <label for="name">Entrez votre nom : </label>
        <input id="name" type="text" name="name"><br>
        <p class="text_error" id="name_error"></p><br>
        <label for="email">Entrez votre email: </label>
        <input id="email" type="email" name="email" >
        <p class="text_error" id="email_error"></p><br>
        <label for="text">Entrez un commentaire : </label>
        <textarea id="commentaire" type="text" name="commentaire" ></textarea>
        <p class="text_error" id="comment_error"></p><br>
        <input type="submit" name="submit_button" value="Envoyer">
    </form>

</footer>