<div class="flex mr2 ml2 mt3">
	<div class="w-100 waves-effect waves-dark btn btn-large white b ba light-blue-text text-darken-4" action="ToggleCards"><i class="material-icons">center_focus_strong</i></div>
</div>
<br />

<table class="table centered table-deckcard">
	<thead>		
		<th>Qty</th>

		<th>ID</th>
		<th>Name</th>

		<th class="filter-select filter-exact">Type</th>
		<th class="filter-select filter-exact">Discipline</th>

		<th class="filter-select filter-exact">Task</th>
		<th class="filter-select filter-exact">Requirement</th>

		<th class="<?= \Card\Card::$ColorLookup["Stat"]["STR"]; ?>">STR</th>
		<th class="<?= \Card\Card::$ColorLookup["Stat"]["TGH"]; ?>">TGH</th>
		<th class="<?= \Card\Card::$ColorLookup["Stat"]["PWR"]; ?>">PWR</th>
		<th class="<?= \Card\Card::$ColorLookup["Stat"]["RES"]; ?>">RES</th>
		<th class="<?= \Card\Card::$ColorLookup["Stat"]["HP"]; ?>">HP</th>
		<th class="<?= \Card\Card::$ColorLookup["Stat"]["MP"]; ?>">MP</th>
		<th class="<?= \Card\Card::$ColorLookup["Stat"]["DUR"]; ?>">DUR</th>
	</thead>
	<tbody>
		<?php
			$a = array_keys($Cards);
			$b = array_keys($AllCards);
			$c = array_diff($b, $a);
			$d = $AllCards;

			foreach($AllCards as $k => $v) {
				if(!in_array($k, $c)) {
					unset($d[$k]);
				}
			}
			$AllCards = $d;
		?>
		<?php foreach($AllCards as $key => $Card): ?>
			<tr class="pointer" card-id="<?= $Card->ID; ?>">
				<td><input type="number" value="<?= isset($Card->Quantity) ? $Card->Quantity : 0; ?>" min="0" deck-id="<?= $Deck->ID; ?>" card-id="<?= $Card->ID; ?>" /></td>

				<td><?= $Card->ID; ?></td>
				<td><?= $Card->Name; ?></td>

				<td card-type-id="<?= $Card->Categories->CardType["ID"]; ?>">
					<?= $Card->Categories->CardType["Label"]; ?>
				</td>
				<td discipline-id="<?= $Card->Categories->Discipline["ID"]; ?>">
					<?= $Card->Categories->Discipline["Label"]; ?>
				</td>

				<td task-id="<?= $Card->Categories->Task["ID"]; ?>">
					<?= $Card->Categories->Task["Label"]; ?>
				</td>
				<td requirement-id="<?= $Card->Categories->RequirementCardType["ID"]; ?>">
					<?= $Card->Categories->RequirementCardType["Label"]; ?>
				</td>
								
				<td><?= $Card->Stats->Strength; ?></td>
				<td><?= $Card->Stats->Toughness; ?></td>
				<td><?= $Card->Stats->Power; ?></td>
				<td><?= $Card->Stats->Resistance; ?></td>
				<td><?= $Card->Stats->Health; ?></td>
				<td><?= $Card->Stats->Mana; ?></td>
				<td><?= $Card->Stats->Durability; ?></td>
			</tr>
		<?php endforeach; ?>

		<?php foreach($Cards as $key => $Card): ?>
			<tr class="pointer" card-id="<?= $Card->ID; ?>">
				<td><input type="number" value="<?= $Card->Quantity; ?>" min="0" deck-id="<?= $Deck->ID; ?>" card-id="<?= $Card->ID; ?>" /></td>

				<td><?= $Card->ID; ?></td>
				<td><?= $Card->Name; ?></td>

				<td card-type-id="<?= $Card->Categories->CardType["ID"]; ?>">
					<?= $Card->Categories->CardType["Label"]; ?>
				</td>
				<td discipline-id="<?= $Card->Categories->Discipline["ID"]; ?>">
					<?= $Card->Categories->Discipline["Label"]; ?>
				</td>

				<td task-id="<?= $Card->Categories->Task["ID"]; ?>">
					<?= $Card->Categories->Task["Label"]; ?>
				</td>
				<td requirement-id="<?= $Card->Categories->RequirementCardType["ID"]; ?>">
					<?= $Card->Categories->RequirementCardType["Label"]; ?>
				</td>
				
				<td class="<?= \Card\Card::$ColorLookup["Stat"]["STR"]; ?>"><?= $Card->Stats->Strength; ?></td>
				<td class="<?= \Card\Card::$ColorLookup["Stat"]["TGH"]; ?>"><?= $Card->Stats->Toughness; ?></td>
				<td class="<?= \Card\Card::$ColorLookup["Stat"]["PWR"]; ?>"><?= $Card->Stats->Power; ?></td>
				<td class="<?= \Card\Card::$ColorLookup["Stat"]["RES"]; ?>"><?= $Card->Stats->Resistance; ?></td>
				<td class="<?= \Card\Card::$ColorLookup["Stat"]["HP"]; ?>"><?= $Card->Stats->Health; ?></td>
				<td class="<?= \Card\Card::$ColorLookup["Stat"]["MP"]; ?>"><?= $Card->Stats->Mana; ?></td>
				<td class="<?= \Card\Card::$ColorLookup["Stat"]["DUR"]; ?>"><?= $Card->Stats->Durability; ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
	<tfoot>
		<tr class="tablesorter-ignoreRow">
			<th colspan="14" class="ts-pager form-horizontal">
				<button type="button" class="btn first deep-purple lighten-2"><i class="small material-icons">first_page</i></button>
				<button type="button" class="btn prev deep-purple lighten-2"><i class="small material-icons">navigate_before</i></button>
				<span class="pagedisplay"></span>
				<!-- this can be any element, including an input -->
				<button type="button" class="btn next deep-purple lighten-2"><i class="small material-icons">navigate_next</i></button>
				<button type="button" class="btn last deep-purple lighten-2"><i class="small material-icons">last_page</i></button>
				<select class="pagesize browser-default" title="Select page size">
					<option selected="selected" value="25">25</option>
					<option value="50">50</option>
					<option value="75">75</option>
					<option value="100">100</option>
				</select>
				<select class="pagenum browser-default" title="Select page number"></select>
			</th>
		</tr>
	</tfoot>
