<?php
	class Categories {
		public $Task = [];
		public $CardType = [];
		public $Discipline = [];
		public $RequirementCardType = [];

		public function __construct($Card) {
			$this->SetCategories($Card);
		}

		public function SetCategories($Card) {
			$this->Task["ID"] = (int)$Card[0]["TaskID"];
			$this->Task["Short"] = $Card[0]["TaskShort"];
			$this->Task["Label"] = $Card[0]["TaskLabel"];
			
			$this->CardType["ID"] = (int)$Card[0]["CardTypeID"];
			$this->CardType["Short"] = $Card[0]["CardTypeShort"];
			$this->CardType["Label"] = $Card[0]["CardTypeLabel"];
			
			$this->Discipline["ID"] = (int)$Card[0]["DisciplineID"];
			$this->Discipline["Short"] = $Card[0]["DisciplineShort"];
			$this->Discipline["Label"] = $Card[0]["DisciplineLabel"];
			
			$this->RequirementCardType["ID"] = isset($Card[0]["RequirementCardTypeID"]) ? (int)$Card[0]["RequirementCardTypeID"] : null;
			$this->RequirementCardType["Short"] = $Card[0]["RequirementCardTypeShort"];
			$this->RequirementCardType["Label"] = $Card[0]["RequirementCardTypeLabel"];

			return $this;
		}
	}
?>