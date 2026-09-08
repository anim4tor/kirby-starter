class Carousel {
    constructor(el) {
        if (!el) return;

        this.carousel = el;
        
        this.DOM = {
            navNext: Array.from(this.carousel.querySelectorAll('[data-carousel-next]')),
            navPrev: Array.from(this.carousel.querySelectorAll('[data-carousel-prev]')),
            // NOVÝ ELEMENT: Detektor dragování a klikání
            scrollArea: this.carousel.querySelector('[data-carousel-scroll]'),
            panes: this.carousel.querySelector('[data-carousel-slides]'),
            items: this.carousel.querySelector('[data-carousel-slides]') 
                ? Array.from(this.carousel.querySelector('[data-carousel-slides]').querySelectorAll('[data-slide]')) 
                : [],
            tabs: Array.from(this.carousel.querySelectorAll('[data-carousel-tab]'))
        };

        // Pokud nemáme klíčové elementy, končíme
        if (this.DOM.items.length === 0 || !this.DOM.scrollArea || !this.DOM.panes) return;

        this.active = 0;
        this.perPage = this.carousel.getAttribute('data-per-page') ? parseInt(this.carousel.getAttribute('data-per-page'), 10) : 1;
        this.dynamic = this.carousel.hasAttribute('dynamic');
        
        // Rozměry a mezery
        this.itemSizeWithGap = 0; 
        this.maxScroll = 0;
        this.currentX = 0; 

        // Drag & Touch vnitřní stav
        this.isPressed = false;
        this.isDragged = false;
        
        this.touch = {
            start: 0,
            dragStartOffset: 0,
            distance: 0,
            lastX: 0,
            lastTime: 0,
            velocity: 0
        };

        // Konfigurace citlivosti
        this.config = {
            flickMinSpeed: 0.6, 
            mediumSwipeRatio: 0.4,
            longSwipeRatio: 1.2,
            slowDragThreshold: 40,
            durationNormal: 0.45,
            durationMaxFlick: 0.75
        };

        this.init();
    }

    init() {
        console.log('... init Carousel widget with dedicated scroll area');
        this.resize();
        this.initEvents();
        this.change(this.active, 0); 
    }

    resize() {
        const firstItem = this.DOM.items[0];
        const computedStyle = window.getComputedStyle(firstItem);
        const parentStyle = window.getComputedStyle(this.DOM.panes);
        
        const itemWidth = firstItem.offsetWidth;
        const marginRight = parseFloat(computedStyle.marginRight) || 0;
        const columnGap = parseFloat(parentStyle.columnGap) || 0;
        const gap = marginRight || columnGap;

        this.itemSizeWithGap = itemWidth + gap;
        
        const paddingRight = parseFloat(parentStyle.paddingRight) || 0;
        const totalSlidesWidth = this.DOM.panes.scrollWidth;
        const carouselVisibleWidth = this.carousel.offsetWidth;
        
        this.maxScroll = Math.max(0, (totalSlidesWidth + paddingRight) - carouselVisibleWidth);
        
        if (this.active * this.itemSizeWithGap > this.maxScroll) {
            this.active = Math.max(0, Math.round(this.maxScroll / this.itemSizeWithGap));
        }
        
        this.change(this.active, 0);
    }

    initEvents() {
        window.addEventListener('resize', () => this.resize());

        this.DOM.navNext.forEach(el => el.addEventListener('click', e => this.next(e)));
        this.DOM.navPrev.forEach(el => el.addEventListener('click', e => this.prev(e)));

        this.DOM.tabs.forEach((tab, index) => {
            tab.addEventListener('click', (e) => {
                e.preventDefault();
                this.active = index;
                this.change(this.active);
            });
        });

        // 🎯 START eventů navazujeme čistě na data-carousel-scroll element
        this.DOM.scrollArea.addEventListener('mousedown', e => this.grab(e));
        this.DOM.scrollArea.addEventListener('touchstart', e => this.grab(e), { passive: true });

        // POHYB a RELEASE hlídá window (pro bezchybné dokončení pohybu i mimo element)
        window.addEventListener('mousemove', e => this.drag(e));
        window.addEventListener('mouseup', e => this.release(e));
        
        window.addEventListener('touchmove', e => this.drag(e), { passive: false });
        window.addEventListener('touchend', e => this.release(e));

        // Prevence prokliků navázaná na novou scrollArea
        this.DOM.scrollArea.addEventListener('click', (e) => {
            if (this.isDragged) {
                e.preventDefault();
                e.stopPropagation();
            }
        }, true);
    }

    next(e) {
        if (e) e.preventDefault();
        const maxIndex = Math.ceil(this.maxScroll / this.itemSizeWithGap);
        if (this.active < maxIndex) {
            this.active++;
            this.change(this.active);
        } else {
            this.bounceBack();
        }
    }

    prev(e) {
        if (e) e.preventDefault();
        if (this.active > 0) {
            this.active--;
            this.change(this.active);
        } else {
            this.bounceBack();
        }
    }

    change(index, duration = 0.6) {
        const maxIndex = Math.ceil(this.maxScroll / this.itemSizeWithGap);
        
        this.active = Math.max(0, Math.min(index, maxIndex));
        let targetX = this.itemSizeWithGap * this.active;
        
        if (targetX > this.maxScroll) {
            targetX = this.maxScroll;
            this.active = Math.round(this.maxScroll / this.itemSizeWithGap);
        }

        this.currentX = targetX;

        // Animujeme vnitřní seznam (panes), zatímco scrollArea drží eventy pozicované v HTML layoutu
        gsap.to(this.DOM.panes, {
            x: -this.currentX,
            duration: duration,
            ease: 'power3.out',
            overwrite: 'auto',
            onComplete: () => {
                // Třídy is-dragged odstraňujeme z obou elementů až po úplném zastavení
                this.DOM.panes.classList.remove('is-dragged');
                this.isDragged = false;
            }
        });

        this.DOM.items.forEach((el, i) => {
            if (i === this.active) {
                el.setAttribute('data-active', 'true');
            } else {
                el.removeAttribute('data-active');
            }
        });

        this.DOM.tabs.forEach((tab, i) => {
            if (i === this.active) {
                tab.classList.add('is-active');
            } else {
                tab.classList.remove('is-active');
            }
        });

        if (this.dynamic && this.DOM.items[this.active]) {
            const newHeight = this.DOM.items[this.active].getBoundingClientRect().height;
            gsap.to(this.DOM.panes, { height: newHeight, duration: 0.3, ease: 'power2.out' });
        }

        this.carousel.style.setProperty('--active', this.active);
    }

    grab(e) {
        this.isPressed = true;
        
        const clientX = e.touches ? e.touches[0].clientX : e.clientX;
        
        this.touch.start = clientX;
        this.touch.lastX = clientX;
        this.touch.dragStartOffset = this.currentX;
        this.touch.lastTime = performance.now();
        this.touch.velocity = 0;

        gsap.killTweensOf(this.DOM.panes);
    }

    drag(e) {
        if (!this.isPressed) return;

        const currentClientX = e.touches ? e.touches[0].clientX : e.clientX;
        this.touch.distance = currentClientX - this.touch.start;

        if (Math.abs(this.touch.distance) > 5) {
            this.isDragged = true;
            // Třídu is-dragged přidáváme pro oba elementy
            this.DOM.scrollArea.classList.add('is-dragged');
            this.DOM.panes.classList.add('is-dragged');
            
            let newX = this.touch.dragStartOffset - this.touch.distance;

            const now = performance.now();
            const elapsed = now - this.touch.lastTime;
            
            if (elapsed > 0) {
                const deltaX = currentClientX - this.touch.lastX;
                this.touch.velocity = deltaX / elapsed; 
            }
            
            this.touch.lastX = currentClientX;
            this.touch.lastTime = now;

            if (newX < 0) {
                newX = newX * 0.25; 
            } else if (newX > this.maxScroll) {
                newX = this.maxScroll + (newX - this.maxScroll) * 0.25; 
            }

            gsap.set(this.DOM.panes, { x: -newX });
        }
    }

    release(e) {
        if (!this.isPressed) return;
        
        this.isPressed = false;

        const maxIndex = Math.ceil(this.maxScroll / this.itemSizeWithGap);

        if (this.isDragged) {
            const speed = Math.abs(this.touch.velocity);
            const distanceAbs = Math.abs(this.touch.distance);
            
            const mediumLimit = this.itemSizeWithGap * this.config.mediumSwipeRatio;
            const longLimit = this.itemSizeWithGap * this.config.longSwipeRatio;

            if (speed > this.config.flickMinSpeed) {
                const direction = Math.sign(this.touch.distance);
                
                if (distanceAbs > longLimit) {
                    this.active = this.active - (3 * direction);
                }
                else if (distanceAbs > mediumLimit) {
                    this.active = this.active - (2 * direction);
                } 
                else {
                    this.active = this.active - (1 * direction);
                }

                const dynamicDuration = Math.min(this.config.durationMaxFlick, Math.max(this.config.durationNormal, 1 / speed));
                this.change(this.active, dynamicDuration);

            } else {
                if (distanceAbs > this.config.slowDragThreshold) {
                    const currentPhysicalX = this.touch.dragStartOffset - this.touch.distance;
                    let targetIndex = Math.round(currentPhysicalX / this.itemSizeWithGap);
                    
                    this.change(targetIndex, this.config.durationNormal);
                } else {
                    this.bounceBack();
                }
            }
            
            this.DOM.scrollArea.classList.remove('is-dragged');

            // --- FIXED: Keep isDragged active slightly longer to suppress subsequent clicks ---
            setTimeout(() => {
                this.isDragged = false;
            }, 100); // 100ms guarantees coverage over the click frame loop
        } else {
            this.isDragged = false;
        }
        
        this.touch.distance = 0;
        this.touch.velocity = 0;
    }

    bounceBack() {
        this.change(this.active, this.config.durationNormal);
    }
}

// Inicializace
function initCarousels() {
    document.querySelectorAll('[data-carousel]').forEach(el => new Carousel(el));
}
// document.addEventListener('DOMContentLoaded', initCarousels);