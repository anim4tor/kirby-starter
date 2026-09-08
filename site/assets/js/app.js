// Vendor libraries
import './vendor/lenis.min.js';
import './vendor/splitting.min.js';
import './vendor/gsap.min.js';

// Component scripts
import '../../components/atoms/Scroll/index.js';
import '../../components/atoms/Reveal/index.js';
import '../../components/organisms/Tabs/index.js';
import '../../components/organisms/Aside/index.js';
import '../../components/organisms/Loader/index.js';
import '../../components/organisms/Header/index.js';
import '../../components/organisms/Carousel/index.js';
import '../../components/organisms/Modal/index.js';
import '../../components/templates/Home/index.js';

// Reliable & Modern Device Detection
const isMobile = window.matchMedia("(max-width: 768px)").matches || 
                 ('ontouchstart' in window) || 
                 (navigator.maxTouchPoints > 0);

const isWindow = navigator.platform.toUpperCase().indexOf('WIN') > -1;

window.addEventListener('popstate', () => {
    // 1. Apply the transition attribute
    document.documentElement.setAttribute('data-transition-out', 'true');

    // 2. We don't need to manually change window.location 
    // because popstate is triggered by the browser's own history movement.
    
    // Note: If your site has a long "loading" or "transition" time, 
    // you might want to clear the attribute after a timeout or 
    // leave it until the next page load.
});
document.addEventListener('click', (e) => {
    // FIX: If the user clicked inside a dragged component layout area, cancel transitions immediately
    if (e.target.closest('.is-dragged') || e.target.closest('[data-carousel-scroll]')?.classList.contains('is-dragged')) {
        e.preventDefault();
        e.stopImmediatePropagation();
        return;
    }

    const link = e.target.closest('a');
    
    // Ignoruj, pokud to není validní odkaz nebo má specifické odkazové datasety
    if (!link || link.target === '_blank' || link.dataset.asyncTab || link.dataset.tabPrev) return;

    const url = new URL(link.href, window.location.origin);
    const isInternal = url.hostname === window.location.hostname;
    const isSpecialClick = e.metaKey || e.ctrlKey || e.shiftKey || e.which === 2; // Middle click

    // --- STRATEGIC FIX: DETECT SAME-PAGE ANCHORS FIRST ---
    if (isInternal && (link.hasAttribute('data-scroll-to') || link.hash !== '')) {
        if (url.pathname === window.location.pathname) {
            
            // Získej čisté ID cíle (např. "#opened-positions")
            const targetSelector = link.hash || link.getAttribute('data-scroll-to') || link.getAttribute('href');
            if (targetSelector && targetSelector.startsWith('#')) {
                const targetElement = document.querySelector(targetSelector);
                console.log(targetSelector)

                if (targetElement) {
                    // STOP EVERYTHING IMMEDIATELY — No transitions allowed for local IDs
                    e.preventDefault();
                    e.stopImmediatePropagation();

                    // Aktualizujeme URL hash v adresním řádku bez reloadu
                    history.pushState(null, null, targetSelector);

                    // Bezpečné vyhledání SCROLL enginu (i kdyby se inicializoval se zpožděním)
                    const scrollInstance = window.SCROLL || (typeof SCROLL !== 'undefined' ? SCROLL : null);

                    if (scrollInstance && typeof scrollInstance.scrollTo === 'function') {
                        scrollInstance.scrollTo(targetElement, {
                            offset: 0,
                            duration: 1.2
                        });
                    } else {
                        // Fallback, pokud se Lenis ještě nestihl plně načíst do window scope
                        targetElement.scrollIntoView({ behavior: 'smooth' });
                    }

                    return; // Zastaví zbytek kódu, data-transition-out se NIKDY nespustí
                }
            }
        }
    }
    // ------------------------------------

    // --- PAGE TRANSITIONS FOR DIFFERENT PAGES ---
    if (isInternal && !isSpecialClick) {
        // Double-check: Pokud je to stejná cesta a má hash, vyskoč (ochrana)
        if (url.pathname === window.location.pathname && url.hash !== '') return;
        
        e.preventDefault();
        
        document.documentElement.setAttribute('data-transition-out', 'true');

        setTimeout(() => {
            window.location.href = link.href;
        }, 800);
    }
}, true); // "true" zachytí kliknutí dříve než jakýkoliv jiný skript na webu

