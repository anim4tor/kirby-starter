<?php
	$testimonials = (collection('Projects')) 
    ? collection('Projects')->filterBy('testimonialQuote', '!=', '') 
    : new Kirby\Cms\Pages();
?>
<?php if ($testimonials->isNotEmpty()) : ?>
<section class="testimonials radius" data-tabs="noinit" theme="dark">
	<div class="hidden">
		<?php foreach ($testimonials as $project) : ?>
			<div data-tab="testimonial-<?= $project->indexOf($testimonials) ?>"></div>
		<?php endforeach ?>
	</div>
	<div class="grid__stack relative">
		<div data-pane-container class="grid__stack absolute inset__stretch">
			<?php foreach ($testimonials as $project) : ?>
				<?php if ($cover = $project->cover()->toFile()) : ?>
				<div data-tab-reveal data-pane="testimonial-<?= $project->indexOf($testimonials) ?>" >
					<div class="intro__cover grid " data-reveal-cover><?= snippet('atoms/Image', ['img' => $cover, 'parallax' => 2, 'reveal' => false, 'css' => 'overlay__bottom']) ?></div>
				</div>
				<?php endif ?>
			<?php endforeach ?>
		</div>
		<div class="relative z__10 grid__3 gap__2 h__100v mobile:grid__1 inner__1 mobile:inner-x__1 inner-y__2" >
			<div data-tab-prev></div>
			<div class="grid place__center-center">
				<div data-pane-container class="grid " data-scroll data-scroll-ignore data-reveal-image>
					<div class="grid__stack inner__1 img__radius" theme="dark">
						<?php foreach ($testimonials as $project) : ?>
							<div data-pane="testimonial-<?= $project->indexOf($testimonials) ?>" class="grid" data-tab-reveal>
								<?= snippet('molecules/Testimonial/featured', compact('project','testimonials')) ?>
							</div>
						<?php endforeach ?>
					</div>
				</div>
			</div>
			<div data-tab-next></div>
		</div>
	</div>
</section>
<?php endif ?>