<footer>
	<?php include'assets/php/envoi_form.php'; ?>
    <form id="email_form" action="assets/php/envoi_form.php" method="POST" enctype="text/plain">
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
