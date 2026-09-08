<?php if ($page->hero()->isNotEmpty()) : ?>
<section class="intro radius" theme="dark" data-tabs="" data-autoplay="10000">
	<div class="hidden">
		<?php foreach ($page->heroSlider()->toPages() as $project) : ?>
			<div data-tab="project-<?= $project->indexOf($page->heroSlider()->toPages()) ?>"></div>
		<?php endforeach ?>
	</div>
	<div data-pane-container class="grid__stack absolute inset__stretch" >
		<?php $heroProjects = $page->heroSlider()->toPages(); ?>
		<?php foreach ($heroProjects as $index => $project) : ?>
			<?php if ($cover = $project->cover()->toFile()) : ?>
			<div data-tab-reveal data-pane="project-<?= $project->indexOf($heroProjects) ?>" >
				<div class="intro__cover grid " data-reveal-image><?= snippet('atoms/Image', [
					'img' => $cover, 
					'parallax' => 2, 
					'reveal' => false, 
					'css' => 'overlay__bottom h__100v',
					'priority' => $project->indexOf($heroProjects) === 0
				]) ?></div>
			</div>
			<?php endif ?>
		<?php endforeach ?>
	</div>
	<div class="z__1 intro__header grid__4 place__stretch-stretch mobile:grid__1 h__100v intro__rows mobile:h__auto inner__1  mobile:inner-t__10 mobile:gap__2 relative color__invert">
		<div class="h__1"></div>
		<div class="span__4 grid__4 place__space-between-stretch">
			<div class="span__4 grid__4 inner-t__05 relative flex justify__space-between align__start border__top" data-scroll data-scroll-ignore>
				<div data-tabs-autoplay-line class="autoplay__line absolute left__0 right__0"></div>
				<div class="upper font__size__small" data-tab-next>Featured project</div>
				<div class="span__2 grid__stack" data-pane-container>
					<?php foreach ($page->heroSlider()->toPages() as $project) : ?>
						<?php if ($cover = $project->cover()->toFile()) : ?>
						<div data-pane="project-<?= $project->indexOf($page->heroSlider()->toPages()) ?>" class="grid__2" data-tab-reveal>
							<a href="<?= $project->url() ?>"><div data-reveal-text="words" data-split-ignore class="upper font__size__small"><?= $project->title() ?></div></a>
							<div data-reveal-text="words" data-split-ignore class="upper font__size__small flex justify__end"><?= $project->date()->toDate('Y') ?></div>
						</div>	
						<?php endif ?>
					<?php endforeach ?>
				</div>
				<div class="upper font__size__small flex justify__end" data-tab-next>(Next)</div>
			</div>
			<div class="intro__title relative place__end-stretch span__3 mobile:span__1 inner-y__05 " style="--in-delay: 0ms">
				<?= snippet('molecules/Header', ['header' => $page->hero(), 'type' => ['heading']]) ?>
			</div>
		</div>
	</div>
</section>
<?php endif ?>

