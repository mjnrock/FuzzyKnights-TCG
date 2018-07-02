<?php
	require_once "{$_SERVER["DOCUMENT_ROOT"]}/libs/index.php";
	require_once "{$_SERVER["DOCUMENT_ROOT"]}/models/index.php";

	if(isset($_GET["Action"]) && isset($_GET["Payload"])) {
		$Payload = json_decode($_GET["Payload"]);

		if($_GET["Action"] === "UpdateState") {
			UpdateState($Payload);
		}
	}

	function UpdateState($Payload) {
		if(isset($Payload->Action)) {
			if(isset($Payload->DeckID)) {
				if($Payload->Action === "DeActivate") {
					$SQL = <<<SQL
					UPDATE TCG.Deck
					SET
						DeactivatedDateTime = CASE
							WHEN DeactivatedDateTime IS NULL THEN GETDATE()
							ELSE NULL
						END,
						ModifiedDateTime = GETDATE()
					OUTPUT
						Inserted.DeckID,
						CASE
							WHEN Inserted.DeactivatedDateTime IS NULL THEN 1
							ELSE 0
						END AS IsActive
					WHERE
						DeckID = {$Payload->DeckID}
SQL;
				} else if($Payload->Action === "Delete") {
					$SQL = <<<SQL
					EXEC TCG.DeleteDeck {$Payload->DeckID};
SQL;
				}
			} else {
				if($Payload->Action === "Add") {						
					$SQL = <<<SQL
					EXEC TCG.QuickCreateDeck
SQL;
				}
			}
			
			$result = API::query($SQL);
			echo json_encode($result);
		}
	}

?>