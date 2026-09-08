<?php if ($testimonials->isNotEmpty()) : ?>
<div class="testimonials radius " theme="dark" data-carousel>
	<div class="grid__3 gap__1 mobile:grid__1 inner-y__2 inner-b__3 mobile:inner-x__1 ">
		<div class="span__3 inner-x__1">
			<div class="flex justify__space-between border__top inner-y__1">
				<div data-scroll class="span__2 ">
					<span class="upper" data-reveal-text="lines">(Testimonials)</span>
				</div>
				<div class="flex gap__02 justify__end align__end">
					<button data-carousel-prev class="button upper" theme="invert-ghost" hover="invert"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-left.svg') ?></span></button>
					<button data-carousel-next class="button upper" theme="invert-ghost" hover="invert"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-right.svg') ?></span></button>
				</div>
			</div>
		</div>
		<div class="span__3" data-carousel-scroll>
			<ol class="flex justify__start align__stretch no__wrap gap__1 inner-x__1 " data-carousel-slides >	
			<?php foreach ($testimonials as $project) : ?>
				<li data-slide class="grid vw__6">	
					<?= snippet('molecules/Testimonial', compact('project','testimonials')) ?>
				</li>
			<?php endforeach ?>
			<?php foreach ($testimonials as $project) : ?>
				<li data-slide class="grid vw__6">	
					<?= snippet('molecules/Testimonial', compact('project','testimonials')) ?>
				</li>
			<?php endforeach ?>
			</ol>
		</div>
	</div>
</div>
<?php endif ?>