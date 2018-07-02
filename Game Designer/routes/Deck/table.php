<?php	
	$temps = API::vwDeck();
	$Decks = [];
	foreach($temps as $temp) {
		if(!isset($Decks[$temp["Name"]])) {
			$Decks[$temp["Name"]] = [];
		}
		$Decks[$temp["Name"]][] =  $temp;
	}
	foreach($Decks as $i => $Deck) {
		$Decks[$i] = new \Deck\Deck($Deck);
	}
?>

<div class="flex mr2 ml2 mt3">
	<div class="w-100 waves-effect waves-dark btn btn-large green b ba green-text text-darken-4" action="Add"><i class="material-icons">add</i></div>
</div>
<br />

<table class="table centered">
	<thead>
		<th>ID</th>
		<th>Name</th>
		<th>Description</th>

		<th>Unique</th>
		<th>Total</th>

		<th>Actions</th>
	</thead>
	<tbody>
		<?php foreach($Decks as $key => $Deck): ?>
			<tr class="pointer" deck-id="<?= $Deck->ID; ?>">
				<td>
					<?= $Deck->ID; ?>
				</td>
				<td>
					<?= $Deck->Name; ?>
				</td>
				<td>
					<?= $Deck->Description; ?>
				</td>
				
				<td>
					<?= $Deck->UniqueCardCount; ?>
				</td>
				<td>
					<?= $Deck->TotalCardCount; ?>
				</td>

				<td class="table-actions">
					<div class="flex">
						<div class="btn mr1 white ba cyan-text text-darken-4 cyan lighten-3" action="Edit">
							<i class="material-icons">edit</i>
						</div>
						<div class="btn mr1 white ba <?= $Deck->IsActive === 1 ? "green lighten-3 green-text text-darken-2" : "grey lighten-3 grey-text text-darken-2"; ?>" action="DeActivate">
							<i class="material-icons"><?= $Deck->IsActive === 1 ? "visibility_on" : "visibility_off"; ?></i>
						</div>
						<div class="btn white ba red-text text-darken-4 red lighten-3" action="Delete">
							<i class="material-icons">delete_forever</i>
						</div>
					</div>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
	<tfoot>
		<tr class="tablesorter-ignoreRow">
			<th colspan="6" class="ts-pager form-horizontal">
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
			filter_reset: ".reset"
		}
	}).tablesorterPager({
		container: $(".ts-pager"),
		cssGoto  : ".pagenum",
		removeRows: false,
		size: 25,
		page: 0,
		pageReset: 0,
		output: '{startRow} - {endRow} / {filteredRows} ({totalRows})'

	});;
		
	$(document).ready(function() {
		$("tbody > tr").on("dblclick", function () {
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