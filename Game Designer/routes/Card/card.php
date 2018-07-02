<a href="/card/table" class="btn btn-large w-100 light-blue darken-2 white-text mb3">View All Cards</a>

<?php
	$Tasks = API::Task(NULL, NULL, NULL, "Label");
	$CardTypes = API::CardType(NULL, NULL, NULL, "Label");
	$Disciplines = API::Discipline(NULL, NULL, NULL, "Label");
	$Requirements = API::CardType(NULL, NULL, NULL, "Label");

	$Targets = API::Target(NULL, NULL, NULL, "Y, X");	
	$Stats = API::Stat(NULL, NULL, NULL, "Label");
	$StatActions = API::StatAction(NULL, NULL, NULL, "Label");

	require_once "{$_SERVER["DOCUMENT_ROOT"]}/components/Card/card.php";
?>

<script>
	const ColorLookup = <?= json_encode($Card->ColorLookup); ?>;
	
	function AjaxFade(animate, e, isSuccess = false) {
		animate.fadeIn(200, "linear", () => {
			animate.addClass(`${!!isSuccess ? "green" : "red"} lighten-4`);
		}).fadeOut(300, "linear", () => {
			animate.removeClass(`${!!isSuccess ? "green" : "red"} lighten-4`);
		}).fadeIn(50);
	}

	function LoadCells() {
		$(".cell-injection").empty();
		$(".cell-injection").load("/components/Card/ModifiersCells.php?CardID=<?= $Card->ID; ?>");
	}

	$(document).ready(function() {
  		$(".dropdown-trigger").dropdown();		

		$("[tcg=card-name] > input[type=text]").on("change", function(e) {
			AJAX("UpdateName", {
				CardID: $("ul[tcg=card-id]").attr("card-id"),
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
		
		$(".ul-category > li").on("click", function(e) {
			AJAX("Card", "UpdateTask", {
				CardID: $("ul[tcg=card-id]").attr("card-id"),
				Table: $(this).parent().attr("tcg"),
				Column: $(this).parent().attr("tcg-c"),
				PKID: $(this).attr("pkid")
			}, (e) => {
				if(e !== null && e !== void 0) {
					let response = JSON.parse(e);

					let a = response.Lookup.filter(r => r[`${response.Result[0].Table}ID`] === response.Result[0].PKID);
					
					if(response.Result[0].Table === "Task" || response.Result[0].Table === "Discipline") {
						$(`a[tcg-c=${response.Result[0].Column}]`)
							.attr("class", `dropdown-trigger btn ba white ${ColorLookup[response.Result[0].Table][a[0].Short]}`);
					}

					if(response.Result[0].PKID === null) {
						$(`a[tcg-c=${response.Result[0].Column}]`).text(`-`);
					} else {
						$(`a[tcg-c=${response.Result[0].Column}]`).text(`${a[0].Label} [${a[0].Short}]`);
					}

					AjaxFade(
						$(`th[tcg-c=${response.Result[0].Column}]`),
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

		$("a[action]").on("click", function(e) {
			if($(this).attr("action") === "Add") {
				AJAX("Card", "UpdateModifierState", {
					CardID: <?= $Card->ID; ?>,
					Action: "Add"
				}, (e) => {
					location.reload();
				});
			} else if($(this).attr("action") === "DeActivate") {
				AJAX("Card", "UpdateModifierState", {
					CardStatModifierID: $(this).parents("li[csm-id]").attr("csm-id"),
					Action: "DeActivate"
				}, (e) => {
					if(e !== null && e !== void 0) {
						let response = JSON.parse(e)[0],
							text = null,
							css = null;

						if(+response.ModifierIsActive === 1) {
							text = "<i class='material-icons'>visibility_on</i>";
							css = "green lighten-3 green-text text-darken-2";
						} else {
							text = "<i class='material-icons'>visibility_off</i>";
							css = "grey lighten-3 grey-text text-darken-2";
						}
						$(`li[csm-id=${+response.CardStatModifierID}] a[action=DeActivate]`)
							.html(text)
							.attr("class", `w-80 waves-effect waves-dark btn b ba ${css}`);

						LoadCells();
					}
				});
			} else if($(this).attr("action") === "Delete") {
				if(confirm("Are you sure?")) {
					AJAX("Card", "UpdateModifierState", {
						CardStatModifierID: $(this).parents("li[csm-id]").attr("csm-id"),
						Action: "Delete"
					}, (e) => {
						location.reload();
					});
				}
			}
		});

		$(".ul-modifier > li").on("click", function(e) {
			AJAX("Card", "UpdateModifier", {
				CardStatModifierID: $(this).parent().attr("csm-id"),
				Table: $(this).parent().attr("tcg"),
				PKID: $(this).attr("pkid")
			}, (e) => {
				if(e !== null && e !== void 0) {
					let response = JSON.parse(e);
					
					let a = response.Lookup.filter(r => r[`${response.Result[0].Table}ID`] === response.Result[0].PKID);
					$(`a[tcg=${response.Result[0].Table}][csm-id=${response.Result[0].CardStatModifierID}]`)
						.text(`${a[0].Label} [${a[0].Short}]`)
						.attr("class", `dropdown-trigger btn ba white ${ColorLookup[response.Result[0].Table][a[0].Short]}`);
					if(response.Result[0].Table === "StatAction") {
						$(`a[tcg=${response.Result[0].Table}][csm-id=${response.Result[0].CardStatModifierID}]`)
							.attr("class", `dropdown-trigger btn ba white ${ColorLookup["StatAction"]["Foreground"][a[0].Short]}`);
					}
					if(response.Result[0].Table === "Target") {
						$(`a[tcg=${response.Result[0].Table}][csm-id=${response.Result[0].CardStatModifierID}]`)
							.attr("class", `dropdown-trigger btn ba white ${ColorLookup["Target"][+a[0].IsFriendly === 1 ? "Friendly" : "Enemy"]}`);

						$(`div[tcg=${response.Result[0].Table}][csm-id=${response.Result[0].CardStatModifierID}] > [tcg=X]`).val(a[0].X);
						$(`div[tcg=${response.Result[0].Table}][csm-id=${response.Result[0].CardStatModifierID}] > [tcg=Y]`).val(a[0].Y);
					}

					AjaxFade(
						$(`a[tcg=${response.Result[0].Table}][csm-id=${response.Result[0].CardStatModifierID}]`).parent(),
						e,
						true
					);
					
					LoadCells();
				} else {
					AjaxFade(
						$(this),
						e,
						false
					);
				}
			});
		});

		$("[tcg=card-modifier-values] input[type=number]").on("blur", function(e) {
			AJAX("Card", "UpdateModifier", {
				CardStatModifierID: $(this).parents("div.row[csm-id]").attr("csm-id"),
				Key: $(this).attr("tcg"),
				Value: $(this).val()
			}, (e) => {
				if(e !== null && e !== void 0) {
					let response = JSON.parse(e)[0];
					$(this).val(+response.Value);

					AjaxFade(
						$(this),
						e,
						true
					);
					
					LoadCells();
				} else {
					AjaxFade(
						$(this),
						e,
						false
					);
				}
			});
		});

		$("[tcg=card-stat] > input[type=number]").on("blur", function(e) {
			AJAX("Card", "UpdateStat", {
				CardID: $("ul[tcg=card-id]").attr("card-id"),
				Key: $(this).parent().attr("code"),
				Value: $(this).val()
			}, (e) => {
				if(e !== null && e !== void 0) {
					let response = JSON.parse(e)[0];
					$(this).val(+response.Value);

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
	});
</script>