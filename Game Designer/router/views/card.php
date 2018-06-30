<?php
	$Tasks = API::Task(NULL, NULL, NULL, "Label");
	$CardTypes = API::CardType(NULL, NULL, NULL, "Label");
	$Disciplines = API::Discipline(NULL, NULL, NULL, "Label");
	$Requirements = API::CardType(NULL, NULL, NULL, "Label");

	$Targets = API::Target(NULL, NULL, NULL, "Y, X");	
	$Stats = API::Stat(NULL, NULL, NULL, "Label");
	$StatActions = API::StatAction(NULL, NULL, NULL, "Label");

	require_once "{$_SERVER["DOCUMENT_ROOT"]}/router/partials/card/card.php";
?>