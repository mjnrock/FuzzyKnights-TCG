<?php
	if(isset($_GET["CardID"])) {
		require_once "{$_SERVER["DOCUMENT_ROOT"]}/libs/index.php";
		require_once "{$_SERVER["DOCUMENT_ROOT"]}/models/Card/Card.php";
		
		$Card = API::query("SELECT * FROM TCG.GetCard({$_GET["CardID"]}) WHERE ModifierIsActive = 1");
		$Card = new \Card\Card($Card);
	}

	if(!function_exists("ModCell")) {
		function ModCell($X, $Y, $Mod, $ColorLookup) {
			if($Mod["Target"]["X"] === $X && $Mod["Target"]["Y"] === $Y) {
				$Range = [
					"Min" => $Mod["Values"]["Number"] + $Mod["Values"]["Bonus"],
					"Max" => $Mod["Values"]["Number"] * $Mod["Values"]["Sided"] + $Mod["Values"]["Bonus"],
				];
				$Range["Display"] = $Range["Min"] === $Range["Max"] ? "<strong>[{$Range["Max"]}]</strong>" : "[{$Range['Min']}-{$Range['Max']}]";

				echo "<div class='flex w-100 pt1 pb1 code f6 black-text'>
					<div class='w-25 b {$ColorLookup["StatAction"]["Foreground"][$Mod["Stat"]["Action"]["Short"]]}'>" . substr($Mod['Stat']['Action']['Label'], 0, 4) . "</div>
					<div class='w-25 b {$ColorLookup["Stat"][$Mod["Stat"]["Short"]]}'>{$Mod['Stat']['Short']}</div>
					<div class='w-40'>{$Range["Display"]}</div>
					<div class='w-20'>" . ($Mod['Values']['Lifespan'] === -1 ? '&#x221e;' : $Mod['Values']['Lifespan']) . "</div>
				</div>";
			}
		}
	}
?>

<div class="mods">
	<div class="mods-row">
		<div class="mods-cell ba br2 bw1 red-text text-lighten-3">
			<?php foreach($Card->Modifiers as $Mod): ?>
				<?php ModCell(-2, 1, $Mod, $Card->ColorLookup); ?>
			<?php endforeach; ?>
		</div>
		<div class="mods-cell ba br2 bw1 red-text text-lighten-3">
			<?php foreach($Card->Modifiers as $Mod): ?>
				<?php ModCell(-1, 1, $Mod, $Card->ColorLookup); ?>
			<?php endforeach; ?>
		</div>
		<div class="mods-cell ba br2 bw1 red-text text-lighten-3">
			<?php foreach($Card->Modifiers as $Mod): ?>
				<?php ModCell(0, 1, $Mod, $Card->ColorLookup); ?>
			<?php endforeach; ?>
		</div>
		<div class="mods-cell ba br2 bw1 red-text text-lighten-3">
			<?php foreach($Card->Modifiers as $Mod): ?>
				<?php ModCell(1, 1, $Mod, $Card->ColorLookup); ?>
			<?php endforeach; ?>
		</div>
		<div class="mods-cell ba br2 bw1 red-text text-lighten-3">
			<?php foreach($Card->Modifiers as $Mod): ?>
				<?php ModCell(2, 1, $Mod, $Card->ColorLookup); ?>
			<?php endforeach; ?>
		</div>
	</div>
	<div class="mods-row">
		<div class="mods-cell ba br2 bw1 green-text text-lighten-2">
			<?php foreach($Card->Modifiers as $Mod): ?>
				<?php ModCell(-2, 0, $Mod, $Card->ColorLookup); ?>
			<?php endforeach; ?>
		</div>
		<div class="mods-cell ba br2 bw1 green-text text-lighten-2">
			<?php foreach($Card->Modifiers as $Mod): ?>
				<?php ModCell(-1, 0, $Mod, $Card->ColorLookup); ?>
			<?php endforeach; ?>
		</div>
		<div class="mods-cell ba br2 bw2 green-text text-lighten-1">
			<?php foreach($Card->Modifiers as $Mod): ?>
				<?php ModCell(0, 0, $Mod, $Card->ColorLookup); ?>
			<?php endforeach; ?>
		</div>
		<div class="mods-cell ba br2 bw1 green-text text-lighten-2">
			<?php foreach($Card->Modifiers as $Mod): ?>
				<?php ModCell(1, 0, $Mod, $Card->ColorLookup); ?>
			<?php endforeach; ?>
		</div>
		<div class="mods-cell ba br2 bw1 green-text text-lighten-2">
			<?php foreach($Card->Modifiers as $Mod): ?>
				<?php ModCell(2, 0, $Mod, $Card->ColorLookup); ?>
			<?php endforeach; ?>
		</div>
	</div>
</div>