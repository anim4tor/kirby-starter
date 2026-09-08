<section class="intro radius" theme="invert" style="--in-delay: 300ms">
	<div class="z__1 intro__header inner-b__2 place__stretch-stretch grid__4 gap__2 mobile:grid__1 mobile:h__auto inner__1 mobile:inner-t__10 mobile:gap__2 relative">
		<div class="span__4 h__4 mobile:h__2"></div>
		
		<div class="span__4 inner-t__05 border__top grid__4 mobile:grid__1 place__space-between-stretch gap__2">
			<div class="span__3 mobile:span__1">
				<div class="grid gap__1" data-scroll>
					<h1 data-reveal-text>Kontakt</h1>
					<p class="op__7 wrap max-w__40" data-reveal-text>
						<?= $page->intro()->isNotEmpty() ? $page->intro()->html() : 'Spojte se s námi přímo nebo nám na vás zanechte kontakt. Ozveme se.' ?>
					</p>
				</div>
			</div>
			
			<div class="span__1 mobile:span__1 grid gap__05 place__start-end mobile:place__start-start" data-scroll>
				<a data-scroll-to href="#oddeleni" class="font__size__3 ff__heading op__6 hover:op__10" data-reveal-text>Oddělení ↓</a>
				<a data-scroll-to href="#formular" class="font__size__3 ff__heading op__6 hover:op__10" data-reveal-text>Napište nám ↓</a>
				<a data-scroll-to href="#showroomy" class="font__size__3 ff__heading op__6 hover:op__10" data-reveal-text>Showroomy ↓</a>
				<a data-scroll-to href="#fakturace" class="font__size__3 ff__heading op__6 hover:op__10" data-reveal-text>Fakturační údaje ↓</a>
			</div>
		</div>
	</div>
</section>
