<div class="grid place__start-stretch radius " theme="dark" data-contact-widget>
	<div data-tabs="contact" class="relative grid place__end-stretch " data-fluid>	
		<div class="flex sticky top__0 gap__03 inner-x__1 inner-y__06 border__bottom z__10" theme="dark">
			<div class="absolute top__03 right__03 z__1">
				<?= snippet('atoms/Button', [ 'url' => '', 'label' => false, 'icon' => 'close', 'theme' => false, 'css' => 'circle --small bg__light/20 color__invert/80', 'node' => 'data-contact-close']) ?>
			</div>
			<div data-tab="contact" class="upper font__size__small">HR manager</div>
			<div data-tab="inquiry" class="upper font__size__small">Inquiry</div>
		</div>
		
		<div data-pane-container class="grid__stack place__start-stretch no__overflow">

			<div data-pane="contact">
				<div class="z__1 grid wrap gap__05 inner-x__1 inner-y__1 inner-b__05">
					<h3>Máš o pozici zájem? <span class="color__acc">Just say it!</span></h3>
					<div class="flex gap__02">
						<?= snippet('atoms/Button', [ 'url' => false, 'label' => 'Mám zájem', 'icon' => false, 'theme' => 'invert', 'node' => 'data-tab=inquiry']) ?>
						<?= snippet('atoms/Button', [ 'url' => page('Career')->url().'#opened-positions', 'label' => 'Zpět na Volné pozice', 'icon' => false, 'theme' => 'invert-ghost', 'node' => 'data-contact-close']) ?>
					</div>
				</div>
				<div class="relative grid place__center-center -wrap-b__3 inner-x__2"><?= snippet('atoms/Image', ['url' => 'contact_hr.jpg', 'css' => '']) ?></div>
				<div class="relative grid gap__05 place__end-stretch inner-x__1 inner-b__1">
					<div class="grid gap__05">
						<div>
							<p class="font__size__small op__4">HR Business partner</p>
							<p class="lower font__size__2">Jitka Burdová</p>
						</div>
						<div class="flex gap__02">
							<?= snippet('atoms/Button', [ 'url' => 'mailto: hr@u1.cz', 'label' => 'hr@u1.cz', 'icon' => false, 'theme' => false, 'css' => 'bg__light/20 color__invert/60']) ?>
							<?= snippet('atoms/Button', [ 'url' => 'tel:+402 601 088 517', 'label' => '+402 601 088 517', 'icon' => false, 'theme' => false, 'css' => 'bg__light/20 color__invert/60']) ?>
						</div>
						
					</div>
				</div>
			</div>

			<div data-pane="inquiry" style="--booking-width: 50vw">
				<?= snippet('organisms/Contact/career_form') ?>
			</div>
			<div data-pane="success" style="--booking-width: 50vw">
				<?= snippet('organisms/Contact/success') ?>
			</div>

		</div>
		
	</div>
</div>