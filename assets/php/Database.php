<?php
class Database {

	private $pdo;

	function __construct() {
		$this->pdo = new PDO('sqlite:./db/database.db');
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
			en VARCHAR NOT NULL,
			)');
		$album = new Album('Title', 'Artist', 'Description', 1, 'uri');
		$this->insertAlbum($album);
	}

	public function insertTraduction($traduction) {
		$sql = 'INSERT INTO traduction(id, fr, en) '
					. 'VALUES(:id, :fr, :en)';
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute([
			':id' => $traduction->_id,
			':fr' => $traduction->_fr,
			':en' => $traduction->_en,
		]);
		$traduction->_id = $this->pdo->lastInsertId();
	}

	public function insertAlbum($album) {
		$sql = 'INSERT INTO albums(id, title, descript, artist, ranking, uri) '
		. 'VALUES(:id, :title, :descript, :artist, :ranking, :uri)';
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute([
			':id' => $album->_id,
			':title' => $album->_title,
			':descript' => $album->_description,
			':artist' => $album->_artist,
			':ranking' => $album->_rank,
			':uri' => $album->_uri,
		]);
		$album->_id = $this->pdo->lastInsertId();
	}
	

	public function getAlbums() {
		$stmt = $this->pdo->query('SELECT * FROM albums');
		$albums = [];
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$album = new Album($row['title'], $row['artist'], $row['descript'], $row['ranking'], $row['uri']);
			$album->_id = $row['id'];
			$albums[] = $album;
		}
		return $albums;
	}
}