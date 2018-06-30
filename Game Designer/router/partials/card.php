<?php
	require_once "{$_SERVER["DOCUMENT_ROOT"]}/models/Card.php";
	
	$Card = new Card($Card);
?>
<div class="row ba b--black-20 br2 shadow-5">
	<ul tcg="card-id" card-id="<?= $Card->ID; ?>">
		<li>
			<div tcg="card-name" class="tc">
				<input class="h4" type="text" value="<?= $Card->Name; ?>" />
			</div>
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
							<li pkid="NULL">-- NULL --</li>
    						<li class="divider" tabindex="-1"></li>
							<?php foreach($Tasks as $Task): ?>
								<li pkid="<?= $Task["TaskID"]; ?>"><?= "{$Task["Label"]} [{$Task["Short"]}]"; ?></li>
							<?php endforeach; ?>
						</ul>					
					</td>

					<td tcg="card-category-cardtype" task-id="<?= $Card->Categories->CardType["ID"]; ?>">
						<a class="dropdown-trigger btn deep-purple lighten-1" href="#" data-target="ul-cardtypes"><?= "{$Card->Categories->CardType["Label"]} [{$Card->Categories->CardType["Short"]}]"; ?></a>
						<ul id="ul-cardtypes" tcg="CardType" class="dropdown-content ul-category">
							<li pkid="NULL">-- NULL --</li>
    						<li class="divider" tabindex="-1"></li>
							<?php foreach($CardTypes as $CardType): ?>
								<li pkid="<?= $CardType["CardTypeID"]; ?>"><?= "{$CardType["Label"]} [{$CardType["Short"]}]"; ?></li>
							<?php endforeach; ?>
						</ul>					
					</td>

					<td tcg="card-category-discipline" task-id="<?= $Card->Categories->Discipline["ID"]; ?>">
						<a class="dropdown-trigger btn deep-purple lighten-1" href="#" data-target="ul-disciplines"><?= "{$Card->Categories->Discipline["Label"]} [{$Card->Categories->Discipline["Short"]}]"; ?></a>
						<ul id="ul-disciplines" tcg="Discipline" class="dropdown-content ul-category">
							<li pkid="NULL">-- NULL --</li>
    						<li class="divider" tabindex="-1"></li>
							<?php foreach($Disciplines as $Discipline): ?>
								<li pkid="<?= $Discipline["DisciplineID"]; ?>"><?= "{$Discipline["Label"]} [{$Discipline["Short"]}]"; ?></li>
							<?php endforeach; ?>
						</ul>					
					</td>

					<td tcg="card-category-requirement" task-id="<?= $Card->Categories->RequirementCardType["ID"]; ?>">
						<a class="dropdown-trigger btn deep-purple lighten-1" href="#" data-target="ul-requirements"><?= isset($Card->Categories->RequirementCardType["ID"]) ? "{$Card->Categories->RequirementCardType["Label"]} [{$Card->Categories->RequirementCardType["Short"]}]" : "-"; ?></a>
						<ul id="ul-requirements" tcg="RequirementCardType" class="dropdown-content ul-category">
							<li pkid="NULL">-- NULL --</li>
    						<li class="divider" tabindex="-1"></li>
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

			<?php
				function ModCell($X, $Y, $Mod) {
					if($Mod["Target"]["X"] === $X && $Mod["Target"]["Y"] === $Y) {
						switch($Mod["Stat"]["Action"]["Short"]) {
							case "+":
								$Color = "green lighten-3 black-text";
								break;
							case "-":
								$Color = "red lighten-3 black-text";
								break;
							case "*":
								$Color = "cyan lighten-2 black-text";
								break;
							case "/":
								$Color = "pink lighten-2 black-text";
								break;
							case "Buff":
								$Color = "deep-purple lighten-2 black-text";
								break;
							case "Debuff":
								$Color = "indigo lighten-2 black-text";
								break;
							case "Base":
								$Color = "grey darken-1 black-text";
								break;
							default:
								$Color = "";
								break;
						}

						$Range = [
							"Min" => $Mod["Values"]["Number"] + $Mod["Values"]["Bonus"],
							"Max" => $Mod["Values"]["Number"] * $Mod["Values"]["Sided"] + $Mod["Values"]["Bonus"],
						];
						$Range["Display"] = $Range["Min"] === $Range["Max"] ? "<strong>[{$Range["Max"]}]</strong>" : "[{$Range['Min']}-{$Range['Max']}]";

						echo "<div class='flex w-100 {$Color}'>
							<div class='w-25'>{$Mod['Stat']['Action']['Short']}</div>
							<div class='w-25'>{$Mod['Stat']['Short']}</div>
							<div class='w-25'>{$Range["Display"]}</div>
							<div class='w-25'>" . ($Mod['Values']['Lifespan'] === -1 ? '&#x221e;' : $Mod['Values']['Lifespan']) . "</div>
						</div>";
					}
				}
			?>

			<div class="mods">
				<div class="mods-row">
					<div class="mods-cell red lighten-5">
						<?php foreach($Card->Modifiers as $Mod): ?>
							<?php ModCell(-2, 1, $Mod); ?>
						<?php endforeach; ?>
					</div>
					<div class="mods-cell red lighten-5">
						<?php foreach($Card->Modifiers as $Mod): ?>
							<?php ModCell(-1, 1, $Mod); ?>
						<?php endforeach; ?>
					</div>
					<div class="mods-cell red lighten-5">
						<?php foreach($Card->Modifiers as $Mod): ?>
							<?php ModCell(0, 1, $Mod); ?>
						<?php endforeach; ?>
					</div>
					<div class="mods-cell red lighten-5">
						<?php foreach($Card->Modifiers as $Mod): ?>
							<?php ModCell(1, 1, $Mod); ?>
						<?php endforeach; ?>
					</div>
					<div class="mods-cell red lighten-5">
						<?php foreach($Card->Modifiers as $Mod): ?>
							<?php ModCell(2, 1, $Mod); ?>
						<?php endforeach; ?>
					</div>
				</div>
				<div class="mods-row">
					<div class="mods-cell green lighten-5">
						<?php foreach($Card->Modifiers as $Mod): ?>
							<?php ModCell(-2, 0, $Mod); ?>
						<?php endforeach; ?>
					</div>
					<div class="mods-cell green lighten-5">
						<?php foreach($Card->Modifiers as $Mod): ?>
							<?php ModCell(-1, 0, $Mod); ?>
						<?php endforeach; ?>
					</div>
					<div class="mods-cell bw2 green lighten-5">
						<?php foreach($Card->Modifiers as $Mod): ?>
							<?php ModCell(0, 0, $Mod); ?>
						<?php endforeach; ?>
					</div>
					<div class="mods-cell green lighten-5">
						<?php foreach($Card->Modifiers as $Mod): ?>
							<?php ModCell(1, 0, $Mod); ?>
						<?php endforeach; ?>
					</div>
					<div class="mods-cell green lighten-5">
						<?php foreach($Card->Modifiers as $Mod): ?>
							<?php ModCell(2, 0, $Mod); ?>
						<?php endforeach; ?>
					</div>
				</div>
			</div>

			<ul class="collection ml3 mr3 br2 shadow-3">
				<?php foreach($Card->Modifiers as $i => $Modifier): ?>
					<li class="collection-item">
						<div class="row" tcg="card-modifier-stat" statid="<?= $Modifier["Stat"]["ID"]; ?>">
							<div class="col s6">
								<div>
									<i class="material-icons">insert_chart</i>
									<a class="dropdown-trigger btn deep-purple lighten-2" href="#" data-target="ul-modifier-stat-<?= $i; ?>"><?= "{$Modifier["Stat"]["Label"]} [{$Modifier["Stat"]["Short"]}]"; ?></a>
									<ul id="ul-modifier-stat-<?= $i; ?>" tcg="Stat" class="dropdown-content ul-modifier" csm-id="<?= $Modifier["CardStatModifierID"];?>">
										<li pkid="NULL">-- NULL --</li>
										<li class="divider" tabindex="-1"></li>
										<?php foreach($Stats as $Stat): ?>
											<li pkid="<?= $Stat["StatID"]; ?>"><?= "{$Stat["Label"]} [{$Stat["Short"]}]"; ?></li>
										<?php endforeach; ?>
									</ul>
								</div>
							</div>
							<div class="col s6">
								<div>
									<i class="material-icons">call_split</i>
									<a class="dropdown-trigger btn deep-purple lighten-2" href="#" data-target="ul-modifier-stat-action-<?= $i; ?>"><?= "{$Modifier["Stat"]["Action"]["Label"]} [{$Modifier["Stat"]["Action"]["Short"]}]"; ?></a>
									<ul id="ul-modifier-stat-action-<?= $i; ?>" tcg="StatAction" class="dropdown-content ul-modifier" csm-id="<?= $Modifier["CardStatModifierID"];?>">
										<li pkid="NULL">-- NULL --</li>
										<li class="divider" tabindex="-1"></li>
										<?php foreach($StatActions as $StatAction): ?>
											<li pkid="<?= $StatAction["StatActionID"]; ?>"><?= "{$StatAction["Label"]} [{$StatAction["Short"]}]"; ?></li>
										<?php endforeach; ?>
									</ul>
								</div>
							</div>
						</div>
							
						<div class="row black-text" tcg="card-modifier-target" statid="<?= $Modifier["Target"]["ID"]; ?>">
							<div class="col s6">
								<div>
									<i class="material-icons">location_on</i>
									<div class="flex">
										<input type="number" tcg="target-x" value="<?= "{$Modifier["Target"]["X"]}"; ?>" placeholder="X"/>
										<input type="number" tcg="target-y" value="<?= "{$Modifier["Target"]["Y"]}"; ?>" placeholder="Y"/>
									</div>
								</div>
							</div>
							<div class="col s6">
								<div>
									<i class="material-icons">perm_identity</i>
									
									<a class="dropdown-trigger btn black-text <?= $Modifier["Target"]["IsFriendly"] ? "green lighten-2" : "red lighten-2"; ?>" href="#" data-target="ul-modifier-stat-target-<?= $i; ?>"><?= "{$Modifier["Target"]["Label"]} [{$Modifier["Target"]["Short"]}]"; ?></a>
									<ul id="ul-modifier-stat-target-<?= $i; ?>" tcg="Target" class="dropdown-content ul-modifier" csm-id="<?= $Modifier["CardStatModifierID"];?>">
										<li pkid="NULL">-- NULL --</li>
										<li class="divider" tabindex="-1"></li>
										<?php foreach($Targets as $Target): ?>
											<li pkid="<?= $Target["TargetID"]; ?>"><?= "{$Target["Label"]} [{$Target["Short"]}]"; ?></li>
										<?php endforeach; ?>
									</ul>
								</div>
							</div>
						</div>
						
						<div class="row" tcg="card-modifier-values" statid="<?= $Modifier["Values"]["ID"]; ?>">
							<div class="col s4">
								<div>
									<i class="material-icons">update</i>
									<div class="flex">
										<input type="number" tcg="target-lifespan" min="-1" value="<?= "{$Modifier["Values"]["Lifespan"]}"; ?>" placeholder="Stage"/>
									</div>
								</div>
							</div>
							<div class="col s4">
								<div>
									<i class="material-icons">exposure</i>
									<div class="flex">
										<input type="number" tcg="target-number" value="<?= "{$Modifier["Values"]["Number"]}"; ?>" placeholder="Number"/>
										<input type="number" tcg="target-sided" value="<?= "{$Modifier["Values"]["Sided"]}"; ?>" placeholder="Sided"/>
										<input type="number" tcg="target-bonus" value="<?= "{$Modifier["Values"]["Bonus"]}"; ?>" placeholder="Bonus"/>
									</div>
								</div>
							</div>
							<div class="col s4">
								<div>
									<i class="material-icons">format_list_numbered</i>
									<div class="flex">
										<input type="number" tcg="target-stage" value="<?= "{$Modifier["Values"]["Stage"]}"; ?>" placeholder="Stage"/>
										<input type="number" tcg="target-step" value="<?= "{$Modifier["Values"]["Step"]}"; ?>" placeholder="Step"/>
									</div>
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

		$("[tcg=card-name] > input[type=text]").on("change", function(e) {
			AJAX("UpdateName", {
				CardID: $("ul[tcg=card-id]").attr("card-id"),
				Name: $(this).val()
			}, (e) => {
				location.reload();
			});
		});

		$(".ul-category > li").on("click", function(e) {
			AJAX("UpdateTask", {
				CardID: $("ul[tcg=card-id]").attr("card-id"),
				Table: $(this).parent().attr("tcg"),
				PKID: $(this).attr("pkid")
			}, (e) => {
				location.reload();
			});
		});
		$("[tcg=card-stat] > input[type=number]").on("blur", function(e) {
			AJAX("UpdateStat", {
				CardID: $("ul[tcg=card-id]").attr("card-id"),
				Key: $(this).parent().attr("code"),
				Value: $(this).val()
			}, (e) => {
				location.reload();
			});
		});
		
		$(".ul-modifier > li").on("click", function(e) {
			AJAX("UpdateModifier", {
				CardStatModifierID: $(this).parent().attr("csm-id"),
				Table: $(this).parent().attr("tcg"),
				PKID: $(this).attr("pkid")
			}, (e) => {
				// location.reload();
				console.log(e);
			});
		});
	});
</script>