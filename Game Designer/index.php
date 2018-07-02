<?php
	require_once "{$_SERVER["DOCUMENT_ROOT"]}/routes/peripheral/header.php";

	Router::SetServer($_SERVER);

	Router::QuickGet("/deck/table", "Deck/table");
	Router::QuickGet("/card/table", "Card/table");
	Router::QuickGet("/card/anomaly", "Card/anomaly");
	Router::Get("/card/s/:CardID", function($Request) {
		$Card = API::vwCardStatModifier(NULL, "CardID = {$Request->Variables["CardID"]}", NULL, "Name, Stage, Step");
		
		if(sizeof($Card) > 0) {
			require_once "{$_SERVER["DOCUMENT_ROOT"]}/routes/Card/card.php";
		} else {
			echo "<h4 class='tc'>Card Not Found</h4>";
		}
	});
	Router::Get("/deck/s/:DeckID", function($Request) {
		$Deck = API::vwDeck(NULL, "DeckID = {$Request->Variables["DeckID"]}", NULL, "Name");
		
		if(sizeof($Deck) > 0) {
			require_once "{$_SERVER["DOCUMENT_ROOT"]}/routes/Deck/deck.php";
		} else {
			echo "<h4 class='tc'>Deck Not Found</h4>";
		}
	});
	
	require_once "{$_SERVER["DOCUMENT_ROOT"]}/routes/peripheral/footer.php";
?>