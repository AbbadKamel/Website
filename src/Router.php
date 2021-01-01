<?php
require_once "View/ViewPublic.php";
require_once "View/ViewPrivate.php";
require_once "Controller/Controller.php";
require_once "Model/AccountBuilder.php";
require_once "Model/AuthentificationManager.php";
require_once "Model/PhoneBuilder.php";
class Router {

	public function main($accountBD, PhoneStorage $phone) {
		session_start();
		$account = new AccountStorageMySQL($accountBD->getDataBase());
		$authen = new AuthentificationManager($account->readUser());
		$feedback = key_exists("feedback", $_SESSION) ? $_SESSION['feedback'] : null;
		$action = key_exists('action', $_GET) ? $_GET['action'] : null;
		$log = key_exists('phone', $_GET) ? $_GET['phone'] : null;
		if ($authen->isUserConnected()) {
			$view = new ViewPrivate($this, $_SESSION["user"], $feedback);
			unset($_SESSION["feedback"]);
		} else {
			if ($authen->isAdminConnected()) {
				$view = new ViewPrivate($this, $_SESSION["admin"], $feedback);
				unset($_SESSION["feedback"]);
			} else {
				$view = new ViewPublic($this);
			}
		}
		$view->MakeHomePage();

		$con = new Controller($view, $phone, $accountBD, $account);

		if ($action != null) {

			try {
				switch ($action) {
				case 'Home':
					$con->HomePage();
					break;

				case "CreateNewAccount":
					$view->MakeNewAccount(new AccountBuilder(null));
					break;

				case "SaveNewAccount":
					$con->SaveNewAccount($_POST);
					break;

				case "PageAuth":
					if ($authen->isUserConnected() == FALSE && $authen->isAdminConnected() == FALSE) {
						$view->PageAuth($authen);
						break;
					}

				case "Authentification":
					if ($authen->UserConnect($_POST["login"], password_hash($_POST["password"], PASSWORD_DEFAULT))) {
						$this->RedirectURL("https://dev.users.info.unicaen.fr/projet-inf5c-2020/phone.php", $feedback);
					} else {
						$view->PageAuth($authen);
						break;
					}
					break;

				case "AddNewPhone":
					if ($authen->isUserConnected() or $authen->isAdminConnected()) {
						$con->AddNewPhonePage();
						break;
					}

				case "Disconnection":
					if ($authen->isUserConnected() or $authen->isAdminConnected()) {
						$_SESSION = array();
						$this->RedirectURL("https://dev.users.info.unicaen.fr/projet-inf5c-2020/phone.php", $feedback);
						break;
					}
				case "getPhone":
					if ($authen->isUserConnected() or $authen->isAdminConnected()) {
						$con->creatNewPhone($_POST);
						break;
					}

				case "ListPhones":
					$con->showListPhones($log);
					break;

				case "getSaveUpdate":
					$con->UpdateMySQL($log, $_POST);
					break;

				case "UpdatePhone":
					$con->getUpdatePhone($log);
					break;

				case "MoreDetails":
					if ($authen->isUserConnected() or $authen->isAdminConnected()) {
						$con->getMoreDetails($log);
						break;
					} else {
						$view->PageAuth($authen);
						break;
					}

				case "DeletePhone":
					$con->DeletePhone($log);
					break;
				case "Search":
					$con->getSearch($_POST['cherche'], $_POST['price']);
					break;

				case "About":
					$con->AboutP();
					break;

				default:
					echo "ERREUR";
					break;
				}
			} catch (Exception $e) {
				echo "ERROR !";
			}

			$view->render();
		} else {
			$con->HomePage();
			$view->render();
		}

	}

	public function RedirectURL($url, $feedback) {
		$_SESSION['feedback'] = $feedback;
		header("Location:" . $url, true, 303);
	}

	public function CreateNewAccount() {
		return "https://dev.users.info.unicaen.fr/projet-inf5c-2020/phone.php?action=CreateNewAccount";
	}

	public function SaveNewAccount() {
		return "https://dev.users.info.unicaen.fr/projet-inf5c-2020/phone.php?action=SaveNewAccount";
	}
	public function PageAuth() {
		return "https://dev.users.info.unicaen.fr/projet-inf5c-2020/phone.php?action=PageAuth";
	}

	public function Authentification() {
		return "https://dev.users.info.unicaen.fr/projet-inf5c-2020/phone.php?action=Authentification";
	}

	public function Disconnection() {
		return "https://dev.users.info.unicaen.fr/projet-inf5c-2020/phone.php?action=Disconnection";
	}

	public function AddNewPhone() {
		return "https://dev.users.info.unicaen.fr/projet-inf5c-2020/phone.php?action=AddNewPhone";
	}

	public function SaveNewPhone() {
		return "https://dev.users.info.unicaen.fr/projet-inf5c-2020/phone.php?action=NewPhone";
	}

	public function getphone() {
		return "https://dev.users.info.unicaen.fr/projet-inf5c-2020/phone.php?action=getPhone";
	}

	public function ListPhones($log) {
		return "https://dev.users.info.unicaen.fr/projet-inf5c-2020/phone.php?phone=$log&amp;action=ListPhones";
	}

	public function UpdatePhonePage($id) {
		return "https://dev.users.info.unicaen.fr/projet-inf5c-2020/phone.php?phone=$id&amp;action=UpdatePhone";
	}

	public function SaveUpdate($id) {
		return "https://dev.users.info.unicaen.fr/projet-inf5c-2020/phone.php?phone=$id&amp;action=getSaveUpdate";
	}

	public function DeletePhone($id) {
		return "https://dev.users.info.unicaen.fr/projet-inf5c-2020/phone.php?phone=$id&amp;action=DeletePhone";
	}
	public function Home() {
		return "https://dev.users.info.unicaen.fr/projet-inf5c-2020/phone.php?action=Home";
	}

	public function Search() {
		return "https://dev.users.info.unicaen.fr/projet-inf5c-2020/phone.php?action=Search";
	}

	public function MoreDetails($id) {
		return "https://dev.users.info.unicaen.fr/projet-inf5c-2020/phone.php?phone=$id&amp;action=MoreDetails";
	}

	public function About() {
		return "https://dev.users.info.unicaen.fr/projet-inf5c-2020/phone.php?action=About";
	}

}
?>
