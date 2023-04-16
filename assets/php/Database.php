<?php

require_once 'Album.php';
require_once 'Comment.php';

class Database {

	private $pdo;

	function __construct($path) {
		$this->pdo = $this->connect($path);
	}

	function connect($path) {
		if($this->pdo==null) {
				$this->pdo = new PDO('sqlite:'. $path .'database.db');
				$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->pdo->query('CREATE TABLE IF NOT EXISTS albums (
					id INTEGER PRIMARY KEY AUTOINCREMENT,
					title VARCHAR(255) NOT NULL,
					descript VARCHAR NOT NULL,
					artist VARCHAR NOT NULL,
					ranking INTEGER NOT NULL,
					uri VARCHAR
				)');
				$this->pdo->query('CREATE TABLE IF NOT EXISTS comments (
					id INTEGER PRIMARY KEY AUTOINCREMENT,
					email VARCHAR,
					user VARCHAR(255) NOT NULL,
					comment VARCHAR NOT NULL
				)');
				$this->initDatabase();
			}
			return $this->pdo;
	}

	public function insertAlbum($album) {
		$sql = 'INSERT INTO albums(id, title, descript, artist, ranking, uri) '
		. 'VALUES(:id, :title, :descript, :artist, :ranking, :uri)';
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute([
			':id' => $album->getId(),
			':title' => $album->getTitle(),
			':descript' => $album->getDescription(),
			':artist' => $album->getArtist(),
			':ranking' => $album->getRank(),
			':uri' => $album->getUri(),
		]);
		$album->setId($this->pdo->lastInsertId());
	}

	public function insertComment($comment) {
		try {
			$sql = 'INSERT INTO comments(email, user, comment) '
			. 'VALUES(:email, :user, :comment)';
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute([
				':email' => $comment->getEmail(),
				':user' => $comment->getUser(),
				':comment' => $comment->getComment(),
			]);
			$comment->setId($this->pdo->lastInsertId());
		} catch(PDOException $e) {
			echo "Error inserting comment: " . $e->getMessage();
		}
	}
	

