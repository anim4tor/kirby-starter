<aside class="" data-aside data-scroll>
	<div data-aside-widget theme="dark" class="grid inner-x__1 h__100v">
		<div class="aside__header flex gap__1 justify__space-between align__center" theme="dark">
			<div data-reveal>
				<a href="<?= page('home')->url() ?>" class="logo flex relative"><?= svg('public/assets/images/fig_logo_poly.svg') ?></a>
			</div>
			<a data-reveal data-aside-toggle>	
				<?= snippet('atoms/Button', ['label' => '✕', 'theme' => 'invert-ghost']) ?>
			</a>
		</div>
		<nav data-reveal-text="words" class="grid align__center gap__1 font__size__1" >
			<?php foreach ($pages->listed()->not('home') as $item): ?>
				<?= snippet('atoms/Link', ['url' => $item->url(), 'label' => $item->title(), 'icon' => false]) ?>
			<?php endforeach ?>
		</nav>
	</div>
</aside>
