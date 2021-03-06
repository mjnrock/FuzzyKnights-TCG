<?php
	$AllowEdit = isset($AllowEdit) ? $AllowEdit : TRUE;
	$ShowAnomalyMessage = isset($ShowAnomalyMessage) ? $ShowAnomalyMessage : FALSE;
?>

<?php if($AllowEdit): ?>
	<div class="flex mt3">
		<div class="w-100 waves-effect waves-dark btn btn-large green lighten-1 br0 white-text" action="Add">Create Card</div>
	</div>
	<br />
<?php endif; ?>

<table class="table centered table-card">
	<thead>
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

		<?php if($ShowAnomalyMessage): ?>
			<th>Messages</th>
		<?php endif; ?>

		<?php if($AllowEdit): ?>
			<th>Actions</th>
		<?php endif; ?>
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
				
				<td class="<?= \Card\Card::$ColorLookup["Stat"]["STR"]; ?>"><?= $Card->Stats->Strength; ?></td>
				<td class="<?= \Card\Card::$ColorLookup["Stat"]["TGH"]; ?>"><?= $Card->Stats->Toughness; ?></td>
				<td class="<?= \Card\Card::$ColorLookup["Stat"]["PWR"]; ?>"><?= $Card->Stats->Power; ?></td>
				<td class="<?= \Card\Card::$ColorLookup["Stat"]["RES"]; ?>"><?= $Card->Stats->Resistance; ?></td>
				<td class="<?= \Card\Card::$ColorLookup["Stat"]["HP"]; ?>"><?= $Card->Stats->Health; ?></td>
				<td class="<?= \Card\Card::$ColorLookup["Stat"]["MP"]; ?>"><?= $Card->Stats->Mana; ?></td>
				<td class="<?= \Card\Card::$ColorLookup["Stat"]["DUR"]; ?>"><?= $Card->Stats->Durability; ?></td>
				

				<?php if($ShowAnomalyMessage): ?>
					<td>
						<ol>
							<?php foreach($Card->AnomalyMessages as $Message): ?>
								<li><?= $Message; ?></li>
							<?php endforeach; ?>
						</ol>
					</td>
				<?php endif; ?>

				<?php if($AllowEdit): ?>
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
				<?php endif; ?>
			</tr>
		<?php endforeach; ?>
	</tbody>
	<tfoot>
		<tr class="tablesorter-ignoreRow">
			<?php
				$rows = 13;
				$rows += $AllowEdit ? 1 : 0;
				$rows += $ShowAnomalyMessage ? 1 : 0;
			?>
			<th colspan="<?= $rows; ?>" class="ts-pager form-horizontal">
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
      		filter_cssFilter: ["", "", "browser-default", "browser-default", "browser-default", "browser-default"]
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
</script>