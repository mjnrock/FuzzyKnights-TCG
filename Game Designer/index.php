<?php
	require_once "{$_SERVER["DOCUMENT_ROOT"]}/router/views/peripheral/header.php";

	Router::SetServer($_SERVER);

	Router::QuickGet("/deck", "/views/deck");
	Router::QuickGet("/table", "/views/table");
	Router::Get("/card/:CardID", function($Request) {
		$Card = API::vwCardStatModifier(NULL, "CardID = {$Request->Variables["CardID"]}", NULL, "Name, Stage, Step");
		
		if(sizeof($Card) > 0) {
			require_once "{$_SERVER["DOCUMENT_ROOT"]}/router/views/card.php";
		} else {
			echo "<h4 class='tc'>Card Not Found</h4>";
		}
	});
	
	require_once "{$_SERVER["DOCUMENT_ROOT"]}/router/views/peripheral/footer.php";
?>