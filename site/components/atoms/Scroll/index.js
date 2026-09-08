class Scroll {
    constructor(container) {
        this.engine = null;
        this.container = container;
        this.init();
    }

    init() {
        console.log(' ... init Smooth scrolling')
        
        // Lenis initialization
        this.engine = new Lenis({
            wrapper: window,
            content: document.querySelector('[data-scroll-content]'),
            orientation: 'vertical',
            smoothWheel: true,
            smoothTouch: false,
            lerp: 0.5,
            duration: 1,
            normalizeWheel: true,
        });

        // Event listener for onScroll
        this.engine.on('scroll', (e) => this.onScroll(e));

        // RAF loop for smooth scroll
        const raf = (time) => {
            this.engine.raf(time);
            requestAnimationFrame(raf);
        };
        requestAnimationFrame(raf);
    }

    destroy() {
        if (this.engine) {
            this.engine.destroy();
            this.engine = null;
        }
    }

    stop() {
        if (this.engine) this.engine.stop();
    }

    start() {
        if (this.engine) this.engine.start();
    }

    resize() {
        if (this.engine) this.engine.dimensions.resize();
    }

    onScroll(e) {
        // e.direction can be: 1 (down), -1 (up), or 0 (stopped)
        const header = document.querySelector('[data-header]');
        const fab = document.querySelector('[fab]');
        
        if (!header) return;

        // 1. Only update when actively moving DOWN
        if (e.direction === 1) {
            document.documentElement.setAttribute('data-scroll-direction', 'down');
            
            // Collapse at 100px
            if (e.scroll > 100) {
                header.setAttribute('collapsed', 'true');
                fab.setAttribute('collapsed', 'true');
            }
            // Hide at 200px
            if (e.scroll > 200) {
                header.setAttribute('hide', 'true');
                fab.setAttribute('hide', 'true');
            }
            
        // 2. Only update when actively moving UP
        } else if (e.direction === -1) {
            document.documentElement.setAttribute('data-scroll-direction', 'up');
            
            // Reveal header immediately when scrolling up
            header.removeAttribute('hide');
            fab.removeAttribute('hide');
            
            // Expand header back to normal only when close to the top (under 100px)
            if (e.scroll < 100) {
                header.removeAttribute('collapsed');
                fab.removeAttribute('collapsed');
            }
        }
        // If e.direction is 0 (stopped), it safely does nothing, preserving the header's state.
    }

    scrollTo(target, options = {}) {
        if (this.engine) this.engine.scrollTo(target, options);
    }
}

// Initialization
var SCROLL;
function initScroll() {
    window.SCROLL = new Scroll(document.querySelector('[data-scroll-container]'));
    SCROLL = window.SCROLL; // Keeps your local variable working too
}