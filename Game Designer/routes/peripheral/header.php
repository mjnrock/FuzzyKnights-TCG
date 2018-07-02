<?php
	require_once "{$_SERVER["DOCUMENT_ROOT"]}/libs/index.php";
	require_once "{$_SERVER["DOCUMENT_ROOT"]}/models/index.php";
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">

		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-rc.2/js/materialize.min.js"></script>
		<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.19/js/jquery.dataTables.min.js"></script> -->

		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.30.6/js/jquery.tablesorter.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.30.6/js/jquery.tablesorter.widgets.min.js"></script>
		<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.30.6/js/widgets/widget-filter.min.js"></script> -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.30.6/js/extras/jquery.tablesorter.pager.min.js"></script>
		<!-- <script src="/assets/js/jquery.min.js"></script>
		<script src="/assets/js/materialize.min.js"></script>
		<script src="/assets/js/jquery.dataTables.min.js"></script> -->

		<link rel="stylesheet" href="/assets/css/card.css" />

		<title>Game Designer</title>
	</head>
	<body>
		<script>			
			function AJAX(domain, action, content, callback) {
				callback = !!callback ? callback : function(e){};
				$.ajax({
					url: `/api/${domain}.php`,
					data: {
						Action: action,
						Payload: JSON.stringify(content)
					},
					success: callback
				});
			}
		</script>

		<nav class="fixed">
			<div class="nav-wrapper blue darken-1">
				<ul id="nav-mobile" class="hide-on-med-and-down">
					<li><a href="<?= "/card/table"; ?>">Cards</a></li>
					<li><a href="<?= "/deck/table"; ?>">Decks</a></li>
					<li><a href="<?= "/card/anomaly"; ?>">Anomalies</a></li>

					<li class="right"><input id="nav-search-cardid" type="number" placeholder="Search Card ID" /></li>
				</ul>
			</div>
		</nav>
		<br /><br /><br /><br />
		<div class="ml2 mr2">
			<br />