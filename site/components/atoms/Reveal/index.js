class Reveal {
    constructor(selector = '[data-scroll]') {
        this.selector = selector;
        this.progressEntries = [];
        this.observer = null;
        this.vh = window.innerHeight;
        this.init();
    }

    init() {
        this.observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                const el = entry.target;
                const shouldRepeat = el.hasAttribute('data-scroll-repeat');
                const ignore = el.hasAttribute('data-scroll-ignore');
                const isProgress = el.hasAttribute('data-scroll-progress');
                const hasText = el.matches('[data-reveal-text]') || el.querySelector('[data-reveal-text]');

                if (entry.isIntersecting) {
                    if (hasText && !el.classList.contains('is-split')) {
                        this._splitText(el);
                    } else if (!ignore) {
                        el.classList.add('is-inview');
                    }

                    if (!shouldRepeat && !isProgress && !hasText) {
                        this.observer.unobserve(el);
                    }
                } else {
                    if (shouldRepeat) {
                        el.classList.remove('is-inview');
                    }
                }
            });
        }, { 
            rootMargin: '0px 0px -50px 0px', 
            threshold: 0.05 
        });

        // Cache coordinates of progress elements
        this.measureProgressElements();

        window.addEventListener('resize', () => {
            this.vh = window.innerHeight;
            this.measureProgressElements();
            this.updateProgress(window.SCROLL?.engine?.scroll ?? window.scrollY);
        }, { passive: true });

        // Connect synchronously to Lenis scroll
        if (window.SCROLL && window.SCROLL.engine) {
            window.SCROLL.engine.on('scroll', (e) => {
                this.updateProgress(e.scroll);
            });
        } else {
            window.addEventListener('scroll', () => {
                this.updateProgress(window.scrollY);
            }, { passive: true });
        }
    }

    measureProgressElements() {
        const scrollY = window.SCROLL?.engine?.scroll ?? window.scrollY ?? 0;
        this.progressEntries = Array.from(document.querySelectorAll('[data-scroll-progress]')).map(el => {
            const rect = el.getBoundingClientRect();
            return {
                el,
                top: rect.top + scrollY,
                height: rect.height
            };
        });
    }

    // Direct synchronous calculation: ZERO DOM READS during scroll!
    updateProgress(scrollY) {
        if (!this.progressEntries || this.progressEntries.length === 0) return;
        const vh = this.vh;

        for (let i = 0; i < this.progressEntries.length; i++) {
            const entry = this.progressEntries[i];
            const currentTop = entry.top - scrollY;

            // Only update elements that are visible or entering the viewport buffer
            if (currentTop < vh + 150 && currentTop > -entry.height - 150) {
                const progress = Math.max(0, Math.min(1, (vh - currentTop) / (vh + entry.height)));
                entry.el.style.setProperty('--progress', progress.toFixed(3));
            }
        }
    }

    enable() {
        document.documentElement.classList.add('reveal-enabled');
        this.refresh();
        this.measureProgressElements();
        this.updateProgress(window.SCROLL?.engine?.scroll ?? window.scrollY ?? 0);
    }

    _splitText(parentEl) {
        const targets = parentEl.matches('[data-reveal-text]') 
            ? [parentEl, ...parentEl.querySelectorAll('[data-reveal-text]')] 
            : parentEl.querySelectorAll('[data-reveal-text]');

        targets.forEach(target => {
            if (target.classList.contains('is-split')) return;

            const splitType = target.getAttribute('data-reveal-text') || 'chars';
            if (typeof Splitting === 'function') {
                Splitting({ target: target, by: splitType });
                
                target.querySelectorAll('[data-reveal-text]:not(.chars) [data-word]').forEach(item => {
                    item.innerHTML = `<span class="inner-wrap">${item.textContent}</span>`;
                });
            }
            target.classList.add('is-split');
        });

        requestAnimationFrame(() => {
            parentEl.classList.add('is-inview');
        });
    }

    initImages() {
        const checkImage = (img) => {
            if (img.complete && img.naturalWidth > 0) {
                img.classList.add('is-loaded');
            } else {
                img.addEventListener('load', () => img.classList.add('is-loaded'), { once: true });
                img.addEventListener('error', () => img.classList.add('is-loaded'), { once: true });
            }
        };
        document.querySelectorAll('figure img, img[loading]').forEach(checkImage);
    }

    refresh() {
        this.initImages();
        document.querySelectorAll(this.selector).forEach(el => this.observer.observe(el));
    }
}

var REVEAL;
function initReveals() {
    console.log(' ... init Reveal animations');
    REVEAL = new Reveal();
    REVEAL.initImages();
}


