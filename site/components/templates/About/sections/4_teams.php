<?php if (collection('Team')->isNotEmpty()) : ?>
<section class="teams radius" theme="invert" >
	<div class="relative grid gap__0 inner-x__1">
		<div class="flex justify__space-between border__top inner-y__1" data-scroll>
			<?= snippet('atoms/Text', ['text' => '(Our teams)', 'reveal' => true ]) ?>	
			<div></div>
		</div>
		<div class="grid__4 gap__2 relative place__start-start inner-y__2 inner-b__5" data-tabs="hoverable">
			<div class="grid place__start-start" data-pane-container>
				<div class="grid__stack no__overflow img__radius">
					<?php foreach (collection('Team') as $team) : ?>
						<?php if ($leader = $team->leader()->toPage()) : ?>
						<div data-pane="team-<?= $team->indexOf(collection('Team')) ?>" class="" data-scroll data-scroll-ignore data-tab-reveal>
							<div class="grid gap__05">
								<?php if ($img = $team->figure()->toFile()) : ?>
									<?= snippet('atoms/Image', ['img' => $img, 'parallax' => false, 'reveal' => false, 'css' => 'aspect__4/3', 'node' => 'data-reveal-image']) ?>
								<?php endif ?>
								<?= snippet('atoms/Text', ['text' => $team->details()->inline(), 'reveal' => true, 'node' => 'data-split-ignore data-scroll-ignore']) ?>
							</div>
						</div>
						<?php endif ?>
					<?php endforeach ?>
				</div>
			</div>
			<div></div>
			<div class="span__2 grid place__start-start gap__2" >
				<div class="grid gap__02 place__start-start" >
					<?php foreach (collection('Team') as $team) : ?>
						<?php
							$employees = collection('Employees')->filterBy('team', '*=', $team->name())->count();
						?>
						<div data-tab="team-<?= $team->indexOf(collection('Team')) ?>" class="flex gap__02" data-scroll>
							<?= snippet('atoms/Heading', [ 'level' => 'h3', 'text' => $team->name(), 'reveal' => true, 'node' => 'data-split-ignore' ]) ?>
						</div>
					<?php endforeach ?>
				</div>
				
			</div>
		</div>
	</div>	
</section>
<?php endif ?>
