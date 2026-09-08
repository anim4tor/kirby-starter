<?php
	$theme   = (!isset($theme)   || trim($theme)   === '') ? 'invert' : $theme;
?>

<?php if (collection('Process')->isNotEmpty()) : ?>
<section class="process" <?= $theme ? 'theme="'.$theme.'"' : null ?> >
	<div class="relative grid gap__2 inner-x__1 inner-y__2">
		<div class="" data-scroll>
			<h2 class="flex justify__space-between" data-reveal-text><span>The</span><span>Process</span></h2>
		</div>
	</div>
	<div >
		<div class="grid__3 gap__2 inner__1 inner-b__5" >
			<div></div>
			<ol class="grid gap__2 place__center-center" >	
			<?php foreach (collection('Process') as $step) : ?>
				<a href="" class="grid place__center-center gap__05 inner-b__1" data-scroll data-scroll-progress data-scroll-ignore data-hoverable >
					<div class="flex align__start gap__02 inner-y__02 no__wrap" data-scroll>
						<h3 data-reveal-text><?= $step->label() ?></h3>
						<div data-reveal-text="" class="-wrap-t__03" data-split-ignore style="--in-delay: 800ms">(<?= $step->step() ?>)</div>
					</div>
					<?php if ($img = $step->figure()->toFile()) : ?>
						<div class="item__figure img__radius"><?= snippet('atoms/Image', ['img' => $img, 'parallax' => 2, 'reveal' => false, 'css' => 'vh__8 vw__8']) ?></div>
					<?php endif ?>
					<p class="font__size__small text__center" data-hover-reveal data-split-ignore data-reveal-text="words"><?= $step->detail()->inline() ?></p>
				</a>
			<?php endforeach ?>
			</ol>
			<div></div>
		</div>
	
	</div>
	<!-- <div class=vh__15></div> -->
</section>
<?php endif ?>