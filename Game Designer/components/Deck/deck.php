<?php
	require_once "{$_SERVER["DOCUMENT_ROOT"]}/models/Card/Card.php";
	require_once "{$_SERVER["DOCUMENT_ROOT"]}/models/Deck/Deck.php";
	
	if($Deck instanceof \Deck\Deck) {
		//	NOOP
	} else {
		$Deck = new \Deck\Deck($Deck);
	}
?>

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
					<div class="card-action tc" tcg="UniqueCardCount">
						<?= $Deck->UniqueCardCount; ?>
					</div>
				</div>

				<div class="card w-50 ml1 mr2">
					<div class="card-title tc pa1">
						Total
					</div>
					<div class="card-action tc" tcg="TotalCardCount">
						<?= $Deck->TotalCardCount; ?>
					</div>
				</div>
			</div>
		</li>

		<li>
			<?php
				$Cards = \API::$DB->TVF("GetDeckCards", [$Deck->ID], NULL, "TCG");
				$Cards = \Card\Card::InstantiateCards($Cards);
				$AllCards = \Card\Card::InstantiateCards();

				$AllowEdit = FALSE;
				require "{$_SERVER["DOCUMENT_ROOT"]}/components/Card/DeckTable.php";
			?>
		</li>
	</ul>
</div>