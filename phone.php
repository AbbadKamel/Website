<?php

set_include_path("./src");

/* Inclusion des classes utilises dans ce fichier */
require_once "Router.php";
require_once "Model/AccountStorageMySQL.php";
require_once "Model/PhoneStorageMySQL.php";

try {
	$bd = new PDO("mysql:host=mysql.info.unicaen.fr;port=3306;dbname=21911536_0;charset=utf8", "21911536", "nush5vo3Foegaelu");
} catch (Exception $e) {
	echo "ERROR YOUR DON'T HAVE ACCESS OR SOMETHING WENT WRONG !!!!";
}

$account = new AccountStorageMySQL($bd);
$phone = new PhoneStorageMySQL($bd);

$router = new Router();
$router->main($account, $phone);

?>
