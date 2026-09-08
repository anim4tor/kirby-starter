<?php if ($site->ctaContact()->isNotEmpty()) : ?>
<section class="cta radius" theme="dark" data-scroll>
	<div class="" data-contact-toggle="inquiry">
		<div class="bg radius absolute inset__stretch" >
			<!-- <?= asset('public/assets/images/cta_bg.png') ?> -->
		</div>
		<div class="relative grid__4 gap__1 mobile:grid__1 inner-x__1 inner-y__2 inner-t__5">
			<div class="span__4 flex justify__space-between align__end gap__3 color__invert">
				<div class="inner-b__0">
					<?= snippet('molecules/Header', ['header' => $site->ctaContact(), 'type' => ['heading']]) ?>
				</div>
				<div class="flex justify__end">
					<?= snippet('molecules/Header', ['header' => $site->ctaContact(), 'type' => ['button']]) ?>
				</div>
			</div>
		</div>
	</div>
</section>

<script type="text/javascript">
	let targetX = 1, targetY = 1;
	let currentX = 1, currentY = 1;
	const ease = 0.05; // Lower is slower/smoother, higher is snappier

	const element = document.querySelector('.cta');

	// Update targets on mouse move
	element.addEventListener('mousemove', (e) => {
	  const rect = element.getBoundingClientRect();
	  targetX = Math.max(0, Math.min(1, (e.clientX - rect.left) / rect.width));
	  targetY = Math.max(0, Math.min(1, (e.clientY - rect.top) / rect.height));
	});

	// Animation loop for smooth movement
	function animate() {
	  // Lerp formula: current + (target - current) * easing
	  currentX += (targetX - currentX) * ease;
	  currentY += (targetY - currentY) * ease;
	  
	  element.style.setProperty('--x', currentX);
	  element.style.setProperty('--y', currentY);
	  
	  requestAnimationFrame(animate);
	}

	animate();
</script>
<?php endif ?>
