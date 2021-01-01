<?php
require_once "AccountStorage.php";

class AccountStorageMySQL implements AccountStorage {

	private $data_base;

	public function __construct(PDO $db) {
		$this->data_base = $db;
	}

	public function getDataBase() {
		return $this->data_base;
	}

	public function create(Account $account) {
		$req = $this->data_base->prepare("INSERT INTO User(login,password,first_name,last_name,mode) values(:login,:password,:first_name,:last_name,'user')");
		$req->bindParam(":login", $log);
		$req->bindParam(":password", $pass);
		$req->bindParam(":first_name", $fn);
		$req->bindParam(":last_name", $ln);

		$log = $account->getlog();
		$pass = $account->getpass();
		$fn = $account->getfirst_name();
		$ln = $account->getLast_name();

		$req->execute();

	}

	public function readUser() {
		$stmt = $this->data_base->prepare("SELECT * FROM User");
		$data = array();
		$stmt->execute($data);
		$res = $stmt->fetchAll();
		$n = array(0 => new Account($res[0][0], $res[0][1], $res[0][2], $res[0][3], $res[0][4]));
		for ($i = 1; $i < count($res); $i++) {
			$b = array($i => new Account($res[$i][0], $res[$i][1], $res[$i][2], $res[$i][3], $res[$i][4]));
			$n = $n + $b;
		}
		return $n;
	}
}
?>
