<footer id="footer" class="" theme="invert" data-footer data-scroll>
	<div class="bg radius absolute inset__stretch"></div>

	<div class="grid__4 gap__1 inner-x__4 inner-y__2 inner-b__1">
		<a class="footer__logo" href="<?= page('home')->url() ?>"><span data-reveal ><?= svg('public/assets/images/fig_logo_invert.svg') ?></span></a>	
		<nav class="span__3 footer__nav flex wrap align__center gap__02 ff__heading font__size__3">
			<?php foreach ($pages->listed() as $p): ?>
				<?php if(!$p->isFirst()) : ?>
					<span class="light ff__body op__2">/</span>
				<?php endif ?>
				<?= snippet('atoms/Link', ['url' => $p->url(), 'label' => $p->title(), 'icon' => false, 'css' => !$p->isActive() ? 'op__4' : '', 'node' => 'data-reveal-text data-split-ignore']) ?>
			<?php endforeach ?>
			
		</nav>
		<div class="relative span__4 grid__4 gap__1 inner-t__6">	
			
			<div class="grid place__space-between-start gap__2">
				<div class="grid gap__02">
					<div class="label upper font__size__small op__4">(Contact)</div>
					<p class="">U1 s.r.o. <br>Nejedlého 373/1, Brno-Lesná, 638 00 <br>IČ 26273179</p>
				</div>
				<div class=""><a href="">sales@u1.cz</a></div>
			</div>	
			<div class="grid place__space-between-start gap__2">
				<div class="grid gap__02">
					<div class="label upper font__size__small op__4">(Newsletter)</div>
					<p class="">subscribe for weekly design inspiration.</p>
				</div>
				<div class=" op__4"><a href="">email</a></div>
			</div>
			<div></div>
			<div class="grid place__space-between-start gap__02">
				<div class="grid gap__02">
					<div class="label upper font__size__small op__4">(Socials)</div>
					<nav class="flex gap__02">
						<?php foreach ($site->social()->toStructure() as $s): ?>
							<?php if(!$s->isFirst()) : ?>
								<span class="light ff__body op__2">/</span>
							<?php endif ?>
							<?= snippet('atoms/Link', ['url' => $s->link()->url(), 'label' => $s->platform(), 'icon' => false, 'node' => 'data-reveal-text data-split-ignore']) ?>
						<?php endforeach ?>
					</nav>
				</div>
				<div class="grid">
					<nav data-reveal-text="words" class="flex justify__space-between gap__05 op__5 font__size__default">
						<?= snippet('atoms/Link', ['url' => 'terms', 'label' => 'Terms', 'icon' => false]) ?>
						<?= snippet('atoms/Link', ['url' => 'privacy', 'label' => 'Privacy', 'icon' => false]) ?>
						<?= snippet('atoms/Link', ['url' => 'cookies', 'label' => 'Cookies', 'icon' => false]) ?>
					</nav>
				</div>
			</div>	
			
		</div>

	</div>
</footer>

