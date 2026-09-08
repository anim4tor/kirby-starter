<div class="loader grid" data-loader data-scroll>
	<div data-loader-bg class="">
		<?php for ($i=0; $i < 1; $i++) : ?>
			<div style="--index: <?= $i ?>"></div>
		<?php endfor; ?>
	</div>
	<div class="grid place__center-center color__text inner__1 ">
		<div data-loader-logo class="grid__stack wrap__05">
			<?= svg('public/assets/images/fig_logo.svg') ?>
		</div>
		<!-- <p class="upper color__invert op__5 no__overflow"><span data-counter>0%</span></p> -->
	</div>
	<!-- <div class="loader__bar grid align__end gap__05 absolute inset__bottom-stretch inner__1">
		<div class="font__size__2 flex justify__end align__center ff__heading"><span data-counter>0%</span></div>
		<div class="bar border__bottom" data-progress></div>
	</div> -->
</div>