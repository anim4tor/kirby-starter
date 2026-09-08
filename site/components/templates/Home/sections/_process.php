<section class="process" theme="invert">
	<div class="bg radius absolute inset__stretch" theme="invert"></div>
	<div class="grid__4 mobile:grid__1 mobile:h__auto inner__1 inner-y__2 mobile:inner-t__10 mobile:gap__2 relative" data-scroll>
		<!-- <?php if ($cover = $page->cover()->toFile()) : ?>
			<div class="intro__cover absolute inset__stretch grid overlay__bottom"><?= snippet('atoms/Image', ['img' => $cover, 'parallax' => 2]) ?></div>
		<?php endif ?> -->
		<div class="intro__title relative span__3 mobile:span__1" data-scroll data-scroll-speed="-0.5">
			<h2 data-reveal-text>The Process</h2>
		</div>
		<div class="relative flex justify__end align__start"><strong class="upper font__size__small" data-reveal-text="lines">(The Process)</strong></div>
	</div>
	<div class="grid__2 gap__2 relative place__start-start inner-y__2 inner-b__5" data-tabs>
		<div class="sticky top__0 grid h__100v inner-y__1" >
			<div class="grid place__start-start inner-x__1" >
				<?php foreach (collection('Process') as $step) : ?>
					<div data-tab="step-<?= $step->step()?>" class="flex align__start gap__02 inner-y__02" data-scroll >
						<h3 class="" data-reveal-text data-split-ignore><?= $step->label() ?></h3>
						<span data-reveal-text="lines" class="-wrap-t__03">(<?= $step->step() ?>)</span>
					</div>
				<?php endforeach ?>
			</div>
			<div class="grid place__end-end inner-x__1 " data-scroll data-scroll-ignore>
				<div data-pane-container class="grid__stack place__end-end">
					<?php foreach (collection('Process') as $step) : ?>
					<div data-pane="step-<?= $step->step()?>" class="grid__2">
						<div></div>
						<p class="upper font__size__small" data-reveal-text="lines" data-split-ignore data-tab-reveal><?= $step->detail()->inline() ?></p>
					</div>
					<?php endforeach ?>
				</div>
			</div>
		</div>
		<div class="grid inner-r__1">
			<?php foreach (collection('Process') as $step) : ?>
				<?php if ($img = $step->figure()->toFile()) : ?>
					<div data-pane-trigger=step-<?= $step->step()?> id="trigger-<?= $step->step() ?>" class=""><?= snippet('atoms/Image', ['img' => $img, 'parallax' => 10, 'reveal' => false, 'css' => 'vh__20 radius']) ?></div>
				<?php endif ?>
			<?php endforeach ?>
		</div>
	</div>
</section>