<section id="showroomy" class="contact-showrooms" theme="dark">
	<div class="grid gap__2 inner__1 inner-y__3">
		<div class="flex justify__space-between align__end border__top inner-t__1" data-scroll>
			<div class="grid gap__02">
				<span class="upper op__4 font__size__small" data-reveal-text>Kde nás najdete</span>
				<h2 data-reveal-text>Showroomy a Sídlo</h2>
			</div>
			<p class="op__5 font__size__small mobile:hidden" data-reveal-text>Zastavte se na kávu a prohlédněte si naše materiály i design naživo</p>
		</div>

		<div class="grid__2 mobile:grid__1 gap__2">
			<!-- Brno HQ & Showroom -->
			<article class="card radius bg__light/5 border__light/10 inner__2 flex flex__col justify__space-between gap__2" data-scroll>
				<div class="grid gap__1">
					<div class="flex justify__space-between align__center">
						<span class="upper op__5 bg__acc/20 color__acc inner-x__05 inner-y__02 radius font__size__small">Sídlo & Showroom</span>
						<span class="op__4 font__size__small">Morava</span>
					</div>

					<div class="grid gap__02">
						<h3>Brno — Lesná</h3>
						<p class="op__8 font-semibold">Nejedlého 373/1, 638 00 Brno-Lesná</p>
					</div>

					<p class="op__6 font__size__small">
						Centrální pracoviště U1 space design, architektonický ateliér, vzorkovna materiálů, nábytku a osvětlení.
					</p>

					<div class="grid gap__02 font__size__small op__5 inner-t__05 border__top border__light/10">
						<p>🕒 Po – Pá: 8:30 – 17:00 (nebo dle domluvy)</p>
						<p>🅿️ Parkování přímo před budovou</p>
					</div>
				</div>

				<div class="flex wrap gap__05 inner-t__1 border__top border__light/10">
					<?= snippet('atoms/Button', [
						'url'    => 'https://maps.google.com/?q=U1+s.r.o.,+Nejedl%C3%A9ho+373/1,+Brno-Lesn%C3%A1',
						'label'  => 'Navigovat na mapě',
						'icon'   => 'arrow-right',
						'theme'  => 'invert',
						'node'   => 'target="_blank" rel="noopener noreferrer"'
					]) ?>
					<?= snippet('atoms/Button', [
						'url'    => 'mailto:svacinova@u1.cz',
						'label'  => 'Napsat na recepci',
						'icon'   => false,
						'theme'  => false,
						'css'    => 'bg__light/10 hover:bg__acc color__invert'
					]) ?>
				</div>
			</article>

			<!-- Praha Showroom -->
			<article class="card radius bg__light/5 border__light/10 inner__2 flex flex__col justify__space-between gap__2" data-scroll>
				<div class="grid gap__1">
					<div class="flex justify__space-between align__center">
						<span class="upper op__5 bg__light/10 color__invert inner-x__05 inner-y__02 radius font__size__small">Showroom</span>
						<span class="op__4 font__size__small">Čechy</span>
					</div>

					<div class="grid gap__02">
						<h3>Praha — Smíchov</h3>
						<p class="op__8 font-semibold">Na Valentince 3336/4, 150 00 Praha-Smíchov</p>
					</div>

					<p class="op__6 font__size__small">
						Pražské klientské centrum, prostor pro konzultace projektů, výběr povrchů a prezentační zóna.
					</p>

					<div class="grid gap__02 font__size__small op__5 inner-t__05 border__top border__light/10">
						<p>🕒 Otevřeno po předchozí domluvě</p>
						<p>🚇 Výborná dostupnost z metra B (Anděl / Smíchovské nádraží)</p>
					</div>
				</div>

				<div class="flex wrap gap__05 inner-t__1 border__top border__light/10">
					<?= snippet('atoms/Button', [
						'url'    => 'https://maps.google.com/?q=Na+Valentince+3336/4,+Praha-Sm%C3%ADchov',
						'label'  => 'Navigovat na mapě',
						'icon'   => 'arrow-right',
						'theme'  => 'invert',
						'node'   => 'target="_blank" rel="noopener noreferrer"'
					]) ?>
					<?= snippet('atoms/Button', [
						'url'    => 'mailto:sales@u1.cz',
						'label'  => 'Domluvit schůzku',
						'icon'   => false,
						'theme'  => false,
						'css'    => 'bg__light/10 hover:bg__acc color__invert'
					]) ?>
				</div>
			</article>
		</div>
	</div>
</section>
