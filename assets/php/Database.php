<?php
class Album {
	private $_id = NULL;
	private $_title;
	private $_artist:
	private $_decription;
	private $_rank;
	private $_uri;

	function __construct($title, $artist, $description, $rank, $uri) {
		$this->_title = $title;
		$this->_artist = $artist;
		$this->_desription = $description;
		$this->_rank = $rank;
		$this->_uri = $uri;
		insertAlbum($this);
	}
}

class Traduction {
	private $_id = NULL;
	private $_fr;
	private $_en;

	function __construct($fr, $en) {
		$this->_fr = $fr;
		$this->_en = $en;
		insertTraduction($this);
	}
}

class BDD {

	private $pdo;

	function __construct() {
		$pdo = new PDO('sqlite:database.db');
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$pdo->query('CREATE TABLE IF NOT EXISTS albums {
			id INTEGER PRIMARY KEY AUTOINCREMENT,
			title VARCHAR(255) NOT NULL,
			desript VARCHAR NOT NULL,
			artist VARCHAR NOT NULL,
			ranking INTEGER NOT NULL,
			uri VARCHAR
			}');
			$pdo->query('CREATE TABLE IF NOT EXISTS traduction {
			id INTEGER PRIMARY KEY AUTOINCREMENT,
			fr VARCHAR NOT NULL,
			en VARCHAR NOT NULL,
			}');
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
		$album->_id = $this->pdo->lastInsertId();
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
}