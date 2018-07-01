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
		<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.19/js/jquery.dataTables.min.js"></script>

		<!-- <script src="/assets/js/jquery.min.js"></script>
		<script src="/assets/js/materialize.min.js"></script>
		<script src="/assets/js/jquery.dataTables.min.js"></script> -->

		<link rel="stylesheet" href="/assets/css/card.css" />

		<title>Game Designer</title>
	</head>
	<body>
		<script>			
			function AJAX(action, content, callback) {
				callback = !!callback ? callback : function(e){};
				$.ajax({
					url: "/api/ajax.php",
					data: {
						Action: action,
						Payload: JSON.stringify(content)
					},
					success: callback
				});
			}
		</script>

		<nav>
			<div class="nav-wrapper deep-purple lighten-1">
				<ul id="nav-mobile" class="hide-on-med-and-down">
					<li><a href="<?= "/table"; ?>">Table</a></li>

					<li class="right"><input id="nav-search-cardid" type="number" placeholder="Search Card ID" /></li>
				</ul>
			</div>
		</nav>
		<div class="container">
			<br />