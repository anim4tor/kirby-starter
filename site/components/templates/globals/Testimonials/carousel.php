<?php
	$testimonials = $testimonials ?? $page->featuredTestimonials()->toPages();
	$theme   = (!isset($theme)   || trim($theme)   === '') ? 'dark' : $theme;
	$width   = (!isset($width)   || trim($width)   === '') ? '5' : $width;
	$template   = (!isset($template)   || trim($template)   === '') ? 'index' : $template;
?>	

<div class="testimonials" theme="<?= $theme ?>">
	<div class="testimonials__carousel innex-x__1 inner-y__2">
		<div class="carsousel__track flex align__center gap__1">
			<div class="carousel__group flex align__center gap__1">
				<?php foreach ($testimonials as $testimonial) : ?>
					<?php if($testimonial->testimonialQuote()->isNotEmpty()) : ?>
					<div data-scroll class="carousel__item vw__<?= $width ?>">
						<?= snippet('molecules/Testimonial/' . $template, compact('testimonial')) ?>
					</div>
					<?php endif; ?>
				<?php endforeach ?>
			</div>
			<div class="carousel__group flex align__center gap__1" aria-hidden="true">
				<?php foreach ($testimonials as $testimonial) : ?>
					<?php if($testimonial->testimonialQuote()->isNotEmpty()) : ?>
					<div data-scroll class="carousel__item vw__<?= $width ?>">
						<?= snippet('molecules/Testimonial/' . $template, compact('testimonial')) ?>
					</div>
					<?php endif; ?>
				<?php endforeach ?>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", () => {
	    const slider = document.querySelector(".testimonials__carousel");
	    const track = document.querySelector(".carsousel__track");

	    let isDown = false;
	    let startX;
	    let startProgress = 0;
	    
	    let lastX = 0;
	    let lastTime = 0;
	    let velocity = 0;

	    const groupWidth = track.scrollWidth / 2;
	    const duration = 25;

	    let autoPlayTween = gsap.to(track, {
	        x: `-=${groupWidth}`,
	        duration: duration,
	        ease: "none",
	        repeat: -1,
	        modifiers: {
	            x: gsap.utils.unitize(x => parseFloat(x) % groupWidth)
	        }
	    });

	    const pointerDown = (e) => {
	        isDown = true;
	        slider.classList.add("is-dragging");
	        
	        gsap.killTweensOf(autoPlayTween);
	        autoPlayTween.pause();

	        startX = e.type.includes("mouse") ? e.pageX : e.touches[0].clientX;
	        startProgress = autoPlayTween.time();
	        
	        lastX = startX;
	        lastTime = performance.now();
	        velocity = 0;
	        inertia = 2;
	    };

	    const pointerMove = (e) => {
	        if (!isDown) return;
	        e.preventDefault();

	        const x = e.type.includes("mouse") ? e.pageX : e.touches[0].clientX;
	        const now = performance.now();
	        
	        const dt = now - lastTime;
	        if (dt > 0) {
	            velocity = (x - lastX) / dt;
	        }
	        
	        lastX = x;
	        lastTime = now;

	        const walk = (x - startX) * 1.2;
	        let timeChange = (-walk / groupWidth) * duration;
	        let newTime = (startProgress + timeChange) % duration;
	        if (newTime < 0) newTime += duration;

	        autoPlayTween.time(newTime);
	    };

	    const pointerUp = () => {
	        if (!isDown) return;
	        isDown = false;
	        slider.classList.remove("is-dragging");

	        // Reduced momentum (changed from 150 to 40 for a lighter throw)
	        let momentumTimeChange = -velocity * inertia; 
	        let targetTime = autoPlayTween.time() + momentumTimeChange;

	        gsap.to(autoPlayTween, {
	            time: targetTime,
	            duration: 0.8, // Shorter glide duration (was 1.2)
	            ease: "power2.out",
	            modifiers: {
	                time: gsap.utils.wrap(0, duration)
	            },
	            onComplete: () => {
	                autoPlayTween.play();
	            }
	        });
	    };

	    slider.addEventListener("mousedown", pointerDown);
	    slider.addEventListener("mousemove", pointerMove);
	    slider.addEventListener("mouseup", pointerUp);

	    slider.addEventListener("touchstart", pointerDown, { passive: true });
	    slider.addEventListener("touchmove", pointerMove, { passive: false });
	    slider.addEventListener("touchend", pointerUp);
	});
</script>