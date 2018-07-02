<?php
	$Cards = API::vwAnomalyFinder();
	$Cards = \Card\Card::InstantiateCards($Cards);
?>

<?php
	$ShowAnomalyMessage = TRUE;
	require "{$_SERVER["DOCUMENT_ROOT"]}/components/Card/table.php";
?>

<script>		
	$(document).ready(function() {
		$(".table-card tbody > tr").on("dblclick", function () {
			window.location.href = `/card/s/${$(this).attr("card-id")}`;
		});

		$("div[action]").on("click", function() {
			if($(this).attr("action") === "Add") {
				AJAX("Card", "UpdateState", {
					Action: "Add"
				}, (e) => {
					if(e !== null && e !== void 0) {
						let response = JSON.parse(e)[0];
						
						location.href = `/card/s/${response.CardID}`;
					}
				});
			} else if($(this).attr("action") === "Edit") {
				location.href = `/card/s/${$(this).parents("tr[card-id]").attr("card-id")}`;
			} else if($(this).attr("action") === "DeActivate") {
				AJAX("Card", "UpdateState", {
					CardID: $(this).parents("tr[card-id]").attr("card-id"),
					Action: "DeActivate"
				}, (e) => {
					if(e !== null && e !== void 0) {
						let response = JSON.parse(e)[0];

						$(this).attr("class", `btn mr1 white ba ${+response.IsActive === 1 ? "green lighten-3 green-text text-darken-2" : "grey lighten-3 grey-text text-darken-2"}`);
						$(this).find("i").text(+response.IsActive === 1 ? "visibility_on" : "visibility_off");
					}
				});
			} else if($(this).attr("action") === "Delete") {
				if(confirm("Are you sure?")) {
					AJAX("Card", "UpdateState", {
						CardID: $(this).parents("tr[card-id]").attr("card-id"),
						Action: "Delete"
					}, (e) => {
						if(e !== null && e !== void 0) {
							let response = JSON.parse(e)[0];

							$(`tr[card-id=${response.CardID}]`).remove();
						}
					});
				}
			}
		});
	});
</script>