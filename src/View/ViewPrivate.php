<?php
require_once "src/Router.php";
require_once "src/Model/Account.php";
require_once "Model/PhoneBuilder.php";

class ViewPrivate extends ViewPublic {
	private $account;

	function __construct(Router $router, Account $account, $feedback) {
		$this->feedback = $feedback;
		$this->account = $account;
		$this->router = $router;
		$this->menu = array(
			"Home" => $this->router->Home(),
			"Phones List" => $this->router->ListPhones($this->account->getlog()),
			"Add New Phone" => $this->router->AddNewPhone(),
			"About" => $this->router->About(),
			"Disconnection" => $this->router->Disconnection(),
		);
	}

	public function HomePagePublic(array $phones) {
		$this->title = "Welcome " . $this->account->getfirst_name();
		$this->content .= "<h1 id='logo'> BUY YOUR PHONE ... </h1>";
		$this->content .= "<div class='Main'><form action=" . $this->router->Search() . " method='POST'><br><input class='search_bar_label' type='text' name='cherche' placeholder='Find you Phone...'>";
		$this->content .= "<label class='espace'> Price :<select id ='option' name='price'><option value='0'>Increasing</option><option value='1'>Decreasing</label></option>";
		$this->content .= "<label class='search_label'><input class ='search_btn' type='submit' value='Search'></select></label></form></div>";
		foreach ($phones as $key => $value) {
			$this->content .= "<div class='contriha' >" . " <img src='https://dev-.users.info.unicaen.fr/projet-inf5c-2020/src/image/" . $value->get_picture() . "'  style='background-size: cover;width:200px;height:200px;'><br>" . "&nbsp" . $value->get_Name_Phone() . " <br><a class ='btn_detail' href=" . $this->router->MoreDetails($key) . ">More Details</a> </div></div>";
		}
	}

	public function MakeHomePage() {
		$this->title = "My Phones";
		$this->content = "<table  class ='PriView' cellspacing='0' style='text-align:center;border-width: 2px;' align='center' width='100%'>
			<tr><td><a class ='btnn' href=" . $this->router->Home() . ">Home</a></td>&nbsp;
				<td><a  class ='btnn' href=" . $this->menu["Phones List"] . ">Phones List</a></td>&nbsp;
  				<td><a  class ='btnn' href=" . $this->menu["Add New Phone"] . ">Add New Phone</a></td>
  				<td><a  class ='btnn' href=" . $this->menu["About"] . ">About</a></td>
				<td><a  class ='btnn' href=" . $this->menu["Disconnection"] . ">Disconnection</a></td>
  			</tr></table><h4>" . $this->feedback . "</h4>";
	}

	public function GetListPhones(array $phone) {
		$this->title = "My Phones";

		if ($phone) {
			foreach ($phone as $key => $value) {
				$data = $value->get_Name_Phone();

				$this->content .= "<div class='pic_List_Phone'> <img src='https://dev-.users.info.unicaen.fr/projet-inf5c-2020/src/image/" . $value->get_picture() . "' style='background-size: cover;width:200px;height:200px;'></div>";
				$this->content .= "<div class ='List_PriView'><label> Name of phone :  " . $value->get_Name_Phone() . "</label><br>";
				$this->content .= "<label>Color: <label name='color' >" . $value->get_color() . "</label></label><br>";
				$this->content .= "<label>Price: " . $value->get_price() . "</label><br><br>";
				$this->content .= "<p id='option_display' >Option: " . $value->get_option() . "</p><br>";
				$this->content .= "<label><a class ='Update_Phone_btn' href=" . $this->router->UpdatePhonePage($key) . " >Update</a> <a class ='Delete_Phone_btn'href=" . $this->router->DeletePhone($key) . ">Delete</a></label><br><br></div>";
			}
		} else {
			$this->content .= "<h1 id='no_phone'> You don't have any phone ! <br><br> Please add new phone :) <br> Thank you </h1>";
		}
	}

