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

<table class="table highlight centered">
	<thead>
		<th>Name</th>

		<th>Type</th>
		<th>Discipline</th>

		<th>Task</th>
		<th>Requirement</th>
	</thead>
	<tbody>
		<?php foreach($Cards as $key => $Card): ?>
			<tr card-id="<?= $Card->ID; ?>">
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
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<script>
	$(document).ready(function() {
		let table = $("table").DataTable({
			pageLength: 100
		});

		$("tr").on("dblclick", function () {
			window.location.href = `/card/${$(this).attr("card-id")}`;
		});
	});
</script>