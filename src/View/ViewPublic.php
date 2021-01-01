<?php
require_once "Router.php";
require "src/Model/Account.php";

class ViewPublic {
	protected $title;
	protected $content;
	protected $router;
	protected $feedback;

	public function __construct(Router $router) {
		$this->router = $router;
		$this->title = null;
		$this->content = null;
	}

	public function render() {
		echo "<html><head><title>" . $this->title . "</title></head><body>" . $this->content . "<link rel='stylesheet' type='text/css' href='https://dev-.users.info.unicaen.fr/projet-inf5c-2020/src/CSS/style.css'></body></html>";
	}

	public function MakeHomePage() {
		$this->title = "WEBSITE PHONE";
		$this->content = "<table class='Pview' cellspacing='0' style='text-align:center;border-width: 2px;' align='center' width='100%'>
  			<br><tr><td><a class ='btnn' href=" . $this->router->Home() . ">Home</a></td>
  			<td><a class ='btnn' href=" . $this->router->CreateNewAccount() . ">Registration</a></td>
  			<td><a class ='btnn' href=" . $this->router->PageAuth() . ">Connection</a></td>
  			<td><a class ='btnn' href=" . $this->router->About() . ">About</a></td></tr></table>";

	}

	public function MakeNewAccount($accountbuilder) {
		$this->title = "Registration";

		$login = key_exists('login', $accountbuilder->geterror()) ? $accountbuilder->geterror()["login"] : "";
		$password = key_exists('password', $accountbuilder->geterror()) ? $accountbuilder->geterror()["password"] : "";
		$password_confirm = key_exists('password_confirm', $accountbuilder->geterror()) ? $accountbuilder->geterror()["password_confirm"] : "";
		$first_name = key_exists('first_name', $accountbuilder->geterror()) ? $accountbuilder->geterror()["first_name"] : "";
		$last_name = key_exists('last_name', $accountbuilder->geterror()) ? $accountbuilder->geterror()["last_name"] : "";

		$this->content .= "<form class ='form_sign_up' action=" . $this->router->SaveNewAccount() . " method='POST'>";
		$this->content .= "<h1 id ='Registration_text' align='center'>Registration</h1>";
		$this->content .= "<label class='login_sign_up'>LOGIN <input id ='input_name_sign_up' type='text' name=" . AccountBuilder::LOGIN . " placeholder='Login*' ></label><br>" . $login . "<br><br>";
		$this->content .= "<label class='pass_sign_up' >PASSWORD <input id ='input_password_sign_up' type='password' name=" . AccountBuilder::PASSWORD . " placeholder='Password*'></label><br>" . $password . "<br><br>";
		$this->content .= "<label class='pass_confirm_sign_up' > CONFIRM PASSWORD<input id ='input_conf_password_sign_up' type='password' name=" . AccountBuilder::PASSWORD_CONFIRM . " placeholder='Password Confirmation*'><br>" . $password_confirm . "</label><br><br>";
		$this->content .= "<label class='first_name_sign_up'><label id='f_name'>FIRST NAME </label><input id ='input_first_name_sign_up' type='text' name=" . AccountBuilder::FIRST_NAME . " placeholder='First Name*'></label><br>" . $first_name . "<br><br>";
		$this->content .= "<label class='last_name_sign_up'>LAST NAME<input id ='input_second_name_sign_up' type='text' name=" . AccountBuilder::LAST_NAME . " placeholder='Last Name*'></label><br>" . $last_name . "<br><br>";
		$this->content .= "<label class='sub_sign_up_rest' ><input class='rest_sign_up' type='reset' name='' value='Cancel'></label><label class='sub_sign_up_valid'><input class='submit_sign_up' type='submit' name='' value='Submit'></label></form>";
	}

	Public function PageAuth(AuthentificationManager $authen) {
		$this->MakeHomePage();
		$this->title = "Connection";
		$login1 = key_exists('login', $authen->geterror()) ? $authen->geterror()["login"] : "";
		$password1 = key_exists('password', $authen->geterror()) ? $authen->geterror()["password"] : "";

		$this->content .= "<form class='form_sign_in' action =" . $this->router->Authentification() . " method='POST'>";
		$this->content .= "<h1 class ='text_login' align='center'>Login</h1>";
		$this->content .= "<table  cellspacing='0' align='center'><tr><td><br>" . $login1 . " " . $password1 . "</td></tr>";
		$this->content .= "<label class='lo' ><label class='name_lo'>LOGIN </label><input id='input_log' type='text' name=" . AccountBuilder::LOGIN . " placeholder='Login*'></label><br><br>";
		$this->content .= "<label class='pas' >PASSWORD <input id='input_pass' type='password' name=" . AccountBuilder::PASSWORD . " placeholder='Password*'></label><br><br><br>";
		$this->content .= "<label class='sub_rest' ><input class='rest_sign_in'type='reset' name='' value='Cancel'></label><label class ='sub_submit' ><input class='sub_sign_in'type='submit' name='' value='Valid'></label></form>";
	}

