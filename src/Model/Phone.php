<?php
class Phone {

	private $name_phone;
	private $color;
	private $price;
	private $option;
	private $picture;

	public function __construct($name_phone, $color, $price, $option, $picture) {
		$this->name_phone = $name_phone;
		$this->color = $color;
		$this->price = $price;
		$this->option = $option;
		$this->picture = $picture;

	}

	public function get_Name_Phone() {
		return $this->name_phone;
	}

	public function get_color() {
		return $this->color;
	}

	public function get_price() {
		return $this->price;
	}

	public function get_option() {
		return $this->option;
	}

	public function get_picture() {
		return $this->picture;
	}

}
?>
