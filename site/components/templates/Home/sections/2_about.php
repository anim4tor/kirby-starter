<?php if ($page->about()->isNotEmpty()) : ?>
<section class="about" theme="invert">
	<div class="grid__3 gap__2 mobile:grid__1 inner__1 inner-x__1 mobile:inner-x__1 inner-y__2">
		<div class="span__2 grid place__start-start gap__3 mobile:inner-x__0">
			<?= snippet('molecules/Header', ['header' => $page->about(), 'type' => ['heading']]) ?>
		</div>
		<div></div>
		<!-- <div></div>
		<?php if ($fig = $page->introFigure()->toFile()) : ?>
			<div class="grid h__20" >
				<?= snippet('molecules/Header', ['header' => $page->about(), 'type' => ['image']]) ?>
			</div>
		<?php endif ?>
		<div class="grid place__start-end"><?= snippet('molecules/Header', ['header' => $page->about(), 'type' => ['label']]) ?></div>
		<div></div>
		<div class="grid place__center-start gap__3">
			<?= snippet('molecules/Header', ['header' => $page->about(), 'type' => ['text']]) ?>
		</div>
		<div></div> -->
		<div></div>
		
		<?= snippet('templates/globals/Figures') ?>
	</div>
</section>
<?php endif ?>