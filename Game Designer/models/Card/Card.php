<?php
	namespace Card {		
		require_once "{$_SERVER["DOCUMENT_ROOT"]}/models/Card/Categories.php";
		require_once "{$_SERVER["DOCUMENT_ROOT"]}/models/Card/Stats.php";
		
		class Card {
			public $Quantity;
			public $AnomalyMessages = [];

			public $ID;
			public $Name;
			public $Picture;
			public $IsActive;

			public $Categories;
			public $Stats;

			public $Modifiers = [];

			public static $ColorLookup = [
				"Task" => [
					"A" => "blue-text text-darken-4",
					"E" => "green-text text-darken-4",
					"Q" => "brown-text",
					"I" => "deep-purple-text text-accent-2"
				],
				"Discipline" => [
					"M" => "deep-purple-text text-darken-3",
					"P" => "grey-text text-darken-2",
					"H" => "cyan-text text-darken-2"
				],
				"Target" => [
					"Friendly" => "green-text text-lighten-1",
					"Enemy" => "red-text text-lighten-1"
				],
				"Stat" => [
					"STR" => "red-text text-darken-4",
					"TGH" => "orange-text text-darken-3",
					"PWR" => "deep-purple-text text-darken-3",
					"RES" => "indigo-text text-lighten-2",
					"HP" => "green-text text-darken-3",
					"MP" => "light-blue-text text-darken-1",
					"DUR" => "grey-text text-darken-1",
				],
				"StatAction" => [
					"Background" => [
						"+" => "green lighten-3 grey-text text-darken-3",
						"-" => "red lighten-3 grey-text text-darken-3",
						"*" => "cyan lighten-2 grey-text text-darken-3",
						"/" => "pink lighten-2 grey-text text-darken-3",
						"Buff" => "deep-purple lighten-2 grey-text text-darken-3",
						"Debuff" => "indigo lighten-2 grey-text text-darken-3",
						"Base" => "grey darken-1 grey-text text-darken-3"
					],
					"Foreground" => [
						"+" => "green-text text-lighten-3",
						"-" => "red-text text-lighten-3",
						"*" => "cyan-text text-lighten-2",
						"/" => "pink-text text-lighten-2",
						"Buff" => "deep-purple-text text-lighten-2",
						"Debuff" => "indigo-text text-lighten-2",
						"Base" => "grey-text text-darken-1"
					]
				]
			];

			public function __construct($Card) {
				$this->SetCard($Card);
			}

			public function SetCard($Card) {			
				$this->Quantity = isset($Card[0]["Quantity"]) ? (int)$Card[0]["Quantity"] : null;

				$this->ID = (int)$Card[0]["CardID"];
				$this->Name = $Card[0]["Name"];
				$this->Picture = $Card[0]["Picture"];
				$this->IsActive = (int)$Card[0]["IsActive"];

				$this->Categories = new \Card\Categories($Card);
				$this->Stats = new \Card\Stats($Card);

				foreach($Card as $i => $Mod) {
					if(isset($Mod["AnomalyMessage"])) {
						$this->AnomalyMessages[] = $Mod["AnomalyMessage"];
					}

					if(isset($Mod["StatID"])) {
						$this->Modifiers[] = [
							"Stat" => [],
							"Target" => [],
							"Values" => [],
						];
						
						$this->Modifiers[$i]["CardStatModifierID"] = (int)$Mod["CardStatModifierID"];
						$this->Modifiers[$i]["IsActive"] = (int)$Mod["ModifierIsActive"] === 1 ? TRUE : FALSE;
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
				}

				$this->AnomalyMessages = array_unique($this->AnomalyMessages);

				return $this;
			}

			public static function InstantiateCards($temps = null) {
				if(!isset($temps)) {
					$temps = \API::vwCardStatModifier(NULL, NULL, NULL, "Name, Stage, Step");
				}
				$Cards = [];
				foreach($temps as $temp) {
					if(!isset($Cards[$temp["Name"]])) {
						$Cards[$temp["Name"]] = [];
					}
					$Cards[$temp["Name"]][] =  $temp;
				}
				foreach($Cards as $i => $Card) {
					$Cards[$i] = new \Card\Card($Card);
				}

				return $Cards;
			}
		}
	}
?>