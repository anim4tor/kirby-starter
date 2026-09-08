<?php if ($site->ctaContact()->isNotEmpty()) : ?>
<section class="cta">
	<a href="" data-contact-toggle="inquiry">
		<div class="bg radius absolute inset__stretch" theme="acc"></div>
		<div class="relative grid__4 gap__1 mobile:grid__1 inner__1 inner-y__2">
			<div class="item__figure grid img__radius">
				<?= snippet('molecules/Header', ['header' => $site->ctaContact(), 'type' => ['image']]) ?>
			</div>
			<div class="span__3 grid gap__6 place__start-start">
				<?= snippet('molecules/Header', ['header' => $site->ctaContact(), 'type' => ['heading']]) ?>
				<?= snippet('molecules/Header', ['header' => $site->ctaContact(), 'type' => ['button']]) ?>
			</div>
		</div>
	</a>
</section>
<?php endif ?>
