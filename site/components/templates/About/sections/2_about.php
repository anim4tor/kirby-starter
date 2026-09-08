<?php if ($page->about()->isNotEmpty()) : ?>
<section class="about" theme="invert">
	<div class="grid__3 gap__2 mobile:grid__1 inner__1 mobile:inner-x__1 inner-y__2 inner-b__5">
		<div class="span__2 grid place__start-start gap__3 mobile:inner-x__0">
			<?= snippet('molecules/Header', ['header' => $page->about(), 'type' => ['heading']]) ?>
		</div>
		<div></div>
		<div></div>
		<div class="grid gap__2">
			<?= snippet('molecules/Header', ['header' => $page->about(), 'type' => ['image']]) ?>
			<?= snippet('molecules/Header', ['header' => $page->about(), 'type' => ['text']]) ?>
		</div>
		<div class="flex justify__end">(<?= snippet('molecules/Header', ['header' => $page->about(), 'type' => ['label']]) ?>)</div>
	</div>
	<div class="inner-x__1 inner-y__2">	
		<?= snippet('templates/globals/Figures') ?>
	</div>
</section>
<?php endif ?>