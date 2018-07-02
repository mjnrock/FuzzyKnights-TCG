<?php
	require_once "{$_SERVER["DOCUMENT_ROOT"]}/models/Card/Card.php";
	
	$Card = new \Card\Card($Card);
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
</script>

<div class="row ba b--black-20 br2 shadow-5">
	<ul tcg="card-id" card-id="<?= $Card->ID; ?>">
		<li>
			<div tcg="card-name" class="tc">
				<input class="h4" type="text" value="<?= $Card->Name; ?>" />
			</div>
		</li>
		<li>
			<img tcg="card-picture" src="<?= $Card->Picture; ?>" alt="">
		</li>
		<li>
			<?php include "{$_SERVER["DOCUMENT_ROOT"]}/components/atomic/card/categories.php"; ?>
		</li>
		<li>
			<?php include "{$_SERVER["DOCUMENT_ROOT"]}/components/atomic/card/stats.php"; ?>
		</li>
		<li>
			<?php include "{$_SERVER["DOCUMENT_ROOT"]}/components/atomic/card/modifiers.php"; ?>
		</li>
	</ul>
</div>

<script>
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
	});
</script>