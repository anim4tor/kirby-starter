<div class="span__2 flex justify__space-between">
	<?php foreach (page('home')->aboutFigures()->toStructure() as $figure) : ?>
		<!-- Odstraníme případné nečíselné znaky z hodnoty -->
		<?php $targetNumber = preg_replace('/[^0-9]/', '', $figure->feature()); ?>
		<div class="flex " data-scroll>
			<h2 class="font__size__1 outlined lighter carousel-counter" 
			     
			    data-target="<?= $targetNumber ?>">
				<!-- JS sem vygeneruje rotující pásy pro každou číslici -->
			</h2>
			<div class="font__size__small label" data-reveal-text><?= $figure->label() ?></div>
		</div>
	<?php endforeach ?>
</div>
<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", () => {
	    const counters = document.querySelectorAll('.carousel-counter');

	    // Inicializace struktury (pásů) hned po načtení, aby se zabránilo skákání obsahu
	    counters.forEach(counter => {
	        const targetStr = counter.getAttribute('data-target');
	        counter.innerHTML = ''; // Vyčištění původního obsahu

	        // Pro každou číslici v cílovém řetězci vytvoříme pás
	        [...targetStr].forEach(() => {
	            const ribbon = document.createElement('div');
	            ribbon.classList.add('counter-ribbon');

	            // Vygenerujeme číslice 0 až 9 uvnitř pásu
	            for (let i = 0; i < 10; i++) {
	                const digit = document.createElement('div');
	                digit.classList.add('counter-digit');
	                digit.textContent = i;
	                ribbon.appendChild(digit);
	            }

	            counter.appendChild(ribbon);
	        });
	    });

	    // Funkce, která spustí rotaci na cílové hodnoty
	    const animateCarousel = (counter) => {
	        const targetStr = counter.getAttribute('data-target');
	        const ribbons = counter.querySelectorAll('.counter-ribbon');

	        ribbons.forEach((ribbon, index) => {
	            const targetDigit = parseInt(targetStr[index], 10);
	            
	            // Posuneme pás vertikálně nahoru na základě cílové číslice
	            // Každá číslice zabírá přesně 10% výšky pásu (nebo -1em na číslici)
	            setTimeout(() => {
	                ribbon.style.transform = `translateY(-${targetDigit * 10}%)`;
	            }, index * 50); // Mírné zpoždění (stagger efekt) pro ještě lepší vizuální dojem
	        });
	    };

	    // Nastavení Intersection Observeru
	    const observerOptions = {
	        root: null,
	        threshold: 0.2
	    };

	    const observer = new IntersectionObserver((entries, observer) => {
	        entries.forEach(entry => {
	            if (entry.isIntersecting) {
	                const counter = entry.target;
	                animateCarousel(counter);
	                observer.unobserve(counter); // Animaci pustíme pouze jednou
	            }
	        });
	    }, observerOptions);

	    counters.forEach(counter => observer.observe(counter));
	});

</script>