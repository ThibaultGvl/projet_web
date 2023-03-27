<?php
class Traduction {
	private $_id = NULL;
	private $_fr;
	private $_en;

	function __construct($fr, $en) {
		$this->_fr = $fr;
		$this->_en = $en;
	}
}