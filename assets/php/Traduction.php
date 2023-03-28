<?php
class Traduction {
	private $_fr;
	private $_en;

	function __construct($fr, $en) {
		$this->_fr = $fr;
		$this->_en = $en;
	}
    
    public function getFr(): ?string {
        return $this->_fr;
    }
    
    public function getEn(): ?string {
        return $this->_en;
    }
    
    public function setFr(?string $fr): void {
        $this->_fr = $fr;
    }
    
    public function setEn(?string $en): void {
        $this->_en = $en;
    }
}
