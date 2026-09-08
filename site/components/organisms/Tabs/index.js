/**
 * Tabs Component
 * - Handles tab switching, async content loading, scroll triggers and A11y.
 * - Layering: Dynamic z-index stacking for smooth overlapping animations.
 * - Fluid Layout: Dynamically scales pane containers to match active content bounds.
 */
class Tabs {
    constructor(el) {
        if (!el) return;

        console.log('... init Tabs widgets');

        this.DOM = {
            widget: el,
            // Collect containers only if this specific widget is their immediate data-tabs parent
            containers: Array.from(el.querySelectorAll('[data-pane-container]'))
                .filter(item => item.closest('[data-tabs]') === el),

            tabs: Array.from(el.querySelectorAll('[data-tab], [data-async-tab]'))
                .filter(item => item.closest('[data-tabs]') === el),

            panes: Array.from(el.querySelectorAll('[data-pane]'))
                .filter(item => item.closest('[data-tabs]') === el),

            nav: {
                prev: Array.from(el.querySelectorAll('[data-tab-prev]')).filter(item => item.closest('[data-tabs]') === el),
                next: Array.from(el.querySelectorAll('[data-tab-next]')).filter(item => item.closest('[data-tabs]') === el)
            }
        };

        this.settings = {
            animationDuration: 1000,
            debounceDuration: 0
        };

        this.data = {
            active: 0,
            next: 0,
            cache: {}
        };

        this.zIndexCounter = 100;
        this.is_changing = false;
        this.is_scrolling_via_click = false;
        this.scroll_timeout = null;
        this.hover_timeout = null;
        this.closing_timeouts = [];
        this.scrollTriggers = [];
        this.observer = null;

        this.is_hoverable = el.getAttribute('data-tabs') === 'hoverable';
        this.is_scrollable = el.getAttribute('data-tabs') === 'scrollable';
        this.is_noinit = el.getAttribute('data-tabs') === 'noinit';
        this.is_fluid = el.hasAttribute('data-fluid'); // Detect fluid setting toggle

        this._boundHandleKeydown = this.handleKeydown.bind(this);
        this._boundScrollEvent = this.handleScrollEvent.bind(this);

        this.autoplayInterval = parseInt(el.getAttribute('data-autoplay')) || 0;
        this.autoplayTimer = null;

        // Add this at the end of the constructor
        if (this.autoplayInterval > 0) this.startAutoplay();

        this.init();
    }

    init() {

        if (this.is_fluid) this.DOM.widget.classList.add('--fluid');

        const datasetTabsValue = this.DOM.widget.dataset.tabs;

        // Handle parsing correctly if first active tab is designated string value or digit index
        if (datasetTabsValue === 'hoverable') {
            this.data.active = 0;
        } else if (datasetTabsValue && isNaN(datasetTabsValue)) {
            const parsedIndex = this.getTabIndexByPaneValue(datasetTabsValue);
            this.data.active = parsedIndex !== -1 ? parsedIndex : 0;
        } else {
            this.data.active = parseInt(datasetTabsValue) || 0;
        }

        this.setupA11y();
        this.initEvents();
        this.initScrollTriggers();

        this.updateZIndices(this.data.active);
        if (!this.is_noinit) this.setActive(this.data.active);

    }

    setupA11y() {
        const tabList = this.DOM.tabs[0]?.parentNode;
        if (tabList) tabList.setAttribute('role', 'tablist');

        this.DOM.tabs.forEach((tab, i) => {
            const paneValue = tab.dataset.tab || tab.dataset.asyncTab || i;
            const tabId = `tab-${i}`;

            tab.setAttribute('role', 'tab');
            tab.setAttribute('id', tabId);
            tab.setAttribute('aria-controls', `pane-group-${paneValue}`);
            tab.setAttribute('tabindex', '-1');
        });

        this.DOM.panes.forEach((pane) => {
            const paneValue = pane.dataset.pane;
            if (!paneValue) return;

            const tabIndex = this.getTabIndexByPaneValue(paneValue);
            const tabId = tabIndex !== -1 ? `tab-${tabIndex}` : '';

            pane.setAttribute('role', 'tabpanel');
            if (tabId) pane.setAttribute('aria-labelledby', tabId);
        });
    }

