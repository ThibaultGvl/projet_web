<?php
class Traduction {
	private $_id = NULL;
	private $_fr;
	private $_en;

	function __construct($fr, $en) {
		$this->_fr = $fr;
		$this->_en = $en;
	}
	
	public function getId(): ?int {
        return $this->_id;
    }
    
    public function getFr(): ?string {
        return $this->_fr;
    }
    
    public function getEn(): ?string {
        return $this->_en;
    }
    
    public function setId(?int $id): void {
        $this->_id = $id;
    }
    
    public function setFr(?string $fr): void {
        $this->_fr = $fr;
    }
    
    public function setEn(?string $en): void {
        $this->_en = $en;
    }
}