	public function MakeNewPhone(PhoneBuilder $phonebuilder) {

		$name_phone = key_exists('name_phone', $phonebuilder->geterror()) ? $phonebuilder->geterror()["name_phone"] : "";
		$color = key_exists('color', $phonebuilder->geterror()) ? $phonebuilder->geterror()["color"] : "";
		$price = key_exists('price', $phonebuilder->geterror()) ? $phonebuilder->geterror()["price"] : "";
		$option = key_exists('option', $phonebuilder->geterror()) ? $phonebuilder->geterror()["option"] : "";

		$this->content .= "<div class='form_New_Phone'> <form action=" . $this->router->getphone() . " method=POST><table  cellspacing='0' align='center'>";
		$this->content .= "<h1 id='add_phone_text' align='center'>Add New Phone</h1>";
		$this->content .= "<label class='Name_new_phone' >Name of phone  <input class ='Name_box' type='text' name='" . PhoneBuilder::NAME . "' value='" . $phonebuilder->getdata()['name_phone'] . "'><br>" . $name_phone . "</label><br>";
		$this->content .= "<label class='Color_New_Phone'>color  <input class ='Color_box' type='text' name='" . PhoneBuilder::COLOR . "' value='" . $phonebuilder->getdata()['color'] . "'><br>" . $color . "</label><br>";
		$this->content .= "<label class='Price_New_Phone' >Price   <input class ='Price_box' type='text' name='" . PhoneBuilder::PRICE . "' value='" . $phonebuilder->getdata()['price'] . "'><br>" . $price . "</label><br>";
		$this->content .= "<label class='Option_New_Phone' >Options      <textarea  class= 'Option_box' name='" . PhoneBuilder::OPTION . "' rows='8' cols='50'>" . $phonebuilder->getdata()['option'] . "</textarea><br>" . $option . "</label><br>";
		$this->content .= "<label class='Pic_New_Phone' >Picture   <input id ='pic_box' type='file' name='" . PhoneBuilder::PICTURE . "'><br></label><br>";
		$this->content .= "<label class='Cancel_Add_New_Phone'><input class='btn_cancel_New_Phone' type='reset' name='' value='Cancel'></label>";
		$this->content .= "<label class='sub_Add_New_Phone'><input class='btn_sub_New_Phone'  type='submit' name='' value='Submit'></label>";
		$this->content .= "</form></div>";

	}

	public function getlog() {
		return $this->account->getlog();
	}

	public function UpdatePhonePage(array $phone) {
		$phonebuilder = new phonebuilder(null);
		$name_phone = key_exists('name_phone', $phonebuilder->geterror()) ? $phonebuilder->geterror()["name_phone"] : "";
		$color = key_exists('color', $phonebuilder->geterror()) ? $phonebuilder->geterror()["color"] : "";
		$price = key_exists('price', $phonebuilder->geterror()) ? $phonebuilder->geterror()["price"] : "";
		$option = key_exists('option', $phonebuilder->geterror()) ? $phonebuilder->geterror()["option"] : "";
		$picture = key_exists('picture', $phonebuilder->geterror()) ? $phonebuilder->geterror()["picture"] : "";

		foreach ($phone as $key => $value) {
			$this->content .= "<div class='update_form'> <form action=" . $this->router->SaveUpdate($key) . " method='POST'>";
			$this->content .= "<h1 id='update_text' align='center'>Modify Phone</h1>";
			$this->content .= "<label id='Name_text_update'> phone name </label><input class ='update_inputs' type='text' name='" . PhoneBuilder::NAME . "' value=" . $value->get_Name_Phone() . "><br><br>";
			$this->content .= "<label> Color: </label><input class ='update_inputs' type='text' name='" . PhoneBuilder::COLOR . "' value=" . $value->get_color() . "><br><br>";
			$this->content .= "<label> Price: </label><input class ='update_inputs' type='text' name='" . PhoneBuilder::PRICE . "' value=" . $value->get_price() . "><br><br>";
			$this->content .= "<input class ='update_inputs' type='text' name='" . PhoneBuilder::PICTURE . "' value='h' hidden>";
			$this->content .= "<label id='option_text_update'>Options:  </label><textarea class ='update_inputs' name='" . PhoneBuilder::OPTION . "' rows='8' cols='50'>" . $value->get_option() . "</textarea><br><br>";
			$this->content .= "<input class='Cancel_Updated_btn' type='reset' name='' value='Cancel'>";
			$this->content .= "<input class='Sub_update_phone' type='submit' name='' value='Submit'></form></div>";
		}

	}

	public function HomePage(array $phone) {
		$this->title = "My Phones";
		foreach ($phone as $key => $value) {
			//$this->content .= $value->get_Name_Phone() . " Price " . $value->get_price() . "<br><br>";
			$this->content .= " <div class='One_Phone'><div class='Name_details'><br> " . $value->get_Name_Phone() . "</div>";
			$this->content .= " <div class='Price_details'> Price : " . $value->get_price() . "€ </div>";
			$this->content .= " <div class='Color_details'> Color : " . $value->get_color() . "</div>";
			$this->content .= " <div class='Option_details'> Option : " . $value->get_option() . "</div>";
			$this->content .= " <div class='Photo_details'> <img src='https://dev-.users.info.unicaen.fr/projet-inf5c-2020/src/image/" . $value->get_picture() . "' style='background-size: cover;width:380px;height:350px;'></div></div><br><br>";
		}
	}

	public function displayPhoneCreate($login) {
		$this->router->RedirectURL($this->router->ListPhones($login), "SUCCESSFULL CREATED");
	}

	public function displayPhoneModification($login) {
		$this->router->RedirectURL($this->router->ListPhones($login), "SUCCESSFULL Modification");
	}
	public function displayPhoneDeletion($login) {
		$this->router->RedirectURL($this->router->ListPhones($login), "SUCCESSFULL Deleted");
	}

}
?>
