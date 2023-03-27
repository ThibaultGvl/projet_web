<?php
require_once 'Album.php';
require_once 'Traduction.php';

class Database {

	private $pdo;

	function __construct() {
		$this->pdo = new PDO('sqlite:./database.db');
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->pdo->query('CREATE TABLE IF NOT EXISTS albums (
			id INTEGER PRIMARY KEY AUTOINCREMENT,
			title VARCHAR(255) NOT NULL,
			descript VARCHAR NOT NULL,
			artist VARCHAR NOT NULL,
			ranking INTEGER NOT NULL,
			uri VARCHAR
		)');
		$this->pdo->query('CREATE TABLE IF NOT EXISTS traduction (
			id INTEGER PRIMARY KEY AUTOINCREMENT,
			fr VARCHAR NOT NULL,
			en VARCHAR NOT NULL
			)');
		$album = new Album('Lark\'s tongue in aspic', 'King Crimson', '5ème album studio de King Crimson, le génie de Fripp à son paroxisme', 5, 'https://p4.storage.canalblog.com/44/60/636073/69813048.jpg');
		$album2 = new Album('2112', 'Rush', 'Un des meilleurs albums concept de tous les temps, aussi bien ses paroles et sa musique font de cet album un chef d\'oeuvre !', 5, 'https://www.rush.com/wp-content/uploads/2012/12/Rush_2112_Square_REV-800x800.jpg');
		$this->insertAlbum($album);
		$this->insertAlbum($album2);
	}

	public function insertTraduction($traduction) {
		$sql = 'INSERT INTO traduction(id, fr, en) '
					. 'VALUES(:id, :fr, :en)';
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute([
			':id' => $traduction->getId(),
			':fr' => $traduction->getFr(),
			':en' => $traduction->getEn(),
		]);
		$traduction->setId($this->pdo->lastInsertId());
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
}
