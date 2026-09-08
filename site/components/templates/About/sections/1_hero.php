<?php if ($page->hero()->isNotEmpty()) : ?>
<section class="intro radius" theme="invert" style="--in-delay: 500ms">
	<div class="z__1 intro__header inner-b__2 place__stretch-stretch grid__4 gap__2 mobile:grid__1 mobile:h__auto inner__1 mobile:inner-t__10 mobile:gap__2 relative ">
		<div class="span__4 h__6"></div>
		<div class="span__4 inner-t__05 border__top grid__4 place__space-between-stretch">
			<div class="span__4">
				<div class="flex align__start justify__center gap__02 inner-y__02">
					<div>
						<?= snippet('molecules/Header', ['header' => $page->hero(), 'type' => ['heading']]) ?>
					</div>
				</div>
			</div>
			<div></div>
			<div class="grid gap__1 place__start-end">
				<?= snippet('molecules/Header', ['header' => $page->hero(), 'type' => ['button']]) ?>
			</div>
		</div>
<!-- 		<div class="span__4 grid h__100v radius">
			<?= snippet('molecules/Header', ['header' => $page->hero(), 'type' => ['cover']]) ?>
		</div> -->
	</div>
	<?= snippet('templates/globals/Testimonials/carousel', ['template' => 'about', 'width' => 6, 'theme' => 'invert', 'testimonials' => collection('AboutTestimonials')]) ?>
</section>
<?php endif ?>