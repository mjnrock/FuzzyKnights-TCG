<?php
	$AllowEdit = isset($AllowEdit) ? $AllowEdit : TRUE;
?>

<?php if($AllowEdit): ?>
	<div class="flex mt3">
		<div class="w-100 waves-effect waves-dark btn btn-large green lighten-1 br0 white-text" action="Add">Create Deck</div>
	</div>
	<br />
<?php endif; ?>

<table class="table centered table-deck">
	<thead>
		<th>ID</th>
		<th>Name</th>
		<th>Description</th>

		<th>Unique</th>
		<th>Total</th>

		<?php if($AllowEdit): ?>
			<th>Actions</th>
		<?php endif; ?>
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
				<?php if($AllowEdit): ?>
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
				<?php endif; ?>
			</tr>
		<?php endforeach; ?>
	</tbody>
	<tfoot>
		<tr class="tablesorter-ignoreRow">
			
			<th colspan="<?= $AllowEdit ? 6 : 5; ?>" class="ts-pager form-horizontal">
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
	});
</script>