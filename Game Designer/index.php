<?php
	require_once "{$_SERVER["DOCUMENT_ROOT"]}/router/views/peripheral/header.php";

	Router::SetServer($_SERVER);
	Router::QuickGet("/deck", "views/deck");
	
	require_once "{$_SERVER["DOCUMENT_ROOT"]}/router/views/peripheral/footer.php";
?>