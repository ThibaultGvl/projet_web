<?php

require_once 'Album.php';

class Database {

	private $pdo;

	function __construct() {
		$this->pdo = null;
	}

	private function connect() {
		try {
			$this->pdo = new PDO('sqlite:./assets/php/db/database.db');
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->pdo->query('CREATE TABLE IF NOT EXISTS albums (
				id INTEGER PRIMARY KEY AUTOINCREMENT,
				title VARCHAR(255) NOT NULL,
				descript VARCHAR NOT NULL,
				artist VARCHAR NOT NULL,
				ranking INTEGER NOT NULL,
				uri VARCHAR
			)');
			$this->initDatabase();
		} catch(PDOException $e) {
			echo "Connection failed: " . $e->getMessage();
			die();
		}
	}

	public function insertAlbum($album) {
		if ($this->pdo == null) {
			$this->connect();
		}
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
	

	public function getAlbums() {
		if ($this->pdo == null) {
			$this->connect();
		}
		$stmt = $this->pdo->query('SELECT * FROM albums');
		$albums = [];
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$album = new Album($row['title'], $row['artist'], $row['descript'], $row['ranking'], $row['uri']);
			$album->setId($row['id']);
			$albums[] = $album;
		}
		return $albums;
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
	
	

	private function initDatabase() {
        $stmt = $this->pdo->query('SELECT COUNT(*) FROM albums');
        $count = $stmt->fetchColumn();
        if ($count == 0) {
            $album = new Album('Lark\'s tongue in aspic', 'King Crimson', '5ème album studio de King Crimson, le génie de Fripp à son paroxisme', 5, 'https://p4.storage.canalblog.com/44/60/636073/69813048.jpg');
            $album2 = new Album('2112', 'Rush', 'Un des meilleurs albums concept de tous les temps, aussi bien ses paroles et sa musique font de cet album un chef d\'oeuvre !', 5, 'https://www.rush.com/wp-content/uploads/2012/12/Rush_2112_Square_REV-800x800.jpg');
            $this->insertAlbum($album);
            $this->insertAlbum($album2);
        }
    }
}