	public function getAlbums() {
		$stmt = $this->pdo->query('SELECT * FROM albums');
		$albums = [];
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$album = new Album($row['title'], $row['artist'], $row['descript'], $row['ranking'], $row['uri']);
			$album->setId($row['id']);
			$albums[] = $album;
		}
		return $albums;
	}

	public function getComments() {
		$stmt = $this->pdo->query('SELECT * FROM comments');
		$comments = [];
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$comment = new Comment($row['email'], $row['user'], $row['comment']);
			$comment->setId($row['id']);
			$comments[] = $comment;
		}
		return $comments;
	}

	public function getAlbumById($id) {
		$albums = $this->getAlbums();
		$return = null;
		foreach ($albums as $album) {
			if ($album->getId() == $id) {
				$return = $album;
			}
		}
		if (!$return) {
			shuffle($albums);
			$return = $albums[0];
		}
		return $return;
	}

	public function getAlbumsByName($name) {
		$albums = $this->getAlbums();
		$albumsToReturn[] = [];
		foreach ($albums as $album) {
			if (strpos(strtolower($album->getTitle()), strtolower($name)) !== false || strpos(strtolower($album->getArtist()), strtolower($name)) !== false) {
				$albumsToReturn[] = $album;
			}
		}
		return $albumsToReturn;
	}

	public function getAlbumsPaginated($page, $perPage) {
		$albums = $this->getAlbums();
		$albumsToReturn[] = null;
		for($i = $perPage; $i<($page+1)*$perPage; $i++) {
			if (isset($albums[$i])) {
				$albumsToReturn[] = $albums[$i];
			}
		}
		return $albumsToReturn;
	} 		

	private function initDatabase() {
        $stmt = $this->pdo->query('SELECT COUNT(*) FROM albums');
        $count = $stmt->fetchColumn();
        if ($count == 0) {
            $album = new Album('Lark\'s tongue in aspic', 'King Crimson', '5ème album studio de King Crimson, le génie de Fripp à son paroxisme', 5, 'https://p4.storage.canalblog.com/44/60/636073/69813048.jpg');
            $album2 = new Album('2112', 'Rush', 'Un des meilleurs albums concept de tous les temps, aussi bien ses paroles et sa musique font de cet album un chef d\'oeuvre !', 5, 'https://www.rush.com/wp-content/uploads/2012/12/Rush_2112_Square_REV-800x800.jpg');
            $album3 = new Album('Vector', 'Haken', 'Le meilleur album du meilleur groupe de prog des années 2010', 5, 'https://upload.wikimedia.org/wikipedia/en/9/91/Vector_%28Haken_album%29.jpg');
            $album4 = new Album('Wish you were here', 'Pink Floyd', 'Un classique des 70\'s', 5, 'https://monshoppingcestcalais.fr/media/catalog/product/cache/1/image/480x480/85e4522595efc69f496374d01ef2bf13/2/c/2c06896918_.jpg');
            $album5 = new Album('Savage Sinusoid', 'Igorrr', 'Génialement inclassable', 4, 'https://static.fnac-static.com/multimedia/Images/FR/NR/18/9d/86/8822040/1507-1/tsp20220315181904/Savage-Sinusoid.jpg');
            $album6 = new Album('Alba les ombres errantes', 'Hypno5e', 'Incroyable', 5, 'https://i.scdn.co/image/ab67616d0000b273673db762f2672847ea5c0c6f');
            $album7 = new Album('Erotic Cakes', 'Guthrie Govan', 'Sans doute le meilleur album de guitare de ces dernieres années', 5, 'https://m.media-amazon.com/images/W/IMAGERENDERING_521856-T1/images/I/51lfSTeKkfL.jpg');
            $album8 = new Album('Les 5 saisons', 'Harmonium', 'Top', 5, 'https://i.scdn.co/image/ab67616d0000b27302c1e441b4e84a11ad5b2f3a');
            $album9 = new Album('Apostrophe \'', 'Frank Zappa', 'Zappa au sommet de son art', 5, 'https://static.fnac-static.com/multimedia/FR/Images_Produits/FR/fnac.com/Visual_Principal_340/8/2/1/0824302385128.jpg');
            $album10 = new Album('Breakfast in america', 'Supertramp', 'La pop au top', 5, 'https://www.renaissens.com/9178-large_default/Supertramp-Breakfast-in-America-Mobile-Fidelity-UDSACD-2189.jpg');
            $this->insertAlbum($album);
            $this->insertAlbum($album2);
            $this->insertAlbum($album3);
            $this->insertAlbum($album4);
            $this->insertAlbum($album5);
            $this->insertAlbum($album6);
            $this->insertAlbum($album7);
            $this->insertAlbum($album8);
            $this->insertAlbum($album9);
            $this->insertAlbum($album10);
			$album11 = new Album('Savage Sinusoid', 'Igorrr', 'Génialement inclassable', 4, 'https://static.fnac-static.com/multimedia/Images/FR/NR/18/9d/86/8822040/1507-1/tsp20220315181904/Savage-Sinusoid.jpg');
            $album12 = new Album('Alba les ombres errantes', 'Hypno5e', 'Incroyable', 5, 'https://i.scdn.co/image/ab67616d0000b273673db762f2672847ea5c0c6f');
            $album13 = new Album('Erotic Cake', 'Guthrie Govan', 'Sans doute le meilleur album de guitare de ces dernieres années', 5, 'https://m.media-amazon.com/images/W/IMAGERENDERING_521856-T1/images/I/51lfSTeKkfL.jpg');
            $album14 = new Album('Les 5 saisons', 'Harmonium', 'Top', 5, 'https://i.scdn.co/image/ab67616d0000b27302c1e441b4e84a11ad5b2f3a');
            $album15 = new Album('Apostrophe \'', 'Frank Zappa', 'Zappa au sommet de son art', 5, 'https://static.fnac-static.com/multimedia/FR/Images_Produits/FR/fnac.com/Visual_Principal_340/8/2/1/0824302385128.jpg');
            $album16 = new Album('Breakfast in america', 'Supertramp', 'La pop au top', 5, 'https://www.renaissens.com/9178-large_default/Supertramp-Breakfast-in-America-Mobile-Fidelity-UDSACD-2189.jpg');
			$album17 = new Album('Savage Sinusoid', 'Igorrr', 'Génialement inclassable', 4, 'https://static.fnac-static.com/multimedia/Images/FR/NR/18/9d/86/8822040/1507-1/tsp20220315181904/Savage-Sinusoid.jpg');
            $album18 = new Album('Alba les ombres errantes', 'Hypno5e', 'Incroyable', 5, 'https://i.scdn.co/image/ab67616d0000b273673db762f2672847ea5c0c6f');
            $album19 = new Album('Erotic Cakes', 'Guthrie Govan', 'Sans doute le meilleur album de guitare de ces dernieres années', 5, 'https://m.media-amazon.com/images/W/IMAGERENDERING_521856-T1/images/I/51lfSTeKkfL.jpg');
            $album20 = new Album('Les 5 saisons', 'Harmonium', 'Top', 5, 'https://i.scdn.co/image/ab67616d0000b27302c1e441b4e84a11ad5b2f3a');
			$this->insertAlbum($album11);
            $this->insertAlbum($album12);
            $this->insertAlbum($album13);
            $this->insertAlbum($album14);
            $this->insertAlbum($album15);
            $this->insertAlbum($album16);
            $this->insertAlbum($album17);
            $this->insertAlbum($album18);
            $this->insertAlbum($album19);
            $this->insertAlbum($album20);
            
		}
    }
}
