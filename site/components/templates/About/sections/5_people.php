<?php if (collection('Employees')->isNotEmpty()) : ?>
<section class="people " theme="invert" >
	<div class="relative grid gap__5 inner-x__1 ">
		<div class="border__top inner-y__1" data-scroll>
			<h2 class="flex justify__space-between" data-reveal-text>
				<span class="">The</span>
				<span class="">People</span>
			</h2>
		</div>
		<div class="grid__3 inner-b__5" data-tabs="hoverable">
			<div class="grid gap__02 place__start-stretch span__2">
				
			<?php foreach (collection('Team') as $team) : ?>
				<div id="<?= $team->name()->slug() ?>" class="grid__2 gap__2 relative" >
					
					<div class="grid place__start-start " >
						<div class="grid place__start-start gap__1 " data-scroll>
							<?= snippet('atoms/Text', ['text' => '(' . $team->name()  . ')', 'reveal' => true, 'node' => 'data-split-ignore data-scroll-ignore']) ?>							
						</div>
					</div>
					<div class="grid gap__02 place__start-start gap__2 " >
						<?php foreach (collection('Employees')->filterBy('team', $team->name()) as $employee) : ?>
							<div data-tab="people-<?= $employee->indexOf(collection('Employees')) ?>" class="flex gap__02" data-scroll>
								<h3 class="no__wrap" data-reveal-text data-split-ignore><?= $employee->title() ?></h3>
							</div>
						<?php endforeach ?>
					</div>
					
				</div>
			<?php endforeach ?>
			</div>
			<div class="grid place__start-end" data-pane-container>
				<div class="sticky top__8 grid__stack no__overflow img__radius">
					<?php foreach (collection('Employees') as $employee) : ?>
						<div data-pane="people-<?= $employee->indexOf(collection('Employees')) ?>" class="" data-scroll data-scroll-ignore data-tab-reveal>
							<div class="grid place__start-end gap__05">
								<?php if ($photo = $employee->photo()->toFile()) : ?>
									<?= snippet('atoms/Image', ['img' => $photo, 'parallax' => false, 'reveal' => false, 'css' => 'w__10 aspect__3/4', 'node' => 'data-reveal-image']) ?>
								<?php endif ?>
								<div class="flex gap__05 justify__space-between upper wrap">
									<?= snippet('atoms/Text', ['text' => '(' . $employee->role() . ')', 'reveal' => true, 'node' => 'data-split-ignore data-scroll-ignore']) ?>
								</div>
							</div>
						</div>
					<?php endforeach ?>
				</div>
			</div>
		</div>
	</div>
</section>
<?php endif ?>