	public function HomePagePublic(array $phones) {
		$this->content .= "<h1 id='logo'> BUY YOUR PHONE ... </h1>";
		$this->content .= "<div class='Main'><form action=" . $this->router->Search() . " method='POST'><input class='search_bar_label' type='text' name='cherche' placeholder='Find your Phone...'>";
		$this->content .= "<label class='espace'> PRICE : <select id ='option' name='price'><option value='0'>Increasing</option><option value='1'>Decreasing</option>";
		$this->content .= "<label class='search_label'><input class ='search_btn' type='submit' type='submit' value='Search'></select></div></form>";
		foreach ($phones as $key => $value) {
			$this->content .= "<div class='contriha'> <img src='https://dev-.users.info.unicaen.fr/projet-inf5c-2020/src/image/" . $value->get_picture() . "' style='background-size: cover;width:200px;height:200px;'><br>" . "&nbsp" . $value->get_Name_Phone() . " <br><a class ='btn_detail' href=" . $this->router->MoreDetails($key) . ">More Details</a></div>";
		}
	}

	public static function htmlesc($str) {
		return htmlspecialchars($str,
			ENT_QUOTES
			 | ENT_SUBSTITUTE
			 | ENT_HTML5,
			'UTF-8');
	}

	public function Aboutpage() {
		$this->content .= "<div class='About'><h2> Numeros des membres et Groupe:  </h2>
        <p> <b> 21812559, <b> 21911196  et   22014452  Groupe Numeros : 45  </b></p>
        <h2> Quelques points sur notre MINI SITE </h2>

            <p> <ul> <li>Pour la modelisation de notre projet on a suivi ce qu on a vu dans les TPs, au CM et principalement le modele MVCR qui nous a permis de faire evoluer le code et la conception sans faire d'interdependances entre les classes. </li>

            <li>Dans la partie model on a deux parties principales (Gestion des comptes, gestion des telephones).</li>

            <li>La partie Vue on retrouve une classe ViewPublic qui est accessible par tout les visiteurs, et une classe ViewPrivate qui herite de la classe ViewPublic faite specialement pour les utilisateurs connectes, par contre les visiteurs inconus n'ont pas le possibilte d'acceder aux details d'un telephone donne jusqu'ils fassent leurs inscription sur le site.</li></li>

            <li>Les utilisateurs connectes ont la possibilite d'ajouter, d'editer et de supprimer leurs propores telephones portables.</li>

            <li>Pour se connecter sur la base de donnee, on a utilise la fonctionalite PDO vue pendant TP,CM...</li>

            </p>

            <h2>Repartition des taches dans le groupe.</h2>

            <p>
                <ul>
                    <li>La repartition des taches est faite selon les exigences du model MVCR , ou LAHCENE BOUSADIA et KAMEL ABBAD ont pris la partie Controleur et Model et enfin Imene Bessaa a prit View et CSS.
                         </li>
                </ul>
            </p>

            <h2>Les principaux choix en matiere de design, code :</h2>

            <p>
                <ul>
                    <li>On a utilis qu un fichier CSS sans faire de JavaScript a cause du temps limite. On s'est aussi servi du site w3schools.com pour bien implementer nos idees.</li>
                    <li>La partie du code, on a essaye au maximum de minimiser le code.</li>
                </ul>
            </p>


            <h2> Taches non realise et problemes : </h2>

            <p>
                <ul>
                    <li> On n a pu faire un fichier de configuration pour la base de donne et meme pour l instance PDO elle n est pas separee dans un fichier, donc notre site est un peu moins securise ! </li>
                    <li> Pour la partie du  Hashage  on n est pas arrive a inserer le mot de passe crypte dans la base de donnee donc on n a pas pu utiliser la fonction password_verify, donc on a utilise les mots de passe non crypte, malgre qu on a essaye pleine de fois de crypter le mot de passe mais malhereusement on pas pu arrivee le decrypter.</li>
                    <li> On n avait pas mal de fois des probleme avec le serveur de la fac, il se plantait a chaque execution, des fois on travait mais il faisait pas la sauvegarde, aussi on a eu des problemes avec la base de donnee ou parfois on arrive pas a acceder a notre base de donnee.</li>
                </ul>
            </p>
        </div>";
	}

}

?>
