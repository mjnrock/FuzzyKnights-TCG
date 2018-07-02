<?php
	require_once "{$_SERVER["DOCUMENT_ROOT"]}/models/Deck/Deck.php";
	
	$Deck = new \Deck\Deck($Deck);
?>

<script>	
	function AjaxFade(animate, e, isSuccess = false) {
		animate.fadeIn(200, "linear", () => {
			animate.addClass(`${!!isSuccess ? "green" : "red"} lighten-4`);
		}).fadeOut(300, "linear", () => {
			animate.removeClass(`${!!isSuccess ? "green" : "red"} lighten-4`);
		}).fadeIn(50);
	}
</script>

<div class="row ba b--black-20 br2 shadow-5">
	<ul tcg="deck-id" deck-id="<?= $Deck->ID; ?>">
		<li>
			<div tcg="deck-name" class="tc">
				<input class="h4" type="text" value="<?= $Deck->Name; ?>" placeholder="Deck Name" />
			</div>
		</li>
		<li>
			<div tcg="deck-description" class="tc">
				<textarea class="br2" rows="6" maxlength="255" placeholder="Deck Description"><?= $Deck->Description; ?></textarea>
			</div>
		</li>

		<li>
			<div class="flex">
				<div class="card w-50 ml2 mr1">
					<div class="card-title tc pa1">
						Unique
					</div>
					<div class="card-action tc">
						<?= $Deck->UniqueCardCount; ?>
					</div>
				</div>

				<div class="card w-50 ml1 mr2">
					<div class="card-title tc pa1">
						Total
					</div>
					<div class="card-action tc">
						<?= $Deck->TotalCardCount; ?>
					</div>
				</div>
			</div>
		</li>
	</ul>
</div>

<script>
	$(document).ready(function() {
  		$(".dropdown-trigger").dropdown();		

		$("[tcg=deck-name] > input[type=text]").on("change", function(e) {
			AJAX("UpdateName", {
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
	});
</script>