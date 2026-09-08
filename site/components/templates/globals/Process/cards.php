<?php
	$theme   = (!isset($theme)   || trim($theme)   === '') ? 'invert' : $theme;
?>

<?php if (collection('Process')->isNotEmpty()) : ?>
<section class="process" <?= $theme ? 'theme="'.$theme.'"' : null ?> >
	<div class="grid place__end-stretch inner-b__0 relative" >
		
		<div class="sticky top__1 grid place__center-stretch h__100v gap__2 inner-x__1 inner-y__2">
			<div class="wrap-x__15 inner-b__3" data-scroll>
				<h2 class="font__size__1 flex justify__center text__center" data-reveal-text><span>Overview of our 5-step process</span></h2>
			</div>
		</div>

		<div class="grid sticky top__0 -wrap-t__10" data-scroll data-scroll-ignore data-scroll-progress style="--total: <?= collection('Process')->count() ?>">
		<?php foreach (collection('Process') as $step) : ?>
			<div class="card__wrapper grid place__center-center vh__20 sticky top__0" style="--index: <?= $step->step() ?> ">
				<div card class="grid gap__1 inner__1 inner-t__1 vw__5 radius" theme="light" data-scroll>
					<?php if ($img = $step->figure()->toFile()) : ?>
						<div class="item__figure grid"><?= snippet('atoms/Image', ['img' => $img, 'parallax' => 2, 'reveal' => false, 'css' => 'vh__7']) ?></div>
					<?php endif ?>
					<div class="grid gap__2 place__space-between-stretch">
						<div class="grid align__start no__wrap">
							<!-- <div class="font__size__1" data-reveal-text><?= $step->step() ?></div> -->
							<h3 class=" flex justify__start gap__1" data-reveal-text data-split-ignore>(<?= $step->step() ?>) <?= $step->label() ?></h3>
						</div>
						<div class="grid">
							<p class="span__2" data-reveal="simple"><?= $step->detail()->inline() ?></p>
							<div></div>
						</div>
					</div>
				</div>
			</div>
		<?php endforeach ?>
		</div>
	
	</div>
	<!-- <div class=vh__15></div> -->
</section>
<?php endif ?>