window.addEventListener('pageshow', (event) => {
    // event.persisted triggers if the page was restored from the browser's bfcache (Back-Forward Cache)
    // The performance check acts as a reliable fallback for classic history steps
    const isBackForward = event.persisted || 
                          (window.performance && window.performance.getEntriesByType("navigation")[0]?.type === 'back_forward') ||
                          (window.performance && window.performance.navigation?.type === 2); // Legacy fallback

    if (isBackForward) {
        // Force-remove all attributes that hide components or show loaders
        document.documentElement.removeAttribute('data-loading');
        document.documentElement.removeAttribute('data-transition-out');
        
        // Re-apply the initial entry transition state so the elements can fade back in naturally
        document.documentElement.setAttribute('data-transition', 'true');

        // Safety check: Restart the Lenis scroll engine if it was stopped when leaving the page
        if (window.SCROLL && typeof window.SCROLL.start === 'function') {
            window.SCROLL.start();
        }

        console.log('Page restored from back/forward history. Loader cleared.');
    }
});

// 1. Definuj init jako běžnou (async) funkci
const init = async () => {
    console.log('Init components...');

    const components = [];
    if (typeof initScroll === 'function') components.push(initScroll);
    if (typeof initReveals === 'function') components.push(initReveals);
    if (typeof initNavbar === 'function') components.push(initNavbar);
    if (typeof initAside === 'function') components.push(initAside);
    if (typeof initTabs === 'function') components.push(initTabs);
    if (typeof initCarousels === 'function') components.push(initCarousels);
    if (typeof initModals === 'function') components.push(initModals);
    
    // Spustíme komponenty (await počká na ty, které vrací Promise)
    try {
        await Promise.all(components.map(fn => fn()));
    } catch (e) {
        console.warn('Component init error:', e);
    }

    // 2. Aktivujeme Reveal engine těsně předtím, než zmizí loader
    if (typeof REVEAL !== 'undefined' && REVEAL && typeof REVEAL.enable === 'function') {
        REVEAL.enable(); 
    }

    // 3. Sequence transition classes pro odhalení obsahu
    requestAnimationFrame(() => {
        document.documentElement.setAttribute('data-transition', 'true');
        
        setTimeout(() => {
            document.documentElement.removeAttribute('data-loading');
            console.log('App fully initialized.');

            if (window.SCROLL) {
                if (typeof window.SCROLL.start === 'function') window.SCROLL.start();
                if (typeof window.SCROLL.resize === 'function') window.SCROLL.resize();
            }
            if (window.REVEAL && typeof window.REVEAL.refresh === 'function') {
                window.REVEAL.refresh();
            }
        }, 300);
    });
};

// 2. Tvůj stávající startApp zůstává téměř beze změny
const startApp = async () => {
    document.documentElement.setAttribute('data-loading', 'true');

    const PAGE = new Promise((resolve) => {
        const timer = setTimeout(() => {
            resolve();
        }, 2000);

        const loader = new Loader(
            (percent) => {
                const el = document.querySelector('[data-loader]');
                if (el) el.style.setProperty('--progress', percent);
            },
            () => {
                clearTimeout(timer);
                resolve();
            }
        );
        loader.init();
    });

    try {
        await PAGE;
    } catch (err) {
        console.warn("Preload failed, initializing anyway", err);
    }
    
    // Tady zavoláš inicializaci komponent
    await init();    
};

// Start the engine
document.addEventListener('DOMContentLoaded', async () => {
  startApp();
});
