<?php
	$theme   = (!isset($theme)   || trim($theme)   === '') ? 'invert' : $theme;
?>

<?php if (collection('Process')->isNotEmpty()) : ?>
<section class="process" <?= $theme ? 'theme="'.$theme.'"' : null ?>>
	<div class="grid__stack gap__2 relative" data-tabs="scrollable" >
		<div class="sticky top__0 gap__2 grid place__space-between-stretch h__100v inner-y__2 radius" >
			<div class="grid absolute inset__stretch" theme="dark">
				<div data-pane-container class="grid__stack">
					<?php foreach (collection('Process') as $step) : ?>
						<?php if ($img = $step->figure()->toFile()) : ?>
							<div data-scroll data-scroll-ignore data-tab-reveal data-pane="step-<?= $step->step() ?>" id="trigger-<?= $step->step() ?>" class="vh__20 grid overlay__bottom">
								<div class="grid w__100v h__100v" data-reveal-image>
									<?= snippet('atoms/Image', ['img' => $img, 'reveal' => false, 'css' => 'radius overlay__bottom']) ?>
								</div>
							</div>
						<?php endif ?>
					<?php endforeach ?>
				</div>
			</div>
			<div class="relative z__1 grid gap__2 inner-x__1 color__invert">
				<div class="" data-scroll>
					<h2 class="flex justify__space-between" data-reveal-text><span>The</span><span>Process</span></h2>
				</div>
			</div>
			<!-- <div class="relative flex inner-x__1 z__1 color__invert">
				<?= snippet('atoms/Text', ['text' => '(Our process)', 'reveal' => true, 'css' => 'upper' ]) ?>	
			</div> -->
			<div class="grid gap__05 place__start-stretch z__1 relative color__invert">
				<div class="grid__5 " data-scroll >
					<?php foreach (collection('Process') as $step) : ?>
						<div class="grid place__end-start gap__1 inner__1">
							<div data-tab="step-<?= $step->step()?>" class="flex align__start gap__02" >
								<?= snippet('atoms/Heading', [ 'level' => 'h3', 'text' => $step->label(), 'reveal' => true, 'css' => '', 'node' => 'data-split-ignore' ]) ?>
								<div data-reveal-text="" class="" data-split-ignore style="--in-delay: 800ms">(<?= $step->step() ?>)</div>
							</div>
						</div>

					<?php endforeach ?>
				</div>
				<div class="border__top grid">
					<div data-tabs-progress-line class="progress__line"></div>
				</div>
				<div data-pane-container class="grid__5" data-scroll>
					<?php foreach (collection('Process') as $step) : ?>
						<div class="grid gap__1 inner__1" data-tab-reveal data-pane="step-<?= $step->step() ?>" id="trigger-<?= $step->step() ?>">
							<p class="" data-reveal-text="lines" data-split-ignore ><?= $step->detail()->inline() ?></p>
						</div>

					<?php endforeach ?>
				</div>
			</div>

		</div>
		
		<div class="grid">
			<?php foreach (collection('Process') as $step) : ?>
				<?php if ($img = $step->figure()->toFile()) : ?>
					<div data-pane-trigger="step-<?= $step->step() ?>" id="trigger-<?= $step->step() ?>" class="vh__15 grid">
					</div>
				<?php endif ?>
			<?php endforeach ?>
			<div class="vh__15 grid"></div>
		</div>
	</div>
</section>
<?php endif ?>