<?php
	require_once "{$_SERVER["DOCUMENT_ROOT"]}/libs/index.php";
	require_once "{$_SERVER["DOCUMENT_ROOT"]}/models/index.php";

	// print_r($_GET);
	if(isset($_GET["Action"]) && isset($_GET["Payload"])) {
		$Payload = json_decode($_GET["Payload"]);

		if($_GET["Action"] === "UpdateName") {
			Display::UpdateName($Payload);
		} else if($_GET["Action"] === "UpdateTask") {
			Display::UpdateTask($Payload);
		} else if($_GET["Action"] === "UpdateStat") {
			Display::UpdateStat($Payload);
		} else if($_GET["Action"] === "UpdateModifier") {
			Display::UpdateModifier($Payload);
		}
	}


	abstract class Display {
		public static function UpdateName($Payload) {
			$Payload->Name = str_replace("'", "''", $Payload->Name);

			$SQL = <<<SQL
			UPDATE TCG.Card
			SET
				Name = '{$Payload->Name}',
				ModifiedDateTime = GETDATE()
			OUTPUT
				Inserted.CardID,
				Inserted.Name
			WHERE
				CardID = {$Payload->CardID}
SQL;
			if(isset($Payload->CardID) && isset($Payload->Name)) {
				$result = API::query($SQL);

				echo json_encode($result);
			}
		}

		public static function UpdateTask($Payload) {			
			$SQL = <<<SQL
			UPDATE TCG.CardCategorization
			SET
				{$Payload->Table}ID = {$Payload->PKID},
				ModifiedDateTime = GETDATE()
			OUTPUT
				Inserted.CardID,
				Inserted.{$Payload->Table}ID AS PKID
			WHERE
				CardID = {$Payload->CardID}
SQL;
			if(isset($Payload->CardID) && isset($Payload->Table) && isset($Payload->PKID)) {
				$result = API::query($SQL);

				echo json_encode($result);
			}
		}

		public static function UpdateStat($Payload) {
			$SQL = <<<SQL
			UPDATE TCG.CardStat
			SET
				Value = {$Payload->Value},
				ModifiedDateTime = GETDATE()
			OUTPUT
				Inserted.CardID,
				Inserted.StatID,
				Inserted.Value
			FROM
				TCG.CardStat cs WITH (NOLOCK)
				INNER JOIN TCG.[Stat] s WITH (NOLOCK)
					ON cs.StatID = s.StatID
			WHERE
				cs.CardID = {$Payload->CardID}
				AND s.Short = '{$Payload->Key}'
SQL;
			if(isset($Payload->CardID) && isset($Payload->Key) && isset($Payload->Value)) {
				$result = API::query($SQL);

				echo json_encode($result);
			}
		}

		public static function UpdateModifier($Payload) {
			$SQL = <<<SQL
			UPDATE TCG.CardStatModifier
			SET
				{$Payload->Table}ID = {$Payload->PKID},
				ModifiedDateTime = GETDATE()
			OUTPUT
				Inserted.CardStatModifierID,
				Inserted.{$Payload->Table}ID
			WHERE
				CardStatModifierID = {$Payload->CardStatModifierID}
SQL;
			echo $SQL;
			if(isset($Payload->CardStatModifierID) && isset($Payload->Table) && isset($Payload->PKID)) {
				$result = API::query($SQL);

				echo json_encode($result);
			}
		}
	}
?>