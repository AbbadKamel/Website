<?php
require_once "AccountStorageMySQL.php";

class AccountBuilder {

	private $data;
	private $error;
	const LOGIN = 'login';
	const PASSWORD = 'password';
	const PASSWORD_CONFIRM = 'password_confirm';
	const FIRST_NAME = 'first_name';
	const LAST_NAME = 'last_name';

	public function __construct($data) {
		$this->data = $data;
		$this->error = array();
	}

	public function getdata() {
		return $this->data;
	}

	public function geterror() {
		return $this->error;
	}

	public function CreateAccount() {
		return new Account($this->data["login"], $this->data["password"], $this->data["password_confirm"], $this->data["first_name"], $this->data["last_name"], "user");
	}

	public function isValid() {
		$bool = true;
		if ($this->data == null) {
			$this->error[self::LOGIN] = NULL;
			$this->error[self::PASSWORD] = NULL;
			$this->error[self::PASSWORD_CONFIRM] = NULL;
			$this->error[self::LAST_NAME] = NULL;
		} else {
			if ($this->data[self::LOGIN] == "") {
				$this->error[self::LOGIN] = "Login empty";
				$bool = false;
			}

			if (strlen($this->data[self::PASSWORD]) < 4) {
				$this->error[self::PASSWORD] = "Password must be more than 4 caracters";
				$bool = false;
			}

			if ($this->data[self::PASSWORD_CONFIRM] != $this->data[self::PASSWORD]) {
				$this->error[self::PASSWORD_CONFIRM] = "Password Confirmation is invalid";
				$bool = false;
			}
			if ($this->data[self::FIRST_NAME] == "") {
				$this->error[self::FIRST_NAME] = "FIRST Name empty";
				$bool = false;
			}

			if ($this->data[self::LAST_NAME] == "") {
				$this->error[self::LAST_NAME] = "Last Name empty";
				$bool = false;
			}
		}
		return $bool;
	}
}
?>
