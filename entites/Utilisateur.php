<?php
class Utilisateur {
	private $login;
	private $password;
	private $access;

	function __construct($login, $password) {
		$this->login = $login;
		$this->password = $password;
	}

	public function getLogin() {
		return $this->login;
	}
	public function setLogin($login) {
		$this->login = $login;
	}
	public function getPassword() {
		return $this->password;
	}
	public function setPassword($password) {
		$this->password = $password;
	}

	public function getAccess() {
		return $this->access;
	}

	public function setAccess($access) {
		$this->access = $access;
	}
}