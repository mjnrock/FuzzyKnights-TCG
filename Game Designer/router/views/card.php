<?php
	$Tasks = API::Task();
	$CardTypes = API::CardType();
	$Disciplines = API::Discipline();
	$Requirements = API::CardType();

	// echo "<pre>";
	// print_r($Tasks);
	// print_r($CardTypes);
	// print_r($Disciplines);
	// print_r($Requirements);
	// echo "</pre>";
	require_once "{$_SERVER["DOCUMENT_ROOT"]}/router/partials/card.php";
?>