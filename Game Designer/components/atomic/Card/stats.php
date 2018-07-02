<h6 tcg="card-name" class="tc">Stats</h6>
<table tcg="card-stats">
	<thead>
		<th class="<?= $Card->ColorLookup["Stat"]["STR"]; ?>">STR</th>
		<th class="<?= $Card->ColorLookup["Stat"]["TGH"]; ?>">TGH</th>
		<th class="<?= $Card->ColorLookup["Stat"]["PWR"]; ?>">PWR</th>
		<th class="<?= $Card->ColorLookup["Stat"]["RES"]; ?>">RES</th>
		<th class="<?= $Card->ColorLookup["Stat"]["HP"]; ?>">HP</th>
		<th class="<?= $Card->ColorLookup["Stat"]["MP"]; ?>">MP</th>
		<th class="<?= $Card->ColorLookup["Stat"]["DUR"]; ?>">DUR</th>
	</thead>
	<tbody>
		<tr>
			<td tcg="card-stat" code="STR">
				<input class="<?= $Card->ColorLookup["Stat"]["STR"]; ?>" type="number" value="<?= $Card->Stats->Strength; ?>" />
			</td>
			<td tcg="card-stat" code="TGH">
				<input class="<?= $Card->ColorLookup["Stat"]["TGH"]; ?>" type="number" value="<?= $Card->Stats->Toughness; ?>" />
			</td>
			<td tcg="card-stat" code="PWR">
				<input class="<?= $Card->ColorLookup["Stat"]["PWR"]; ?>" type="number" value="<?= $Card->Stats->Power; ?>" />
			</td>
			<td tcg="card-stat" code="RES">
				<input class="<?= $Card->ColorLookup["Stat"]["RES"]; ?>" type="number" value="<?= $Card->Stats->Resistance; ?>" />
			</td>
			<td tcg="card-stat" code="HP">
				<input class="<?= $Card->ColorLookup["Stat"]["HP"]; ?>" type="number" value="<?= $Card->Stats->Health; ?>" />
			</td>
			<td tcg="card-stat" code="MP">
				<input class="<?= $Card->ColorLookup["Stat"]["MP"]; ?>" type="number" value="<?= $Card->Stats->Mana; ?>" />
			</td>
			<td tcg="card-stat" code="DUR">
				<input class="<?= $Card->ColorLookup["Stat"]["DUR"]; ?>" type="number" value="<?= $Card->Stats->Durability; ?>" />
			</td>
		</tr>
	</tbody>
</table>

<script>
	$(document).ready(function() {
		$("[tcg=card-stat] > input[type=number]").on("blur", function(e) {
			AJAX("Card", "UpdateStat", {
				CardID: $("ul[tcg=card-id]").attr("card-id"),
				Key: $(this).parent().attr("code"),
				Value: $(this).val()
			}, (e) => {
				if(e !== null && e !== void 0) {
					let response = JSON.parse(e)[0];
					$(this).val(+response.Value);

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