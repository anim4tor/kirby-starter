<div class="grid gap__2 inner-x__1 inner-y__2 place__center-stretch">
	<div class="grid gap__1">
		<div class="flex gap__1 inner-y__05">
			<h3 class="wrap">Děkujeme za <span class="color__acc">vaši zprávu.</span></h3>
		</div>
		<div class="border__top inner-t__1 grid gap__1">
			<p class="lower wrap">Zpráva byla úspěšně odeslána. Brzy se vám ozveme zpět.</p>
			<p class="font__size__small op__4 wrap">Thank you! Your message has been sent successfully. We will get back to you shortly.</p>
		</div>
	</div>
	
	<div class="flex gap__05 inner-t__1">
		<?= snippet('atoms/Button', [ 'url' => '', 'label' => 'Zavřít', 'icon' => false, 'theme' => 'invert', 'node' => 'data-tab="inquiry" data-contact-close' ]) ?>
	</div>
</div>
