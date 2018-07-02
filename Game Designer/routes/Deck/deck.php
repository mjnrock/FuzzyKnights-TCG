<a href="/deck/table" class="btn btn-large w-100 light-blue darken-2 white-text mb3">View All Decks</a>

<script>
	function AjaxFade(animate, e, isSuccess = false) {
		animate.fadeIn(200, "linear", () => {
			animate.addClass(`${!!isSuccess ? "green" : "red"} lighten-4`);
		}).fadeOut(300, "linear", () => {
			animate.removeClass(`${!!isSuccess ? "green" : "red"} lighten-4`);
		}).fadeIn(50);
	}

	$(document).ready(function() {
  		$(".dropdown-trigger").dropdown();		

		$("[tcg=deck-name] > input[type=text]").on("change", function(e) {
			AJAX("Deck", "UpdateName", {
				DeckID: $("ul[tcg=deck-id]").attr("deck-id"),
				Name: $(this).val()
			}, (e) => {
				if(e !== null && e !== void 0) {
					AjaxFade(
						$(this),
						e,
						true
					);
				} else {
					AjaxFade(
						$(this),
						e,
						false
					);
				}
			});
		});
		$("[tcg=deck-description] > textarea").on("change", function(e) {
			AJAX("Deck", "UpdateDescription", {
				DeckID: $("ul[tcg=deck-id]").attr("deck-id"),
				Description: $(this).val()
			}, (e) => {
				if(e !== null && e !== void 0) {
					AjaxFade(
						$(this),
						e,
						true
					);
				} else {
					AjaxFade(
						$(this),
						e,
						false
					);
				}
			});
		});
		
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

<?php
	require_once "{$_SERVER["DOCUMENT_ROOT"]}/components/Deck/deck.php";
?>