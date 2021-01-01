<?php
require_once "Phone.php";

interface PhoneStorage {

	public function createPhone(Phone $phone,$account);
	public function readPhone($id);
	public function readAll();
	public function readonephone($id);
	public function UpdatePhone(Phone $p, $id);
	public function deletephone($id);
	public function ReadSearch($c, $p);

}
?>
