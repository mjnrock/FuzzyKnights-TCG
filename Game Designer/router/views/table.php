<?php	
	$temps = API::vwCardStatModifier(NULL, NULL, NULL, "Name, Stage, Step");
	$Cards = [];
	foreach($temps as $temp) {
		if(!isset($Cards[$temp["Name"]])) {
			$Cards[$temp["Name"]] = [];
		}
		$Cards[$temp["Name"]][] =  $temp;
	}
	foreach($Cards as $i => $Card) {
		$Cards[$i] = new Card($Card);
	}
?>

<div class="flex mr2 ml2 mt3">
	<div class="w-100 waves-effect waves-dark btn green b ba green-text text-darken-4" action="Add"><i class="material-icons">add</i></div>
</div>

<pre>
	<?php //print_r($Card); ?>
</pre>

<table class="table centered">
	<thead>
		<th>ID</th>
		<th>Name</th>

		<th>Type</th>
		<th>Discipline</th>

		<th>Task</th>
		<th>Requirement</th>

		<th>STR</th>
		<th>TGH</th>
		<th>PWR</th>
		<th>RES</th>
		<th>HP</th>
		<th>MP</th>
		<th>DUR</th>

		<th>Actions</th>
	</thead>
	<tbody>
		<?php foreach($Cards as $key => $Card): ?>
			<tr class="pointer" card-id="<?= $Card->ID; ?>">
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

				<td class="table-actions">
					<div class="flex">
						<div class="btn mr1 white ba cyan-text text-darken-4 cyan lighten-3" action="Edit">
							<i class="material-icons">edit</i>
						</div>
						<div class="btn mr1 white ba <?= $Card->IsActive === 1 ? "green lighten-3 green-text text-darken-2" : "grey lighten-3 grey-text text-darken-2"; ?>" action="DeActivate">
							<i class="material-icons"><?= $Card->IsActive === 1 ? "visibility_on" : "visibility_off"; ?></i>
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
	// let table = $("table").DataTable({
	// 	pageLength: 100
	// });
	
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
			window.location.href = `/card/${$(this).attr("card-id")}`;
		});

		$("div[action]").on("click", function() {
			if($(this).attr("action") === "Add") {
				AJAX("CardUpdateState", {
					Action: "Add"
				}, (e) => {
					if(e !== null && e !== void 0) {
						let response = JSON.parse(e)[0];
						
						location.href = `/card/${response.CardID}`;
					}
				});
			} else if($(this).attr("action") === "Edit") {
				location.href = `/card/${$(this).parents("tr[card-id]").attr("card-id")}`;
			} else if($(this).attr("action") === "DeActivate") {
				AJAX("CardUpdateState", {
					CardID: $(this).parents("tr[card-id]").attr("card-id"),
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
					AJAX("CardUpdateState", {
						CardID: $(this).parents("tr[card-id]").attr("card-id"),
						Action: "Delete"
					}, (e) => {
						if(e !== null && e !== void 0) {
							let response = JSON.parse(e)[0];

							$(`tr[card-id=${response.CardID}]`).remove();
						}
					});
				}
			}
		});
	});
</script>