<?php
$divisions = [
	[
		'name'    => 'Office manager',
		'email'   => 'svacinova@u1.cz',
		'phone'   => '+420 601 088 517',
		'phone_clean' => '+420601088517',
		'image'   => 'contact_office.jpg',
		'desc'    => 'Dotazy k provozu, zázemí a obecná komunikace'
	],
	[
		'name'    => 'Marketing a média',
		'email'   => 'marketing@u1.cz',
		'phone'   => '+420 725 020 888',
		'phone_clean' => '+420725020888',
		'image'   => 'contact_marketing.jpg',
		'desc'    => 'Tiskové zprávy, média, spolupráce a partnerství'
	],
	[
		'name'    => 'Obchod',
		'email'   => 'sales@u1.cz',
		'phone'   => null,
		'phone_clean' => null,
		'image'   => 'contact_sales.jpg',
		'desc'    => 'Poptávky nových projektů, fitoutů a realizací'
	],
	[
		'name'    => 'Design',
		'email'   => 'design@u1.cz',
		'phone'   => '+420 737 758 528',
		'phone_clean' => '+420737758528',
		'image'   => 'contact_design.jpg',
		'desc'    => 'Architektonický koncept, space planning a návrhy interiérů'
	],
	[
		'name'    => 'Účetní',
		'email'   => 'accountant@u1.cz',
		'phone'   => '+420 720 834 765',
		'phone_clean' => '+420720834765',
		'image'   => 'contact_accounts.jpg',
		'desc'    => 'Fakturace, platby a ekonomická administrativa'
	],
];
?>

<section id="oddeleni" class="contact-divisions" theme="dark">
	<div class="grid gap__2 inner__1 inner-y__3">
		<div class="flex justify__space-between align__end border__top inner-t__1" data-scroll>
			<div class="grid gap__02">
				<span class="upper op__4 font__size__small" data-reveal-text>Přímé spojení</span>
				<h2 data-reveal-text>Oddělení</h2>
			</div>
			<p class="op__5 font__size__small mobile:hidden" data-reveal-text>Spojte se přímo s konkrétním týmem</p>
		</div>

		<div class="grid__3 mobile:grid__1 gap__1">
			<?php foreach ($divisions as $div) : ?>
				<article class="card relative radius overflow__hidden flex flex__col justify__space-between gap__1 inner__1 bg__light/5 border__light/10 hover:border__acc transition" data-scroll style="min-height: 280px;">
					<!-- Background / Illustration Image -->
					<div class="absolute inset__stretch z__0 op__20 hover:op__30 transition" style="background-image: url('<?= url('public/assets/images/' . $div['image']) ?>'); background-size: cover; background-position: center; pointer-events: none;"></div>

					<div class="relative z__1 grid gap__05">
						<span class="upper op__5 font__size__small">Tým U1</span>
						<h3><?= $div['name'] ?></h3>
						<p class="op__6 font__size__small"><?= $div['desc'] ?></p>
					</div>

					<div class="relative z__1 flex wrap gap__05 inner-t__1 border__top border__light/10">
						<?php if (!empty($div['email'])) : ?>
							<?= snippet('atoms/Button', [
								'url'   => 'mailto:' . $div['email'],
								'label' => $div['email'],
								'icon'  => false,
								'theme' => false,
								'css'   => 'bg__light/10 hover:bg__acc color__invert'
							]) ?>
						<?php endif ?>

						<?php if (!empty($div['phone'])) : ?>
							<?= snippet('atoms/Button', [
								'url'   => 'tel:' . $div['phone_clean'],
								'label' => $div['phone'],
								'icon'  => false,
								'theme' => false,
								'css'   => 'bg__light/10 hover:bg__acc color__invert'
							]) ?>
						<?php endif ?>
					</div>
				</article>
			<?php endforeach ?>
		</div>
	</div>
</section>