    initScrollTriggers() {
        const uniquePaneNames = [...new Set(this.DOM.panes.map(p => p.dataset.pane).filter(Boolean))];

        uniquePaneNames.forEach(paneName => {
            const trigger = document.querySelector(`[data-pane-trigger="${paneName}"]`);
            if (trigger) {
                this.scrollTriggers.push({ trigger, paneName });
            }
        });

        if (this.scrollTriggers.length === 0) return;

        // Existing Intersection Observer setup...
        const observerOptions = {
            root: null,
            rootMargin: '-20% 0px -79% 0px',
            threshold: 0
        };

        this.observer = new IntersectionObserver((entries) => {
            if (this.is_scrolling_via_click) return;

            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const paneName = entry.target.dataset.paneTrigger;
                    const index = this.getTabIndexByPaneValue(paneName);

                    if (index !== -1 && index !== this.data.active) {
                        this.setActive(index);
                    }
                }
            });
        }, observerOptions);

        this.scrollTriggers.forEach(item => this.observer.observe(item.trigger));

        // --- NEW: Scroll Progress Calculation ---
        this._boundUpdateProgress = this.updateScrollProgress.bind(this);
        window.addEventListener('scroll', this._boundUpdateProgress, { passive: true });
        this.updateScrollProgress(); // Initial check
    }

    updateScrollProgress() {
        if (this.scrollTriggers.length === 0) return;

        const firstTrigger = this.scrollTriggers[0].trigger;
        const lastTrigger = this.scrollTriggers[this.scrollTriggers.length - 1].trigger;

        // Get bounding rectangles relative to the viewport
        const firstRect = firstTrigger.getBoundingClientRect();
        const lastRect = lastTrigger.getBoundingClientRect();

        // Total distance from the top of the first trigger to the top of the last trigger
        const totalDistance = lastRect.top - firstRect.top + lastRect.height;

        if (totalDistance <= 0) {
            this.DOM.widget.style.setProperty('--progress', '0');
            return;
        }

        // Current distance scrolled from the first trigger's initial position
        // We track how far the top of the first trigger has moved above the viewport top (or a custom offset)
        const currentScroll = -firstRect.top;

        let progress = currentScroll / totalDistance;
        progress = Math.max(0, Math.min(1, progress)); // Clamp between 0 and 1

        this.DOM.widget.style.setProperty('--progress', progress.toFixed(3));
    }

    setActive(index, force = false) {
        const liveTabs = Array.from(this.DOM.widget.querySelectorAll('[data-tab], [data-async-tab]'));
        if (index < 0 || index >= liveTabs.length) return;

        const tab = liveTabs[index];
        if (tab && tab.hasAttribute('data-async-tab')) {
            const url = tab.getAttribute('href');
            if (url && !this.data.cache[url]) {
                if (this.DOM.widget.classList.contains('--loading-async')) return;
                this.loadAsync(index, url);
                return;
            }
        }

        this.data.next = index;
        this.change(force);
    }

    setActivePane(paneName) {
        if (!paneName) return;

        const panes = Array.from(this.DOM.widget.querySelectorAll('[data-pane]'))
            .filter(item => item.closest('[data-tabs]') === this.DOM.widget);

        const targetPane = panes.find(p => p.dataset.pane === paneName);
        if (!targetPane) return;

        this.activeCustomPane = paneName;

        const liveTabs = Array.from(this.DOM.widget.querySelectorAll('[data-tab], [data-async-tab]'))
            .filter(tab => tab.closest('[data-tabs]') === this.DOM.widget);

        liveTabs.forEach((tab) => {
            const tabValue = tab.dataset.tab || tab.dataset.asyncTab;
            const isActive = (tabValue === paneName);
            tab.toggleAttribute('data-active', isActive);
            tab.setAttribute('aria-selected', isActive ? 'true' : 'false');
            tab.setAttribute('tabindex', isActive ? '0' : '-1');
        });

        panes.forEach((p) => {
            const isNewPane = (p === targetPane);
            if (isNewPane) {
                p.setAttribute('data-active', 'true');
                p.classList.remove('is-closing');
            } else {
                p.removeAttribute('data-active');
            }
        });

        if (this.is_fluid) {
            this.updateFluidBounds(targetPane);
        }
    }

    change(force = false) {
        // Detekujeme, zda jde o úplně první spuštění (inicializaci)
        const isFirstInit = !this.DOM.widget.hasAttribute('data-init');

        // Pokud už init proběhl a klikáme/najíždíme na stejný tab a není aktivní custom pane ani force, nic nedělej
        if (this.data.active === this.data.next && !isFirstInit && !this.activeCustomPane && !force) return;

        this.activeCustomPane = null;

        // Nastavíme příznak inicializace
        this.DOM.widget.setAttribute('data-init', 'true');

        // ONLY grab live tabs that directly belong to THIS component level
        const liveTabs = Array.from(this.DOM.widget.querySelectorAll('[data-tab], [data-async-tab]'))
            .filter(tab => tab.closest('[data-tabs]') === this.DOM.widget);

        const activeTab = liveTabs[this.data.next] || this.DOM.tabs[this.data.next];
        const activePaneValue = activeTab ? (activeTab.dataset.tab || activeTab.dataset.asyncTab || String(this.data.next)) : null;

        this.updateZIndices(activePaneValue);

        // This updates ONLY the parent level tabs safely
        liveTabs.forEach((tab) => {
            const tabValue = tab.dataset.tab || tab.dataset.asyncTab;
            const isActive = (tabValue === activePaneValue);

            tab.toggleAttribute('data-active', isActive);
            tab.setAttribute('aria-selected', isActive ? 'true' : 'false');
            tab.setAttribute('tabindex', isActive ? '0' : '-1');
        });

        let targetActivePane = null;

        // Updates ONLY parent level content panes
        this.DOM.panes.forEach((p, i) => {
            const isNewPane = p.dataset.pane ? (p.dataset.pane === activePaneValue) : (i === this.data.next);

            if (isNewPane) {
                p.setAttribute('data-active', 'true');
                p.classList.remove('is-closing');
                targetActivePane = p;
            } else {
                p.removeAttribute('data-active');
            }
        });

        // Fluid Resizer Execution Block
        if (this.is_fluid && targetActivePane) {
            this.updateFluidBounds(targetActivePane);
        }

        this.data.active = this.data.next;
        this.onTabChange();
    }

    updateFluidBounds(activePane) {
        this.DOM.containers.forEach(container => {
            // Measure natural target container bounds by letting child layout settle
            const width = activePane.offsetWidth;
            const height = activePane.offsetHeight;

            // Apply explicit styles to container node
            container.style.width = `${width}px`;
            container.style.height = `${height}px`;
        });
    }

    updateZIndices(activePaneValue) {
        if (!this.is_hoverable) return;
        this.zIndexCounter++;
        this.DOM.panes.forEach(p => {
            const isNew = (p.dataset.pane === activePaneValue);
            if (isNew) p.style.zIndex = this.zIndexCounter + 100;
        });
    }

    async loadAsync(index, url) {
        if (this.data.cache[url]) {
            this.injectAsyncContent(index, this.data.cache[url]);
            this.data.next = index;
            this.change();
            return;
        }

        this.DOM.widget.classList.add('--loading-async');
        try {
            const response = await fetch(url);
            const json = await response.json();
            this.data.cache[url] = json.html;
            this.injectAsyncContent(index, json.html);
            this.data.next = index;
            this.change();

            const liveTabs = Array.from(this.DOM.widget.querySelectorAll('[data-tab], [data-async-tab]'));
            liveTabs[index]?.focus();
        } catch (err) {
            console.error("Async Tab Error:", err);
        } finally {
            this.DOM.widget.classList.remove('--loading-async');
        }
    }

    injectAsyncContent(index, html) {
        const liveTabs = Array.from(this.DOM.widget.querySelectorAll('[data-tab], [data-async-tab]'));
        const tab = liveTabs[index];
        const paneValue = tab ? (tab.dataset.tab || tab.dataset.asyncTab || index) : index;
        this.DOM.panes.forEach(pane => {
            if (pane.dataset.pane === paneValue) {
                const loader = pane.querySelector('[data-load]') || pane;
                loader.innerHTML = html;
            }
        });
    }

    handleKeydown(e) {
        const targetTab = e.target.closest('[data-tab], [data-async-tab]');
        if (!targetTab || !this.DOM.widget.contains(targetTab)) return;

        const liveTabs = Array.from(this.DOM.widget.querySelectorAll('[data-tab], [data-async-tab]'));
        let index = liveTabs.indexOf(targetTab);
        const lastIndex = liveTabs.length - 1;

        switch (e.key) {
            case 'ArrowRight': index = index === lastIndex ? 0 : index + 1; break;
            case 'ArrowLeft': index = index === 0 ? lastIndex : index - 1; break;
            case 'Home': index = 0; break;
            case 'End': index = lastIndex; break;
            default: return;
        }

        e.preventDefault();
        this.setActive(index);

        if (!liveTabs[index].hasAttribute('data-async-tab') || this.data.cache[liveTabs[index].getAttribute('href')]) {
            liveTabs[index].focus();
        }
    }

    handleScrollEvent(e) {
        const { target, way } = e.detail;
        if (way === "enter") {
            const index = this.DOM.panes.indexOf(target);
            if (index !== -1) this.setActive(index);
        }
    }

    scrollToTrigger(index) {
        const liveTabs = Array.from(this.DOM.widget.querySelectorAll('[data-tab], [data-async-tab]'));
        const tab = liveTabs[index];
        const paneName = tab ? (tab.dataset.tab || tab.dataset.asyncTab) : null;
        const trigger = this.scrollTriggers.find(t => t.paneName === paneName)?.trigger;

        if (trigger) {
            this.is_scrolling_via_click = true;
            clearTimeout(this.scroll_timeout);
            const y = trigger.getBoundingClientRect().top + window.pageYOffset;
            if (window.SCROLL) window.SCROLL.scrollTo(y);
            this.scroll_timeout = setTimeout(() => {
                this.is_scrolling_via_click = false;
            }, this.settings.animationDuration);
        }
    }

    getTabIndexByPaneValue(paneValue) {
        const liveTabs = Array.from(this.DOM.widget.querySelectorAll('[data-tab], [data-async-tab]'))
            .filter(tab => tab.closest('[data-tabs]') === this.DOM.widget); // Scopes tightly to this layer

        return liveTabs.findIndex(tab => {
            return tab.dataset.tab === paneValue || tab.dataset.asyncTab === paneValue;
        });
    }

    startAutoplay() {
        console.log('Start autoplay ...')
        this.autoplayTimer = setInterval(() => {
            // Logic to go to next tab
            const nextIndex = this.data.active < (this.DOM.tabs.length - 1) ? this.data.active + 1 : 0;
            this.setActive(nextIndex);
        }, this.autoplayInterval);
    }

    resetAutoplay() {
        if (this.autoplayTimer) {
            clearInterval(this.autoplayTimer);
            this.startAutoplay();
        }
    }

    destroy() {
        this.DOM.widget.removeEventListener('keydown', this._boundHandleKeydown);
        window.removeEventListener("scrollTabEvent", this._boundScrollEvent);

        // --- NEW: Remove progress listener ---
        if (this._boundUpdateProgress) {
            window.removeEventListener('scroll', this._boundUpdateProgress);
        }

        if (this.observer) this.observer.disconnect();
        clearTimeout(this.scroll_timeout);
        clearTimeout(this.hover_timeout);
        this.closing_timeouts.forEach(id => clearTimeout(id));
        this.DOM.panes.forEach(p => p.style.zIndex = '');
        this.DOM.widget.removeAttribute('data-scroll-progress');
        this.DOM.widget.style.removeProperty('--progress');
    }

    initEvents() {
        if (this.is_hoverable) {
            const setupHoverListeners = () => {
                const liveTabs = Array.from(this.DOM.widget.querySelectorAll('[data-tab], [data-async-tab]'));
                liveTabs.forEach(tab => {
                    const getIndex = () => {
                        const value = tab.dataset.tab || tab.dataset.asyncTab;
                        return (!value) ? liveTabs.indexOf(tab) : this.getTabIndexByPaneValue(value);
                    };

                    const handleHover = () => {
                        const index = getIndex();
                        if (index === -1) return;

                        const currentTabs = Array.from(this.DOM.widget.querySelectorAll('[data-tab], [data-async-tab]'));
                        currentTabs.forEach((t, i) => {
                            const isActive = i === index;
                            t.toggleAttribute('data-active', isActive);
                            t.setAttribute('aria-selected', isActive ? 'true' : 'false');
                            t.setAttribute('tabindex', isActive ? '0' : '-1');
                        });
                        clearTimeout(this.hover_timeout);
                        this.hover_timeout = setTimeout(() => {
                            if (index !== this.data.active) this.setActive(index);
                        }, this.settings.debounceDuration);
                    };

                    tab.addEventListener('mouseenter', handleHover);
                    tab.addEventListener('mousemove', handleHover);
                    tab.addEventListener('mouseleave', () => {
                        clearTimeout(this.hover_timeout);
                        const currentTabs = Array.from(this.DOM.widget.querySelectorAll('[data-tab], [data-async-tab]'));
                        currentTabs.forEach((t, i) => {
                            const isActive = i === this.data.active;
                            t.toggleAttribute('data-active', isActive);
                            t.setAttribute('aria-selected', isActive ? 'true' : 'false');
                            t.setAttribute('tabindex', isActive ? '0' : '-1');
                        });
                    });
                });
            };
            setupHoverListeners();
        }

        this.DOM.widget.addEventListener("click", e => {
            const tab = e.target.closest('[data-tab], [data-async-tab]');
            const clickedLink = e.target.closest('a');

            if (tab && this.DOM.widget.contains(tab)) {
                const href = clickedLink?.getAttribute('href');
                if (href && href !== '#' && href !== '') return;

                if (!clickedLink && !tab.hasAttribute('href')) e.preventDefault();

                const tabValue = tab.dataset.tab || tab.dataset.asyncTab;
                const index = tabValue ? this.getTabIndexByPaneValue(tabValue) : Array.from(this.DOM.widget.querySelectorAll('[data-tab], [data-async-tab]')).indexOf(tab);

                if (index !== -1) {
                    clearTimeout(this.hover_timeout);
                    this.setActive(index);
                    this.scrollToTrigger(index);
                }
                return;
            }

            const liveTabs = Array.from(this.DOM.widget.querySelectorAll('[data-tab], [data-async-tab]'));
            if (e.target.closest('[data-tab-prev]')) {
                clearTimeout(this.hover_timeout);
                const prevIndex = this.data.active > 0 ? this.data.active - 1 : liveTabs.length - 1;
                this.setActive(prevIndex);
                this.scrollToTrigger(prevIndex);
            } else if (e.target.closest('[data-tab-next]')) {
                clearTimeout(this.hover_timeout);
                const nextIndex = this.data.active < (liveTabs.length - 1) ? this.data.active + 1 : 0;
                this.setActive(nextIndex);
                this.scrollToTrigger(nextIndex);
            }

            // Add resetAutoplay() after user interaction
            if (tab && this.DOM.widget.contains(tab)) {
                // ... (existing tab clicking logic)
                this.resetAutoplay();
                return;
            }

            if (e.target.closest('[data-tab-prev]')) {
                // ...
                this.resetAutoplay();
            } else if (e.target.closest('[data-tab-next]')) {
                // ...
                this.resetAutoplay();
            }
        });

        this.DOM.widget.addEventListener('keydown', this._boundHandleKeydown);
        window.addEventListener("scrollTabEvent", this._boundScrollEvent);

        // Handle window resizes gracefully if layout drops or text blocks shift
        if (this.is_fluid) {
            window.addEventListener('resize', () => {
                const activeTab = Array.from(this.DOM.widget.querySelectorAll('[data-tab], [data-async-tab]'))[this.data.active];
                const activePaneValue = activeTab ? (activeTab.dataset.tab || activeTab.dataset.asyncTab) : null;
                const currentPane = this.DOM.panes.find(p => p.dataset.pane === activePaneValue);
                if (currentPane) this.updateFluidBounds(currentPane);
            });
        }
    }

    onTabChange() {
        if (window.SCROLL) window.SCROLL.resize();
        const line = this.DOM.widget.querySelector('[data-tabs-autoplay-line]');
        if (line) {
            line.style.animation = 'none';
            void line.offsetWidth; // Trigger reflow
            line.style.animation = null; // Revert to CSS default
        }
        // if (window.Locomotion) window.Locomotion.update();
    }
}

function initTabs() {
    document.querySelectorAll('[data-tabs]').forEach(el => new Tabs(el));
}