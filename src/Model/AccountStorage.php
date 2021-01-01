<?php
require_once "Account.php";

interface AccountStorage {
	public function create(Account $account);
	public function readUser();
}
?>
