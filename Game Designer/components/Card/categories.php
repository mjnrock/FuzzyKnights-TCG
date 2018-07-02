<h6 tcg="card-name" class="tc">Categories</h6>
<table>
	<thead>
		<th tcg-c="Task">Task</th>
		<th tcg-c="CardType">Type</th>
		<th tcg-c="Discipline">Discpline</th>
		<th tcg-c="RequirementCardType">Requirement</th>
	</thead>
	<tbody>
		<td tcg="card-category-task" task-id="<?= $Card->Categories->Task["ID"]; ?>">
			<a tcg="Task" tcg-c="Task" pkid="<?= $Card->Categories->Task["ID"]; ?>" class="dropdown-trigger btn ba white <?= $Card->ColorLookup["Task"][$Card->Categories->Task["Short"]]; ?>" href="#" data-target="ul-tasks"><?= "{$Card->Categories->Task["Label"]} [{$Card->Categories->Task["Short"]}]"; ?></a>
			<ul id="ul-tasks" tcg="Task" tcg-c="Task" class="dropdown-content ul-category">
				<?php foreach($Tasks as $Task): ?>
					<li pkid="<?= $Task["TaskID"]; ?>"><?= "{$Task["Label"]} [{$Task["Short"]}]"; ?></li>
				<?php endforeach; ?>
			</ul>					
		</td>

		<td tcg="card-category-cardtype" task-id="<?= $Card->Categories->CardType["ID"]; ?>">
			<a tcg="CardType" tcg-c="CardType" pkid="<?= $Card->Categories->CardType["ID"]; ?>" class="dropdown-trigger btn deep-purple lighten-2" href="#" data-target="ul-cardtypes"><?= "{$Card->Categories->CardType["Label"]} [{$Card->Categories->CardType["Short"]}]"; ?></a>
			<ul id="ul-cardtypes" tcg="CardType" tcg-c="CardType" class="dropdown-content ul-category">
				<?php foreach($CardTypes as $CardType): ?>
					<li pkid="<?= $CardType["CardTypeID"]; ?>"><?= "{$CardType["Label"]} [{$CardType["Short"]}]"; ?></li>
				<?php endforeach; ?>
			</ul>					
		</td>

		<td tcg="card-category-discipline" task-id="<?= $Card->Categories->Discipline["ID"]; ?>">
			<a tcg="Discipline" tcg-c="Discipline" pkid="<?= $Card->Categories->Discipline["ID"]; ?>" class="dropdown-trigger btn ba white <?= $Card->ColorLookup["Discipline"][$Card->Categories->Discipline["Short"]]; ?>" href="#" data-target="ul-disciplines"><?= "{$Card->Categories->Discipline["Label"]} [{$Card->Categories->Discipline["Short"]}]"; ?></a>
			<ul id="ul-disciplines" tcg="Discipline" tcg-c="Discipline" class="dropdown-content ul-category">
				<?php foreach($Disciplines as $Discipline): ?>
					<li pkid="<?= $Discipline["DisciplineID"]; ?>"><?= "{$Discipline["Label"]} [{$Discipline["Short"]}]"; ?></li>
				<?php endforeach; ?>
			</ul>					
		</td>

		<td tcg="card-category-requirement" task-id="<?= $Card->Categories->RequirementCardType["ID"]; ?>">
			<a tcg="CardType" tcg-c="RequirementCardType" pkid="<?= $Card->Categories->RequirementCardType["ID"]; ?>" class="dropdown-trigger btn deep-purple lighten-2" href="#" data-target="ul-requirements"><?= isset($Card->Categories->RequirementCardType["ID"]) ? "{$Card->Categories->RequirementCardType["Label"]} [{$Card->Categories->RequirementCardType["Short"]}]" : "-"; ?></a>
			<ul id="ul-requirements" tcg="CardType" tcg-c="RequirementCardType" class="dropdown-content ul-category">
				<li pkid="NULL">-- NULL --</li>
				<li class="divider" tabindex="-1"></li>
				<?php foreach($Requirements as $Requirement): ?>
					<li pkid="<?= $Requirement["CardTypeID"]; ?>"><?= "{$Requirement["Label"]} [{$Requirement["Short"]}]"; ?></li>
				<?php endforeach; ?>
			</ul>
		</td>
	</tbody>
</table>

<script>
	$(document).ready(function() {
		$(".ul-category > li").on("click", function(e) {
			AJAX("Card", "UpdateTask", {
				CardID: $("ul[tcg=card-id]").attr("card-id"),
				Table: $(this).parent().attr("tcg"),
				Column: $(this).parent().attr("tcg-c"),
				PKID: $(this).attr("pkid")
			}, (e) => {
				if(e !== null && e !== void 0) {
					let response = JSON.parse(e);

					let a = response.Lookup.filter(r => r[`${response.Result[0].Table}ID`] === response.Result[0].PKID);
					
					if(response.Result[0].Table === "Task" || response.Result[0].Table === "Discipline") {
						$(`a[tcg-c=${response.Result[0].Column}]`)
							.attr("class", `dropdown-trigger btn ba white ${ColorLookup[response.Result[0].Table][a[0].Short]}`);
					}

					if(response.Result[0].PKID === null) {
						$(`a[tcg-c=${response.Result[0].Column}]`).text(`-`);
					} else {
						$(`a[tcg-c=${response.Result[0].Column}]`).text(`${a[0].Label} [${a[0].Short}]`);
					}

					AjaxFade(
						$(`th[tcg-c=${response.Result[0].Column}]`),
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