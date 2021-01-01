<?php

Class Account {
	
	private $login;
	private $password;
	private $first_name;
	private $last_name;
	private $mode;

	public function __construct($login, $password, $first_name, $last_name, $mode) {
		$this->login = $login;
		$this->password = $password;
		$this->last_name = $last_name;
		$this->first_name = $first_name;
		$this->mode = $mode;
	}

	public function getlog() {
		return $this->login;
	}

	public function getpass() {
		return $this->password;
	}

	public function getfirst_name() {
		return $this->first_name;
	}

	public function getLast_name() {
		return $this->last_name;
	}

	public function getmode() {
		return $this->mode;
	}
}
?>
