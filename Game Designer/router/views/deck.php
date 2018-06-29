<?php	
	$temps = API::vwCardStatModifier(NULL, NULL, NULL, "Name, Stage, Step");
	$Cards = [];
	foreach($temps as $temp) {
		if(!isset($Cards[$temp["Name"]])) {
			$Cards[$temp["Name"]] = [];
		}
		$Cards[$temp["Name"]][] =  $temp;
	}

	foreach($Cards as $key => $Card) {
		include "{$_SERVER["DOCUMENT_ROOT"]}/router/partials/card.php";
	}
?>