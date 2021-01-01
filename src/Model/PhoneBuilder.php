<?php
require_once "Phone.php";
class PhoneBuilder {

	private $data;
	private $error;

	const NAME = 'name_phone';
	const COLOR = 'color';
	const PRICE = 'price';
	const OPTION = 'option';
	const PICTURE = 'picture';

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

	public function CreatePhone() {
		return new Phone($this->data[self::NAME],$this->data[self::COLOR],$this->data[self::PRICE],$this->data[self::OPTION],$this->data[self::PICTURE]);
	}

	public function isValid() {
		$bool = true;

		if ($this->data == null) {
			$this->error[self::NAME] = NULL;
			$this->error[self::COLOR] = NULL;
			$this->error[self::PRICE] = NULL;
			$this->error[self::OPTION] = NULL;
			$this->error[self::PICTURE] = NULL;
		} else {
			if ($this->data[self::NAME] == "") {
				$this->error[self::NAME] = "Name Empty";
				$bool = false;
			}
			if ($this->data[self::COLOR] == "") {
				$this->error[self::COLOR] = "Color Empty";
				$bool = false;
			}
			if ($this->data[self::PRICE] == "") {
				$this->error[self::PRICE] = "Price Empty";
				$bool = false;
			}
			if ($this->data[self::OPTION] == "") {
				$this->error[self::OPTION] = "Option Empty";
				$bool = false;
			}
		}
		return $bool;
	}
}

?>
