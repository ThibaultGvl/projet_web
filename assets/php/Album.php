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
}
