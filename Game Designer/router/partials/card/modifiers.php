<h6 tcg="card-name" class="tc">Modifiers</h6>
			
<div class="cell-injection">
	<?php include "{$_SERVER["DOCUMENT_ROOT"]}/router/partials/card/modifiers-cells.php"; ?>
</div>

<div class="flex mr2 ml2 mt3">
	<a class="w-100 waves-effect waves-dark btn green b ba green-text text-darken-4" action="Add"><i class="material-icons">add</i></a>
</div>

<ul>
	<?php foreach($Card->Modifiers as $i => $Modifier): ?>
		<li class="shadow-3 ba br2 pa2 ma2 mb3 grey-text" csm-id="<?= $Modifier["CardStatModifierID"];?>">
			<div class="row" tcg="card-modifier-stat" statid="<?= $Modifier["Stat"]["ID"]; ?>">
				<div class="col s6">
					<div>
						<i class="material-icons">insert_chart</i>
						<a tcg="Stat" csm-id="<?= $Modifier["CardStatModifierID"];?>" class="dropdown-trigger btn ba white <?= $Card->ColorLookup["Stat"][$Modifier["Stat"]["Short"]]; ?>" href="#" data-target="ul-modifier-stat-<?= $i; ?>"><?= "{$Modifier["Stat"]["Label"]} [{$Modifier["Stat"]["Short"]}]"; ?></a>
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
						<a tcg="StatAction" csm-id="<?= $Modifier["CardStatModifierID"];?>"  class="dropdown-trigger btn ba white <?= $Card->ColorLookup["StatAction"]["Foreground"][$Modifier["Stat"]["Action"]["Short"]]; ?>" href="#" data-target="ul-modifier-stat-action-<?= $i; ?>"><?= "{$Modifier["Stat"]["Action"]["Label"]} [{$Modifier["Stat"]["Action"]["Short"]}]"; ?></a>
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
						<a tcg="Target" csm-id="<?= $Modifier["CardStatModifierID"];?>" class="dropdown-trigger btn ba white <?= $Modifier["Target"]["IsFriendly"] ? $Card->ColorLookup["Target"]["Friendly"] : $Card->ColorLookup["Target"]["Enemy"]; ?>" href="#" data-target="ul-modifier-stat-target-<?= $i; ?>"><?= "{$Modifier["Target"]["Label"]} [{$Modifier["Target"]["Short"]}]"; ?></a>
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

<script>
	$(document).ready(function() {
		function LoadCells() {
			$(".cell-injection").empty();
			$(".cell-injection").load("/router/partials/card/modifiers-cells.php?CardID=<?= $Card->ID; ?>");
		}

		$("a[action]").on("click", function(e) {
			if($(this).attr("action") === "Add") {
				AJAX("UpdateModifierState", {
					CardID: <?= $Card->ID; ?>,
					Action: "Add"
				}, (e) => {
					location.reload();
				});
			} else if($(this).attr("action") === "DeActivate") {
				AJAX("UpdateModifierState", {
					CardStatModifierID: $(this).parents("li[csm-id]").attr("csm-id"),
					Action: "DeActivate"
				}, (e) => {
					if(e !== null && e !== void 0) {
						let response = JSON.parse(e)[0],
							text = null,
							css = null;

						if(+response.ModifierIsActive === 1) {
							text = "<i class='material-icons'>visibility_on</i>";
							css = "green lighten-3 green-text text-darken-2";
						} else {
							text = "<i class='material-icons'>visibility_off</i>";
							css = "grey lighten-3 grey-text text-darken-2";
						}
						$(`li[csm-id=${+response.CardStatModifierID}] a[action=DeActivate]`)
							.html(text)
							.attr("class", `w-80 waves-effect waves-dark btn b ba ${css}`);

						LoadCells();
					}
				});
			} else if($(this).attr("action") === "Delete") {
				if(confirm("Are you sure?")) {
					AJAX("UpdateModifierState", {
						CardStatModifierID: $(this).parents("li[csm-id]").attr("csm-id"),
						Action: "Delete"
					}, (e) => {
						location.reload();
					});
				}
			}
		});

		$(".ul-modifier > li").on("click", function(e) {
			AJAX("UpdateModifier", {
				CardStatModifierID: $(this).parent().attr("csm-id"),
				Table: $(this).parent().attr("tcg"),
				PKID: $(this).attr("pkid")
			}, (e) => {
				if(e !== null && e !== void 0) {
					let response = JSON.parse(e);
					
					let a = response.Lookup.filter(r => r[`${response.Result[0].Table}ID`] === response.Result[0].PKID);
					$(`a[tcg=${response.Result[0].Table}][csm-id=${response.Result[0].CardStatModifierID}]`)
						.text(`${a[0].Label} [${a[0].Short}]`)
						.attr("class", `dropdown-trigger btn ba white ${ColorLookup[response.Result[0].Table][a[0].Short]}`);
					if(response.Result[0].Table === "StatAction") {
						$(`a[tcg=${response.Result[0].Table}][csm-id=${response.Result[0].CardStatModifierID}]`)
							.attr("class", `dropdown-trigger btn ba white ${ColorLookup["StatAction"]["Foreground"][a[0].Short]}`);
					}
					if(response.Result[0].Table === "Target") {
						$(`a[tcg=${response.Result[0].Table}][csm-id=${response.Result[0].CardStatModifierID}]`)
							.attr("class", `dropdown-trigger btn ba white ${ColorLookup["Target"][+a[0].IsFriendly === 1 ? "Friendly" : "Enemy"]}`);

						$(`div[tcg=${response.Result[0].Table}][csm-id=${response.Result[0].CardStatModifierID}] > [tcg=X]`).val(a[0].X);
						$(`div[tcg=${response.Result[0].Table}][csm-id=${response.Result[0].CardStatModifierID}] > [tcg=Y]`).val(a[0].Y);
					}

					AjaxFade(
						$(`a[tcg=${response.Result[0].Table}][csm-id=${response.Result[0].CardStatModifierID}]`).parent(),
						e,
						true
					);
					
					LoadCells();
				} else {
					AjaxFade(
						$(this),
						e,
						false
					);
				}
			});
		});

		$("[tcg=card-modifier-values] input[type=number]").on("blur", function(e) {
			AJAX("UpdateModifier", {
				CardStatModifierID: $(this).parents("div.row[csm-id]").attr("csm-id"),
				Key: $(this).attr("tcg"),
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
					
					LoadCells();
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