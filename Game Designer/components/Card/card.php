<?php
	require_once "{$_SERVER["DOCUMENT_ROOT"]}/models/Card/Card.php";
	
	if($Card instanceof \Card\Card) {

	} else {
		$Card = new \Card\Card($Card);
	}
?>

<div class="container">
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
				<?php include "{$_SERVER["DOCUMENT_ROOT"]}/components/Card/categories.php"; ?>
			</li>
			<li>
				<?php include "{$_SERVER["DOCUMENT_ROOT"]}/components/Card/stats.php"; ?>
			</li>
			<li>
				<?php include "{$_SERVER["DOCUMENT_ROOT"]}/components/Card/modifiers.php"; ?>
			</li>
		</ul>
	</div>
</div>