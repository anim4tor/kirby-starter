<?php if ($page->hero()->isNotEmpty()) : ?>
<section class="intro radius" theme="acc" style="--in-delay: 500ms">
	<div class="intro__cover overlay__harder absolute inset__stretch grid">
		<?= snippet('molecules/Header', ['header' => $page->hero(), 'type' => ['cover']]) ?>		
	</div>
	<div class="z__1 intro__header place__stretch-stretch grid__4 gap__2  mobile:grid__1 h__100v mobile:h__auto inner__1 mobile:inner-t__10 mobile:gap__2 relative color__invert">
		<div class="h__6"></div>
		<div class="span__4 grid place__space-between-stretch">
			<div class="span__4 place__start-start grid__4 gap__2 border__top inner-t__05">
				<div class="span__2">
					<?= snippet('atoms/Text', ['text' => '(' . $page  . ')', 'reveal' => true, 'css' => 'upper' ]) ?>	
				</div>
				<div>
					<?= snippet('molecules/Header', ['header' => $page->hero(), 'type' => ['text']]) ?>
				</div>
			</div>
			<div class="intro__title relative place__end-stretch span__4 mobile:span__1 inner-y__05" style="--in-delay: 500ms">
				<?= snippet('molecules/Header', ['header' => $page->hero(), 'type' => ['heading']]) ?>
			</div>
		</div>
	</div>
</section>
<?php endif ?>