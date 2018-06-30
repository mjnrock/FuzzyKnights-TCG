<?php
	$Tasks = API::Task(NULL, NULL, NULL, "Label");
	$CardTypes = API::CardType(NULL, NULL, NULL, "Label");
	$Disciplines = API::Discipline(NULL, NULL, NULL, "Label");
	$Requirements = API::CardType(NULL, NULL, NULL, "Label");
	$Targets = API::Target(NULL, NULL, NULL, "Y, X");

	require_once "{$_SERVER["DOCUMENT_ROOT"]}/router/partials/card.php";
?>