<?php if ($page->career()->isNotEmpty()) : ?>
<section class="careers" theme="invert">
	<div class="grid__2 gap__2 place__stretch-stretch inner__1 inner-y__2 inner-b__5">
		<div class="relative grid gap__5 place__start-stretch" data-scroll >
			<div class="grid place__space-between-stretch" data-reveal-text>
				<?= snippet('molecules/Header', ['header' => $page->career(), 'type' => ['heading']]) ?>
			</div>
			<div class="flex justify__space-between gap__4 inner-y__1 inner-b__3 border__top">
				<?= snippet('molecules/Header', ['header' => $page->career(), 'type' => ['text']]) ?>
				<?= snippet('molecules/Header', ['header' => $page->career(), 'type' => ['button']]) ?>
			</div>
		</div>
		<div class="grid inner-l__3" data-scroll >
			<?= snippet('molecules/Header', ['header' => $page->career(), 'type' => ['image']]) ?>
		</div>

	</div>
</section>
<?php endif ?>