<?php
	require_once "{$_SERVER["DOCUMENT_ROOT"]}/router/views/peripheral/header.php";

	Router::SetServer($_SERVER);

	Router::QuickGet("/deck/table", "/views/deck/table");
	Router::QuickGet("/card/table", "/views/card/table");
	Router::Get("/card/s/:CardID", function($Request) {
		$Card = API::vwCardStatModifier(NULL, "CardID = {$Request->Variables["CardID"]}", NULL, "Name, Stage, Step");
		
		if(sizeof($Card) > 0) {
			require_once "{$_SERVER["DOCUMENT_ROOT"]}/router/views/card/card.php";
		} else {
			echo "<h4 class='tc'>Card Not Found</h4>";
		}
	});
	Router::Get("/deck/s/:DeckID", function($Request) {
		$Deck = API::vwDeck();
		
		if(sizeof($Deck) > 0) {
			require_once "{$_SERVER["DOCUMENT_ROOT"]}/router/views/deck/deck.php";
		} else {
			echo "<h4 class='tc'>Deck Not Found</h4>";
		}
	});
	
	require_once "{$_SERVER["DOCUMENT_ROOT"]}/router/views/peripheral/footer.php";
?>