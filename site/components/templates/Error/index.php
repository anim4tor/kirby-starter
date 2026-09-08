<?php if ($page->error()->isNotEmpty()) : ?>
<section class="intro radius" theme="invert" style="--in-delay: 500ms">
	<div data-scroll class="z__1 intro__header place__stretch-stretch grid__4 mobile:grid__1 h__100v mobile:h__auto inner__1 mobile:inner-t__10 mobile:gap__2 relative">
		<div class="span__4 grid place__end-stretch border__bottom inner-y__1">
			<?= snippet('molecules/Header', ['header' => $page->error(), 'type' => ['heading']]) ?>
		</div>
		<div class="span__4 grid__4 place__start-stretch inner-y__1">
			<div></div>
			<div></div>
			<div class="grid gap__2">
				<?= snippet('molecules/Header', ['header' => $page->error(), 'type' => ['text']]) ?>
				<?= snippet('molecules/Header', ['header' => $page->error(), 'type' => ['button']]) ?>
			</div>
		</div>
	</div>
</section>
<?php endif ?>