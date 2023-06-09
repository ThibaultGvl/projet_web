<header>
	<?php
		$userLang = Locale::acceptFromHttp($_SERVER['HTTP_ACCEPT_LANGUAGE']);
	?>
	<nav>
		<a href="./index.php">
			<img src="assets/img/music-band.png" alt="
				<?php
					$icon = new Traduction("Icone groupe de musique", "Icon music band");
					if (strpos($userLang, 'fr') !== false) {
						echo $icon->getFr();
					} else {
						echo $icon->getEn();
					} 
				?>"
			/>
		</a>
		<ul class="nav_list">
			<li>
				<a href="./index.php">
					<?php
						$home = new Traduction("Accueil", "Home");
						if (strpos($userLang, 'fr') !== false) {
							echo $home->getFr();
						} else {
							echo $home->getEn();
						} 
					?>
				</a>
			</li>
        	<li>
				<a href="./details.php">
					<?php
						$random = new Traduction("Album au hasard", "Random album");
						if (strpos($userLang, 'fr') !== false) {
							echo $random->getFr();
						} else {
							echo $random->getEn();
						} 
					?>
				</a>
			</li>
        	<li> 
				<a href="./comments.php">
					<?php
						$comments = new Traduction("Avis", "Comments");
						if (strpos($userLang, 'fr') !== false) {
							echo $comments->getFr();
						} else {
							echo $comments->getEn();
						} 
					?>
				</a>
			</li>
		</ul>
	</nav>
</header>