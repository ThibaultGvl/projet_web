<?php
class Album {
	private $_id = NULL;
	private $_title;
	private $_artist;
	private $_description;
	private $_rank;
	private $_uri;

	function __construct($title, $artist, $description, $rank, $uri) {
		$this->_title = $title;
		$this->_artist = $artist;
		$this->_description = $description;
		$this->_rank = $rank;
		$this->_uri = $uri;
	}
	
	public function getId(): ?int {
        return $this->_id;
    }

    public function getTitle(): ?string {
        return $this->_title;
    }

    public function getArtist(): ?string {
        return $this->_artist;
    }

    public function getDescription(): ?string {
        return $this->_description;
    }

    public function getRank(): ?int {
        return $this->_rank;
    }

    public function getUri(): ?string {
        return $this->_uri;
    }

    // setters
    public function setId(?int $id): void {
        $this->_id = $id;
    }

    public function setTitle(?string $title): void {
        $this->_title = $title;
    }

    public function setArtist(?string $artist): void {
        $this->_artist = $artist;
    }

    public function setDescription(?string $description): void {
        $this->_description = $description;
    }

    public function setRank(?int $rank): void {
        $this->_rank = $rank;
    }

    public function setUri(?string $uri): void {
        $this->_uri = $uri;
    }
}
