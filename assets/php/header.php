<header>
	<nav>
		<img class="icon" src="assets/img/music-band.png" alt="Icone groupe de musique"/>
		<ul class="nav_list">
			<li>
				<a class="nav_elem" href="./index.php">
					<?php
						$userLang = Locale::acceptFromHttp($_SERVER['HTTP_ACCEPT_LANGUAGE']);
						$home = new Traduction("Accueil", "Home");
						if ($userLang == 'fr') {
							echo $home->getFr();
						} else {
							echo $home->getEn();
						} 
					?>
				</a>
			</li>
        	<li>
				<a class="nav_elem" href="./details.php">
					<?php
						$random = new Traduction("Album au hasard", "Random album");
						if ($userLang == 'fr') {
							echo $random->getFr();
						} else {
							echo $random->getEn();
						} 
					?>
				</a>
			</li>
        	<li> <a class="nav_elem" href="./index.php">Contact</a></li>
		</ul>
	</nav>
</header>