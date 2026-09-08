<section id="theme">
	<div class="grid inner__5 ">
		<?php foreach (array_reverse([5, 4, 3, 2, 1]) as $size) { ?>
			<div class="ff__heading font__size__<?= $size ?> inner-y__2 border__bottom">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo.</div>
		<?php } ?>
		<div class="grid__2 gap-x__5 place__start-start">
			<?php foreach (array_reverse(['small', 'default', 'large']) as $size) { ?>
				<div class="ff__body font__size__<?= $size ?> inner-y__2 border__bottom">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo.</div>
			<?php } ?>
		</div>
	</div>
</section>
