<?php
	require_once "{$_SERVER["DOCUMENT_ROOT"]}/models/Categories.php";
	require_once "{$_SERVER["DOCUMENT_ROOT"]}/models/Stats.php";

	class Card {
		public $ID;
		public $Name;
		public $Picture;

		public $Categories;
		public $Stats;

		public $Modifiers = [];

		public function __construct($Card) {
			$this->SetCard($Card);
		}

		public function SetCard($Card) {			
			$this->ID = $Card[0]["CardID"];
			$this->Name = $Card[0]["Name"];
			$this->Picture = $Card[0]["Picture"];

			$this->Categories = new Categories($Card);
			$this->Stats = new Stats($Card);

			foreach($Card as $i => $Mod) {
				$this->Modifiers[] = [
					"Stat" => [],
					"Target" => [],
					"Values" => [],
				];
				
				$this->Modifiers[$i]["CardStatModifierID"] = (int)$Mod["CardStatModifierID"];
				$this->Modifiers[$i]["Stat"]["ID"] = (int)$Mod["StatID"];
				$this->Modifiers[$i]["Stat"]["Short"] = $Mod["StatShort"];
				$this->Modifiers[$i]["Stat"]["Label"] = $Mod["StatLabel"];
				$this->Modifiers[$i]["Stat"]["Action"] = [];
				$this->Modifiers[$i]["Stat"]["Action"]["Short"] = $Mod["StatActionShort"];
				$this->Modifiers[$i]["Stat"]["Action"]["Label"] = $Mod["StatActionLabel"];
				
				$this->Modifiers[$i]["Target"]["ID"] = (int)$Mod["TargetID"];
				$this->Modifiers[$i]["Target"]["X"] = (int)$Mod["X"];
				$this->Modifiers[$i]["Target"]["Y"] = (int)$Mod["Y"];
				$this->Modifiers[$i]["Target"]["IsFriendly"] = $Mod["IsFriendly"];
				$this->Modifiers[$i]["Target"]["Short"] = $Mod["TargetShort"];
				$this->Modifiers[$i]["Target"]["Label"] = $Mod["TargetLabel"];
				
				$this->Modifiers[$i]["Values"]["ID"] = (int)$Mod["CardStatModifierID"];
				$this->Modifiers[$i]["Values"]["Lifespan"] = (int)$Mod["Lifespan"];
				$this->Modifiers[$i]["Values"]["Number"] = (int)$Mod["Number"];
				$this->Modifiers[$i]["Values"]["Sided"] = (int)$Mod["Sided"];
				$this->Modifiers[$i]["Values"]["Bonus"] = (int)$Mod["Bonus"];
				$this->Modifiers[$i]["Values"]["Stage"] = (int)$Mod["Stage"];
				$this->Modifiers[$i]["Values"]["Step"] = (int)$Mod["Step"];
			}

			return $this;
		}
	}
?>