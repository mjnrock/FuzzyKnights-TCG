<?php
	class Stats {
		public $Strength;
		public $Toughness;
		public $Power;
		public $Resistance;
		public $Health;
		public $Mana;
		public $Durability;

		public function __construct($Card) {
			$this->SetStats($Card);
		}

		public function SetStats($Card) {
			$this->Strength = (int)$Card[0]["Strength"];
			$this->Toughness = (int)$Card[0]["Toughness"];
			$this->Power = (int)$Card[0]["Power"];
			$this->Resistance = (int)$Card[0]["Resistance"];
			$this->Health = (int)$Card[0]["Health"];
			$this->Mana = (int)$Card[0]["Mana"];
			$this->Durability = (int)$Card[0]["Durability"];

			return $this;
		}
	}
?>