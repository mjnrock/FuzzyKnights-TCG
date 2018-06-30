<?php
	require_once "{$_SERVER["DOCUMENT_ROOT"]}/models/Card.php";
	
	$Card = new Card($Card);
?>
<div class="row ba b--black-20 br2 shadow-5">
	<ul tcg="card-id" card-id="<?= $Card->ID; ?>">
		<li>
			<h4 tcg="card-name" class="tc"><?= $Card->Name; ?></h4>
		</li>
		<li>
			<img tcg="card-picture" src="<?= $Card->Picture; ?>" alt="">
		</li>
		<li>
			<h6 tcg="card-name" class="tc">Categories</h6>
			<table>
				<thead>
					<th>Task</th>
					<th>Type</th>
					<th>Discpline</th>
					<th>Requirement</th>
				</thead>
				<tbody>
					<td tcg="card-category-task" task-id="<?= $Card->Categories->Task["ID"]; ?>">
						<a class="dropdown-trigger btn deep-purple lighten-1" href="#" data-target="ul-tasks"><?= "{$Card->Categories->Task["Label"]} [{$Card->Categories->Task["Short"]}]"; ?></a>
						<ul id="ul-tasks" tcg="Task" class="dropdown-content ul-category">
							<?php foreach($Tasks as $Task): ?>
								<li pkid="<?= $Task["TaskID"]; ?>"><?= "{$Task["Label"]} [{$Task["Short"]}]"; ?></li>
							<?php endforeach; ?>
						</ul>					
					</td>

					<td tcg="card-category-cardtype" task-id="<?= $Card->Categories->CardType["ID"]; ?>">
						<a class="dropdown-trigger btn deep-purple lighten-1" href="#" data-target="ul-cardtypes"><?= "{$Card->Categories->CardType["Label"]} [{$Card->Categories->CardType["Short"]}]"; ?></a>
						<ul id="ul-cardtypes" tcg="CardType" class="dropdown-content ul-category">
							<?php foreach($CardTypes as $CardType): ?>
								<li pkid="<?= $CardType["CardTypeID"]; ?>"><?= "{$CardType["Label"]} [{$CardType["Short"]}]"; ?></li>
							<?php endforeach; ?>
						</ul>					
					</td>

					<td tcg="card-category-discipline" task-id="<?= $Card->Categories->Discipline["ID"]; ?>">
						<a class="dropdown-trigger btn deep-purple lighten-1" href="#" data-target="ul-disciplines"><?= "{$Card->Categories->Discipline["Label"]} [{$Card->Categories->Discipline["Short"]}]"; ?></a>
						<ul id="ul-disciplines" tcg="Discipline" class="dropdown-content ul-category">
							<?php foreach($Disciplines as $Discipline): ?>
								<li pkid="<?= $Discipline["DisciplineID"]; ?>"><?= "{$Discipline["Label"]} [{$Discipline["Short"]}]"; ?></li>
							<?php endforeach; ?>
						</ul>					
					</td>

					<td tcg="card-category-requirement" task-id="<?= $Card->Categories->RequirementCardType["ID"]; ?>">
						<a class="dropdown-trigger btn deep-purple lighten-1" href="#" data-target="ul-requirements"><?= isset($Card->Categories->RequirementCardType["ID"]) ? "{$Card->Categories->RequirementCardType["Label"]} [{$Card->Categories->RequirementCardType["Short"]}]" : "-"; ?></a>
						<ul id="ul-requirements" tcg="Requirement" class="dropdown-content ul-category">
							<?php foreach($Requirements as $Requirement): ?>
								<li pkid="<?= $Requirement["CardTypeID"]; ?>"><?= "{$Requirement["Label"]} [{$Requirement["Short"]}]"; ?></li>
							<?php endforeach; ?>
						</ul>
					</td>
				</tbody>
			</table>
		</li>
		<li>
			<h6 tcg="card-name" class="tc">Stats</h6>
			<table tcg="card-stats">
				<thead>
					<th>STR</th>
					<th>TGH</th>
					<th>PWR</th>
					<th>RES</th>
					<th>HP</th>
					<th>MP</th>
					<th>DUR</th>
				</thead>
				<tbody>
					<tr>
						<td tcg="card-stat" code="STR">
							<input type="number" value="<?= $Card->Stats->Strength; ?>" />
						</td>
						<td tcg="card-stat" code="TGH">
							<input type="number" value="<?= $Card->Stats->Toughness; ?>" />
						</td>
						<td tcg="card-stat" code="PWR">
							<input type="number" value="<?= $Card->Stats->Power; ?>" />
						</td>
						<td tcg="card-stat" code="RES">
							<input type="number" value="<?= $Card->Stats->Resistance; ?>" />
						</td>
						<td tcg="card-stat" code="HP">
							<input type="number" value="<?= $Card->Stats->Health; ?>" />
						</td>
						<td tcg="card-stat" code="MP">
							<input type="number" value="<?= $Card->Stats->Mana; ?>" />
						</td>
						<td tcg="card-stat" code="DUR">
							<input type="number" value="<?= $Card->Stats->Durability; ?>" />
						</td>
					</tr>
				</tbody>
			</table>
		</li>
		<li>
			<h6 tcg="card-name" class="tc">Modifiers</h6>
			<ul class="collection ml3 mr3 br2 shadow-3">
				<?php foreach($Card->Modifiers as $i => $Modifier): ?>
					<li class="collection-item">
						<div class="row" tcg="card-modifier-stat" statid="<?= $Modifier["Stat"]["ID"]; ?>">
							<div class="col s6">
								<div>
									<i class="material-icons">insert_chart</i>
									<span><?= "{$Modifier["Stat"]["Label"]} [{$Modifier["Stat"]["Short"]}]"; ?></span>
								</div>
							</div>
							<div class="col s6">
								<div>
									<i class="material-icons">call_split</i>
									<span><?= "{$Modifier["Stat"]["Action"]["Label"]} [{$Modifier["Stat"]["Action"]["Short"]}]"; ?></span>
								</div>
							</div>
						</div>
							
						<div class="row black-text <?= $Modifier["Target"]["IsFriendly"] ? "green lighten-3" : "red lighten-3"; ?>" tcg="card-modifier-target" statid="<?= $Modifier["Target"]["ID"]; ?>">
							<div class="col s6">
								<div>
									<i class="material-icons">location_on</i>
									<span><?= "{$Modifier["Target"]["X"]}, {$Modifier["Target"]["Y"]}"; ?></span>
								</div>
							</div>
							<div class="col s6">
								<div>
									<i class="material-icons">perm_identity</i>
									<span><?= "{$Modifier["Target"]["Label"]} [{$Modifier["Target"]["Short"]}]"; ?></span>
								</div>
							</div>
						</div>
						
						<div class="row" tcg="card-modifier-values" statid="<?= $Modifier["Values"]["ID"]; ?>">
							<div class="col s4">
								<div>
									<i class="material-icons">update</i>
									<span><?= $Modifier["Values"]["Lifespan"] === -1 ? "<i class='material-icons'>all_inclusive</i>" : $Modifier["Values"]["Lifespan"]; ?></span>
								</div>
							</div>
							<div class="col s4">
								<div>
									<i class="material-icons">exposure</i>
									<span><?= $Modifier["Values"]["Number"] === 0 ? ($Modifier["Values"]["Bonus"] >= 0 ? "+{$Modifier["Values"]["Bonus"]}" : "{$Modifier["Values"]["Bonus"]}") : "{$Modifier["Values"]["Number"]}d{$Modifier["Values"]["Sided"]}+{$Modifier["Values"]["Bonus"]}"; ?></span>
								</div>
							</div>
							<div class="col s4">
								<div>
									<i class="material-icons">format_list_numbered</i>
									<span><?= "{$Modifier["Values"]["Stage"]}.{$Modifier["Values"]["Step"]}"; ?></span>
								</div>
							</div>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		</li>
	</ul>
</div>

<script>
	$(document).ready(function() {
  		$(".dropdown-trigger").dropdown();

		$(".ul-category > li").on("click", function(e) {
			console.log([$(this).parent().attr("tcg"), $(this).attr("pkid")]);
		});
		$("td[tcg=card-stat] > input[type=number]").on("change", function(e) {
			console.log([$(this).val(), $(this).parent().attr("code")]);
		});
	});
</script>