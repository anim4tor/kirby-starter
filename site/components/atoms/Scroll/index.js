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
            content: document.documentElement,
            orientation: 'vertical',
            smoothWheel: true,
            smoothTouch: false,
            syncTouch: false,
            duration: 1.2,
            easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
            normalizeWheel: true,
            autoResize: true,
        });

        // Ensure engine is running
        this.engine.start();

        // Event listener for onScroll
        this.engine.on('scroll', (e) => this.onScroll(e));

        // RAF loop for smooth scroll
        const raf = (time) => {
            if (this.engine) {
                this.engine.raf(time);
            }
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
        if (this.engine) this.engine.resize();
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
                if (fab) fab.setAttribute('collapsed', 'true');
            }
            // Hide at 200px
            if (e.scroll > 200) {
                header.setAttribute('hide', 'true');
                if (fab) fab.setAttribute('hide', 'true');
            }
            
        // 2. Only update when actively moving UP
        } else if (e.direction === -1) {
            document.documentElement.setAttribute('data-scroll-direction', 'up');
            
            // Reveal header immediately when scrolling up
            header.removeAttribute('hide');
            if (fab) fab.removeAttribute('hide');
            
            // Expand header back to normal only when close to the top (under 100px)
            if (e.scroll < 100) {
                header.removeAttribute('collapsed');
                if (fab) fab.removeAttribute('collapsed');
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
    window.SCROLL = new Scroll(document.documentElement);
    SCROLL = window.SCROLL;
    window.initScroll = initScroll;
}