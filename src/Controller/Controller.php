<?php

require_once "Model/Account.php";
require_once "Model/AccountBuilder.php";
require_once "Model/Phone.php";
require_once "Model/PhoneStorage.php";
require_once "Model/PhoneBuilder.php";

class Controller {

	private $view;
	private $accountbase;
	private $account;
	private $phone;

	public function __construct($view, PhoneStorage $phone, AccountStorage $accountbase, AccountStorageMySQL $account) {
		$this->view = $view;
		$this->phone = $phone;
		$this->accountbase = $accountbase;
		$this->account = $account;
	}

	public function SaveNewAccount(array $data) {
		$accountbuilder = new AccountBuilder($data);
		if ($accountbuilder->isValid() == True) {
			$this->account->create($accountbuilder->CreateAccount());

		} else {
			$this->view->MakeNewAccount($accountbuilder);
		}
	}

	public function AddNewPhonePage() {
		$this->view->MakeNewPhone(new PhoneBuilder(null));
	}

	public function creatNewPhone(array $data) {

		$phone1 = new PhoneBuilder($data);
		if ($phone1->isValid() == true) {
			$this->phone->createPhone($phone1->CreatePhone(), $this->view->getlog());
			$this->showListPhones($this->view->getlog());
		} else {
			$this->view->MakeNewPhone($phone1);
		}
	}

	public function showListPhones($login) {
		if ($this->phone->readphone($login) != null) {
			$this->view->GetListPhones($this->phone->readphone($login));
		} else {
			$v = array();
			$this->view->GetListPhones($v);
		}

	}
	public function getUpdatePhone($id) {
		$this->view->UpdatePhonePage($this->phone->readonephone($id));
	}

	public function UpdateMySQL($id, array $data) {
		$phone1 = new PhoneBuilder($data);
		if ($phone1 == true) {
			$this->view->displayPhoneModification($this->phone->UpdatePhone($phone1->CreatePhone(), $id));
		}
	}

	public function DeletePhone($id) {
		$this->view->displayPhoneDeletion($this->phone->deletephone($id));

	}

	public function HomePage() {
		$this->view->HomePagePublic($this->phone->readAll());
	}

	public function getSearch($c, $p) {
		$this->view->HomePagePublic($this->phone->ReadSearch($c, $p));
	}

	public function getMoreDetails($id) {
		$this->view->HomePage($this->phone->readonephone($id));
	}

	public function AboutP() {
		$this->view->Aboutpage();
	}

}

?>
