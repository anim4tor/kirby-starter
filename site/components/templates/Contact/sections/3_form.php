<section id="formular" class="contact-form-section" theme="invert">
	<div class="grid gap__2 inner__1 inner-y__3">
		<div class="flex justify__space-between align__end border__top inner-t__1" data-scroll>
			<div class="grid gap__02">
				<span class="upper op__4 font__size__small" data-reveal-text>Zpráva</span>
				<h2 data-reveal-text>Napište nám</h2>
			</div>
			<p class="op__6 max-w__30 font__size__small" data-reveal-text>Vyplňte následující formulář a my se vám rádi co nejdříve ozveme.</p>
		</div>

		<div class="grid__3 mobile:grid__1 gap__2 items__start">
			<div class="span__1 grid gap__1" data-scroll>
				<h3 class="wrap">Máte projekt, dotaz nebo zájem o spolupráci?</h3>
				<p class="op__6">
					Ať už plánujete nové kancelářské prostory, fitout, potřebujete space plan nebo se chcete přidat k našemu týmu, neváhejte nám napsat.
				</p>
				<div class="inner-t__1 grid gap__05 font__size__small op__5">
					<p>⏱️ Odpovídáme obvykle do 24 hodin v pracovní dny.</p>
					<p>🔒 Vaše data jsou u nás v naprostém bezpečí.</p>
				</div>
			</div>

			<div class="span__2 bg__light/5 radius inner__2 mobile:inner__1 border__light/10" data-scroll>
				<form id="contact-form" action="<?= url('contact.json') ?>" method="POST" data-form="contact" class="grid gap__1">
					<!-- Category / Division Selection -->
					<div class="grid gap__05">
						<label class="upper op__5 font__size__small">Komu zprávu směrovat / Oddělení</label>
						<div class="flex wrap gap__05">
							<?php 
							$options = [
								'General'          => 'Všeobecný dotaz',
								'Sales'            => 'Obchod & Projekty',
								'Design'           => 'Design & Architektura',
								'Marketing & Media'=> 'Marketing & Média',
								'Office manager'   => 'Office manager',
								'Accountant'       => 'Účetní'
							];
							$first = true;
							foreach ($options as $val => $lbl) :
							?>
								<label class="cursor-pointer font__size__small flex align__center gap__02 bg__light/10 hover:bg__light/20 inner-x__05 inner-y__02 radius transition">
									<input type="radio" name="division" value="<?= $val ?>" <?= $first ? 'checked' : '' ?> class="accent-acc">
									<span><?= $lbl ?></span>
								</label>
							<?php 
								$first = false;
							endforeach; 
							?>
						</div>
					</div>

					<!-- Name & Company -->
					<div class="grid__2 mobile:grid__1 gap__1">
						<div class="grid gap__02">
							<label class="upper op__5 font__size__small">Jméno a příjmení *</label>
							<input type="text" name="name" required placeholder="Jan Novák" data-contact-input class="w__100 inner__05 radius bg__light/5 border__light/10 color__invert focus:border__acc">
						</div>
						<div class="grid gap__02">
							<label class="upper op__5 font__size__small">Společnost</label>
							<input type="text" name="company" placeholder="Název firmy" data-contact-input class="w__100 inner__05 radius bg__light/5 border__light/10 color__invert focus:border__acc">
						</div>
					</div>

					<!-- Email & Phone -->
					<div class="grid__2 mobile:grid__1 gap__1">
						<div class="grid gap__02">
							<label class="upper op__5 font__size__small">Email *</label>
							<input type="email" name="email" required placeholder="jan.novak@firma.cz" data-contact-input class="w__100 inner__05 radius bg__light/5 border__light/10 color__invert focus:border__acc">
						</div>
						<div class="grid gap__02">
							<label class="upper op__5 font__size__small">Telefon</label>
							<input type="tel" name="phone" placeholder="+420 123 456 789" data-contact-input class="w__100 inner__05 radius bg__light/5 border__light/10 color__invert focus:border__acc">
						</div>
					</div>

					<!-- CV / Portfolio Link (Optional) -->
					<div class="grid gap__02">
						<label class="upper op__5 font__size__small">Odkaz na web / CV / LinkedIn <span class="op__5 lowercase">(volitelné)</span></label>
						<input type="url" name="cv_link" placeholder="https://..." data-contact-input class="w__100 inner__05 radius bg__light/5 border__light/10 color__invert focus:border__acc">
					</div>

					<!-- Message -->
					<div class="grid gap__02">
						<label class="upper op__5 font__size__small">Zpráva *</label>
						<textarea name="message" required rows="4" placeholder="Popište nám svůj projekt, prostor nebo dotaz..." data-contact-input class="w__100 inner__05 radius bg__light/5 border__light/10 color__invert focus:border__acc" style="min-height: 120px;"></textarea>
					</div>

					<!-- Error Feedback Box -->
					<div data-form-feedback>
						<div data-form-error class="color__acc font__size__small font-semibold"></div>
					</div>

					<!-- Submit & GDPR -->
					<div class="grid__2 mobile:grid__1 gap__1 align__center inner-t__05 border__top border__light/10">
						<div class="flex justify__start">
							<?= snippet('atoms/Button', [
								'label' => 'Odeslat zprávu',
								'icon'  => 'arrow-right',
								'theme' => 'acc',
								'hover' => 'invert',
								'node'  => 'type="submit" data-form-submit'
							]) ?>
						</div>
						<p class="op__5 font__size__small">
							Odesláním souhlasíte se zpracováním údajů dle <a class="link underline hover:color__acc" href="<?= page('privacy') ? page('privacy')->url() : url('zasady-ochrany-osobnich-udaju') ?>" target="_blank">zásad ochrany osobních údajů</a>.
						</p>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