</table>
	
<script>	
	$("table").tablesorter({
		theme: "materialize",
		fixedWidth: true,
		widgets: ["filter"],
		widgetOptions : {
			filter_reset: ".reset",
			filter_cssFilter: ["", "", "", "browser-default", "browser-default", "browser-default", "browser-default"]
		}
	}).tablesorterPager({
		container: $(".ts-pager"),
		cssGoto  : ".pagenum",
		removeRows: false,
		size: 25,
		page: 0,
		pageReset: 0,
		output: '{startRow} - {endRow} / {filteredRows} ({totalRows})'
	});

	function HideRows(isToggle = true) {				
		let unique = 0,
			total = 0;

		$("input[type=number]").each(i => {
			let v = $($("input[type=number]")[i]),
				value = v.val();
				
			if(value <= 0) {
				if(isToggle) {
					v.closest("tr").removeClass("hide").toggle();
				} else {
					v.closest("tr").removeClass("hide").hide();
				}
			} else {
				unique++;
				total += +value;
			}
		});

		$("div[tcg=UniqueCardCount]").text(unique);
		$("div[tcg=TotalCardCount]").text(total);
	}

	$(document).ready(function() {
		$(".table-deckcard tbody td > input[type=number]").on("blur", function(e) {
			AJAX("Card", "UpdateQuantity", {
				DeckID: $(this).attr("deck-id"),
				CardID: $(this).attr("card-id"),
				Quantity: $(this).val()
			}, (e) => {
				if(e !== null && e !== void 0) {
					let response = JSON.parse(e)[0];
					$(this).val(+response.Quantity);

					// HideRows(false);

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
		
		$("div[action]").on("click", function() {
			if($(this).attr("action") === "ToggleCards") {
				HideRows();
			}
		});
	});
</script>