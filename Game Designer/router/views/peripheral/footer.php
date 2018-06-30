
			<script>
				$(document).ready(function() {
					$("#nav-search-cardid").on("change", function(e) {
						window.location.href = `/card/${$("#nav-search-cardid").val()}`;
					});
				});
			</script>
		
			<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
			
			<link rel="stylesheet" href="/assets/css/materialize.min.css" />
			<link rel="stylesheet" href="/assets/css/tachyons.min.css" />
			<link rel="stylesheet" href="/assets/css/jquery.dataTables.min.css" />

			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-rc.2/css/materialize.min.css">
			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tachyons/4.9.1/tachyons.min.css" />
			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.19/css/jquery.dataTables.min.css" />
		</div>
	</body>
</html>