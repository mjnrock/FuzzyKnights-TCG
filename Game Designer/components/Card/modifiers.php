<h6 tcg="card-name" class="tc">Modifiers</h6>
			
<div class="cell-injection">
	<?php include "{$_SERVER["DOCUMENT_ROOT"]}/components/Card/ModifiersCells.php"; ?>
</div>

<div class="flex mr2 ml2 mt3">
	<a class="w-100 waves-effect waves-dark btn green lighten-1 white-text" action="Add">Add Modifier</a>
</div>

<ul>
	<?php foreach($Card->Modifiers as $i => $Modifier): ?>
		<li class="shadow-3 ba br2 pa2 ma2 mb3 grey-text" csm-id="<?= $Modifier["CardStatModifierID"];?>">
			<div class="row" tcg="card-modifier-stat" statid="<?= $Modifier["Stat"]["ID"]; ?>">
				<div class="col s6">
					<div>
						<i class="material-icons">insert_chart</i>
						<a tcg="Stat" csm-id="<?= $Modifier["CardStatModifierID"];?>" class="dropdown-trigger btn ba white <?= \Card\Card::$ColorLookup["Stat"][$Modifier["Stat"]["Short"]]; ?>" href="#" data-target="ul-modifier-stat-<?= $i; ?>"><?= "{$Modifier["Stat"]["Label"]} [{$Modifier["Stat"]["Short"]}]"; ?></a>
						<ul id="ul-modifier-stat-<?= $i; ?>" tcg="Stat" class="dropdown-content ul-modifier" csm-id="<?= $Modifier["CardStatModifierID"];?>">
							<?php foreach($Stats as $Stat): ?>
								<li pkid="<?= $Stat["StatID"]; ?>"><?= "{$Stat["Label"]} [{$Stat["Short"]}]"; ?></li>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>
				<div class="col s6">
					<div>
						<i class="material-icons">call_split</i>
						<a tcg="StatAction" csm-id="<?= $Modifier["CardStatModifierID"];?>"  class="dropdown-trigger btn ba white <?= \Card\Card::$ColorLookup["StatAction"]["Foreground"][$Modifier["Stat"]["Action"]["Short"]]; ?>" href="#" data-target="ul-modifier-stat-action-<?= $i; ?>"><?= "{$Modifier["Stat"]["Action"]["Label"]} [{$Modifier["Stat"]["Action"]["Short"]}]"; ?></a>
						<ul id="ul-modifier-stat-action-<?= $i; ?>" tcg="StatAction" class="dropdown-content ul-modifier" csm-id="<?= $Modifier["CardStatModifierID"];?>">
							<?php foreach($StatActions as $StatAction): ?>
								<li pkid="<?= $StatAction["StatActionID"]; ?>"><?= "{$StatAction["Label"]} [{$StatAction["Short"]}]"; ?></li>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>
			</div>
				
			<div class="row" tcg="card-modifier-target" statid="<?= $Modifier["Target"]["ID"]; ?>">
				<div class="col s6">
					<div>
						<i class="material-icons">location_on</i>
						<div tcg="Target" csm-id="<?= $Modifier["CardStatModifierID"];?>" class="flex">
							<input readonly type="number" min="-2" max="2" tcg="X" value="<?= "{$Modifier["Target"]["X"]}"; ?>" placeholder="X"/>
							<input readonly type="number" min="0" max="1" tcg="Y" value="<?= "{$Modifier["Target"]["Y"]}"; ?>" placeholder="Y"/>
						</div>
					</div>
				</div>
				<div class="col s6">
					<div>
						<i class="material-icons">perm_identity</i>									
						<a tcg="Target" csm-id="<?= $Modifier["CardStatModifierID"];?>" class="dropdown-trigger btn ba white <?= $Modifier["Target"]["IsFriendly"] ? \Card\Card::$ColorLookup["Target"]["Friendly"] : \Card\Card::$ColorLookup["Target"]["Enemy"]; ?>" href="#" data-target="ul-modifier-stat-target-<?= $i; ?>"><?= "{$Modifier["Target"]["Label"]} [{$Modifier["Target"]["Short"]}]"; ?></a>
						<ul id="ul-modifier-stat-target-<?= $i; ?>" tcg="Target" class="dropdown-content ul-modifier" csm-id="<?= $Modifier["CardStatModifierID"];?>">
							<?php foreach($Targets as $Target): ?>
								<li pkid="<?= $Target["TargetID"]; ?>"><?= "{$Target["Label"]} [{$Target["Short"]}]"; ?></li>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>
			</div>
			
			<div class="row" tcg="card-modifier-values" csm-id="<?= $Modifier["CardStatModifierID"];?>">
				<div class="col s4">
					<div>
						<i class="material-icons">update</i>
						<div class="flex">
							<input type="number" tcg="Lifespan" min="-1" value="<?= "{$Modifier["Values"]["Lifespan"]}"; ?>" placeholder="Lifespan"/>
						</div>
					</div>
				</div>
				<div class="col s4">
					<div>
						<i class="material-icons">exposure</i>
						<div class="flex">
							<input type="number" min="0" tcg="Number" value="<?= "{$Modifier["Values"]["Number"]}"; ?>" placeholder="Number" />
							<input type="number" min="0" tcg="Sided" value="<?= "{$Modifier["Values"]["Sided"]}"; ?>" placeholder="Sided" />
							<input type="number" min="0" tcg="Bonus" value="<?= "{$Modifier["Values"]["Bonus"]}"; ?>" placeholder="Bonus" />
						</div>
					</div>
				</div>
				<div class="col s4">
					<div>
						<i class="material-icons">format_list_numbered</i>
						<div class="flex">
							<input type="number" min="1" tcg="Stage" value="<?= "{$Modifier["Values"]["Stage"]}"; ?>" placeholder="Stage"/>
							<input type="number" min="1" tcg="Step" value="<?= "{$Modifier["Values"]["Step"]}"; ?>" placeholder="Step"/>
						</div>
					</div>
				</div>
			</div>
			<div class="flex">
				<a class="w-20 mr1 waves-effect waves-dark btn red lighten-3 b ba red-text text-darken-4" action="Delete"><i class="material-icons">delete_forever</i></a>
				<a class="w-80 waves-effect waves-dark btn b ba <?= $Modifier["IsActive"] ? "green lighten-3 green-text text-darken-2" : "grey lighten-3 grey-text text-darken-2"; ?>" action="DeActivate"><?= $Modifier["IsActive"] ? "<i class='material-icons'>visibility_on</i>" : "<i class='material-icons'>visibility_off</i>"; ?></a>
			</div>
		</li>
	<?php endforeach; ?>
</ul>