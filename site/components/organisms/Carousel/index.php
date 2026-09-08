<?php
	$parent = $template ?? false;
?>
<carousel class="carousel" data-carousel dynamic>
	<div class="carousel__list" data-carousel-slides>
		<?php foreach ($slides as $slide) : ?>
			<?= snippet('molecules/Slide', compact('slides','slide','parent','block')) ?>
		<?php endforeach ?>
	</div>
	<?php foreach ($navs as $nav) : ?>
		<?= snippet('molecules/Nav', [ 'items' => $slides, 'nav' => $nav ]) ?>
	<?php endforeach ?>
</carousel>
