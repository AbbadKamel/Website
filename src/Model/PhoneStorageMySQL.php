<?php

require_once "PhoneStorage.php";

class PhoneStorageMySQL implements PhoneStorage {
	private $data_base;

	public function __construct(PDO $db) {
		$this->data_base = $db;
	}

	public function getDataBase() {
		return $this->data_base;
	}

	public function createPhone(Phone $phone1, $login) {

		$req = $this->data_base->prepare("insert into Phone(name_phone,color,price,option,photo,login) values(:name_phone,:color,:price,:option,:picture,:login)");
		$req->bindParam(":name_phone", $n);
		$n = $phone1->get_Name_Phone();
		$req->bindParam(":price", $p);
		$req->bindParam(":color", $c);
		$c = $phone1->get_color();
		$p = $phone1->get_price();
		$req->bindParam(":option", $op);
		$op = $phone1->get_option();
		$req->bindParam(":picture", $pic);
		$pic = $phone1->get_picture();

		$req->bindParam(":picture", $pic);
		$req->bindParam(":login", $login);

		$req->execute();
	}

	public function readphone($login) {

		$stmt = $this->data_base->prepare("SELECT * FROM Phone WHERE login=:login");
		$data = array(":login" => $login);
		$stmt->execute($data);
		$res = $stmt->fetchAll();
		if ($res == null) {
			return false;
		} else {
			$d = array($res[0][0] => new Phone($res[0][1], $res[0][2], $res[0][3], $res[0][4], $res[0][5]));
			for ($i = 1; $i < count($res); $i++) {
				$d_d = array($res[$i][0] => new Phone($res[$i][1], $res[$i][2], $res[$i][3], $res[$i][4], $res[$i][5]));
				$d = $d + $d_d;
			}
			return $d;
		}

	}

	public function readAll() {
		$stmt = $this->data_base->prepare("SELECT * FROM Phone");
		$data = array();
		$stmt->execute($data);
		$res = $stmt->fetchAll();
		$donne = array();

		for ($i = 0; $i < count($res); $i++) {
			$donne2 = array($res[$i][0] => new Phone($res[$i][1], $res[$i][2], $res[$i][3], $res[$i][4], $res[$i][5]));
			$donne = $donne + $donne2;
		}
		return $donne;
	}

	public function readonephone($id) {

		$req = "SELECT * from Phone where id_phone=:id";
		$stmt = $this->data_base->prepare($req);
		$data = array(":id" => $id);
		$stmt->execute($data);
		$res = $stmt->fetchAll();

		if ($res == null) {
			return null;} else {
			$d = array($res[0][0] => new Phone($res[0][1], $res[0][2], $res[0][3], $res[0][4], $res[0][5]));
			return $d;

		}}

	public function UpdatePhone(Phone $phone, $id) {

		$req = $this->data_base->prepare("UPDATE Phone SET name_phone=:name_phone,color=:color,price=:price,option=:option WHERE id_phone =" . $id);
		$req->bindParam(":name_phone", $n);
		$n = $phone->get_Name_Phone();
		$req->bindParam(":color", $c);
		$c = $phone->get_color();
		$req->bindParam(":price", $p);
		$p = $phone->get_price();
		$req->bindParam(":option", $o);
		$o = $phone->get_option();
		$req->execute();
	}
	public function deletephone($id) {
		$req = $this->data_base->prepare("DELETE FROM Phone WHERE id_phone=" . $id);
		$req->execute();
	}

	public function ReadSearch($c, $p) {

		if ($p == 1) {
			$req = "SELECT * from Phone where name_phone LIKE '%" . $c . "%' order by price desc";
		} else {
			$req = "SELECT * from Phone where name_phone LIKE '%" . $c . "%'  order by price asc";
		}
		$stmt = $this->data_base->prepare($req);
		$data = array();
		$stmt->execute($data);
		$res = $stmt->fetchAll();
		$donne = array();

		for ($i = 0; $i < count($res); $i++) {
			$donne2 = array($res[$i][0] => new Phone($res[$i][1], $res[$i][2], $res[$i][3], $res[$i][4], $res[$i][5]));
			$donne = $donne + $donne2;
		}
		return $donne;
	}
}

?>
