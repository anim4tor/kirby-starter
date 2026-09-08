<?php if (collection('Team')->isNotEmpty()) : ?>
<section class="team" theme="invert" >
	<div class="relative grid gap__2 inner-x__1 inner-y__1">
		<div class="" data-scroll>
			<?= snippet('molecules/Header', ['header' => $page->teams(), 'type' => ['heading']]) ?>
		</div>
	</div>
	<div class="grid__3 gap__2 relative place__start-start inner-b__2 inner-x__1" data-tabs="hoverable">
		<!-- <div></div> -->
		<div class="span__2 grid place__start-start gap__1 inner-y__1" >
			<div class="grid gap__02 place__start-start" >
				<?php foreach (collection('Team') as $team) : ?>
					<?php
						$employees = collection('Employees')->filterBy('team', '*=', $team->name())->count();
					?>
					<a href="<?= $pages->find('about')->url() ?>/#<?= $team->name()->slug() ?>" data-tab="team-<?= $team->indexOf(collection('Team')) ?>" class="flex gap__02 no__wrap" data-scroll>
						<h3 data-reveal-text data-split-ignore><?= $team->name() ?></h3>
						<div data-reveal-text="" data-split-ignore style="--in-delay: 800ms" class="-wrap-t__01">(<?= $employees ?>)</div>
					</a>
				<?php endforeach ?>
			</div>
			<!-- <div class="grid__2" data-scroll data-scroll-ignore>
				<div data-pane-container class="grid__stack">
					<?php foreach (collection('Team') as $team) : ?>
					<div data-tab-reveal data-pane="team-<?= $team->indexOf(collection('Team')) ?>" class="grid ">
						<p class="" data-reveal-text="lines" data-split-ignore ><?= $team->details()->inline() ?></p>
					</div>
					<?php endforeach ?>
				</div>
			</div> -->
		</div>
		<div class="grid place__start-end" data-pane-container>
			<div class="grid__stack no__overflow img__radius" data-scroll data-reveal-image >
				<?php foreach (collection('Team') as $team) : ?>
					<?php if ($leader = $team->leader()->toPage()) : ?>
					<div data-pane="team-<?= $team->indexOf(collection('Team')) ?>" class="" data-scroll data-scroll-ignore data-tab-reveal>
						<div class="grid place__start-end gap__05">
							<div class="grid gap__05">
								<?php if ($img = $team->figure()->toFile()) : ?>
									<?= snippet('atoms/Image', ['img' => $img, 'parallax' => false, 'reveal' => false, 'css' => 'aspect__6/4', 'node' => 'data-reveal-image']) ?>
								<?php endif ?>
								<?= snippet('atoms/Text', ['text' => $team->details()->inline(), 'reveal' => true, 'node' => 'data-split-ignore data-scroll-ignore']) ?>
							</div>
							<!-- <?php if ($photo = $leader->photo()->toFile()) : ?>
								<div data-reveal-image class="item__figure img__radius no__overflow "><?= snippet('atoms/Image', ['img' => $photo, 'parallax' => 1, 'css' => 'w__10 aspect__3/4 grid' ]) ?></div>
							<?php endif ?>

							<div class="flex gap__05 justify__space-between upper wrap">
								<span class="font__size__default ff__body" data-split-ignore data-reveal-text="lines" ><?= $leader->title() ?></span>
								<h3 class="font__size__default ff__body" data-split-ignore data-reveal-text="lines" >(<?= $leader->role() ?>)</h3>
							</div> -->
						</div>
					</div>
					<?php endif ?>
				<?php endforeach ?>
			</div>
		</div>
	</div>
</section>
<?php endif ?>