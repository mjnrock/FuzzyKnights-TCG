<?php
	$Decks = \Deck\Deck::InstantiateDecks();
?>

<?php
	require "{$_SERVER["DOCUMENT_ROOT"]}/components/Deck/table.php";
?>

<script>		
	$(document).ready(function() {
		$(".table-deck tbody > tr").on("dblclick", function () {
			window.location.href = `/deck/s/${$(this).attr("deck-id")}`;
		});

		$("div[action]").on("click", function() {
			if($(this).attr("action") === "Add") {
				AJAX("Deck", "UpdateState", {
					Action: "Add"
				}, (e) => {
					if(e !== null && e !== void 0) {
						let response = JSON.parse(e)[0];
						
						location.href = `/deck/s/${response.DeckID}`;
					}
				});
			} else if($(this).attr("action") === "Edit") {
				location.href = `/deck/s/${$(this).parents("tr[deck-id]").attr("deck-id")}`;
			} else if($(this).attr("action") === "DeActivate") {
				AJAX("Deck", "UpdateState", {
					DeckID: $(this).parents("tr[deck-id]").attr("deck-id"),
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
					AJAX("Deck", "UpdateState", {
						DeckID: $(this).parents("tr[deck-id]").attr("deck-id"),
						Action: "Delete"
					}, (e) => {
						if(e !== null && e !== void 0) {
							let response = JSON.parse(e)[0];

							$(`tr[deck-id=${response.DeckID}]`).remove();
						}
					});
				}
			}
		});
	});
</script>