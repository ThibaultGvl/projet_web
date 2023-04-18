<?php
class Comment {
	private $_id = NULL;
	private $_email;
	private $_user;
	private $_comment;

	function __construct($email, $user, $comment) {
		$this->_email = $email;
		$this->_user = $user;
		$this->_comment = $comment;
	}
	
	public function getId(): ?int {
        return $this->_id;
    }

    public function getEmail(): ?string {
        return $this->_email;
    }

    public function getUser(): ?string {
        return $this->_user;
    }

    public function getComment(): ?string {
        return $this->_comment;
    }

    // setters
    public function setId(?int $id): void {
        $this->_id = $id;
    }

    public function setEmail(?string $email): void {
        $this->_email = $email;
    }

    public function setUser(?string $user): void {
        $this->_user = $user;
    }

    public function setComment(?string $comment): void {
        $this->_comment = $comment;
    }
}
