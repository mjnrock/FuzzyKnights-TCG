<?php
	namespace Deck {
		class Deck {
			public $ID;
			public $Name;
			public $Description;
			public $IsActive;

			public $UniqueCardCount;
			public $TotalCardCount;

			public function __construct($Deck) {
				$this->SetDeck($Deck);
			}

			public function SetDeck($Deck) {			
				$this->ID = (int)$Deck[0]["DeckID"];
				$this->Name = $Deck[0]["Name"];
				$this->Description = $Deck[0]["Description"];
				$this->IsActive = (int)$Deck[0]["IsActive"];

				$this->UniqueCardCount = (int)$Deck[0]["UniqueCardCount"];
				$this->TotalCardCount = (int)$Deck[0]["TotalCardCount"];

				return $this;
			}

			public static function InstantiateDecks($temps = null) {
				if(!isset($temps)) {
					$temps = \API::vwDeck();
				}
				$Decks = [];
				foreach($temps as $temp) {
					if(!isset($Decks[$temp["Name"]])) {
						$Decks[$temp["Name"]] = [];
					}
					$Decks[$temp["Name"]][] =  $temp;
				}
				foreach($Decks as $i => $Deck) {
					$Decks[$i] = new \Deck\Deck($Deck);
				}
	
				return $Decks;
			}
		}
	}
?>