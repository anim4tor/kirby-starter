/*

  CONTACT WIDGET
  
*/

class Contact {
    constructor(el) {
        if (!el) return;

        console.log(' ... init Contact widget')

        this.DOM = {
            html: document.documentElement,
            dialog: el.querySelector('[data-contact]'),
            widget: el.querySelector('[data-contact-widget]'),
            triggers: document.querySelectorAll('[data-contact-toggle]'),
            closeBtns: el.querySelectorAll('[data-contact-close]'),
            tabsWidget: el.querySelector('[data-tabs]')
        };

        this.state = {
            isOpen: false,
            isScrollPop: false
        };

        this.tabs = null;
        this.scrollObserver = null;

        this.handleDocumentClick = this.handleDocumentClick.bind(this);
        this.handleKeyDown = this.handleKeyDown.bind(this);

        this.init();
    }

    init() {
        if (this.DOM.tabsWidget && typeof Tabs === 'function') {
            this.tabs = new Tabs(this.DOM.tabsWidget);
        }

        // 1. Click Triggers
        this.DOM.triggers.forEach(btn => btn.addEventListener('click', (e) => {
            if (e) {
                e.preventDefault();
                e.stopPropagation();
            }

            const targetTab = btn.getAttribute('data-contact-toggle');

            if (this.state.isOpen) {
                // Upgrade from passive pop to a focused modal state if a direct trigger is fired
                if (this.state.isScrollPop) {
                    this.upgradeToFullOpen(targetTab);
                } else if (targetTab && targetTab !== "true" && this.tabs) {
                    const index = this.tabs.getTabIndexByPaneValue(targetTab);
                    if (index !== -1) this.tabs.setActive(index);
                } else {
                    this.close();
                }
            } else {
                this.open(targetTab, false);
            }
        }));

        this.DOM.closeBtns.forEach(btn => btn.addEventListener('click', () => this.close()));

        this.initScrollTriggers();
        this.initForms();
    }

    initForms() {
        const forms = document.querySelectorAll('form[data-form="contact"], #contact-form, #career-form');
        forms.forEach(form => {
            if (form._hasContactListener) return;
            form._hasContactListener = true;

            const formInputs = form.querySelectorAll('input, select, textarea');
            formInputs.forEach(input => {
                input.addEventListener('input', () => {
                    if (input.classList.contains('invalid')) {
                        input.classList.remove('invalid');
                        const errorBox = form.querySelector('[data-form-error]');
                        if (errorBox && !form.querySelector('.invalid')) {
                            errorBox.innerHTML = '';
                        }
                    }
                });
                input.addEventListener('change', () => {
                    if (input.classList.contains('invalid')) {
                        input.classList.remove('invalid');
                    }
                });
            });

            form.addEventListener('submit', async (e) => {
                e.preventDefault();

                const submitBtn = form.querySelector('[data-form-submit], button[type="submit"]');
                const errorBox = form.querySelector('[data-form-error]');
                const successBox = form.querySelector('[data-form-success]');
                const inputs = form.querySelectorAll('input, select, textarea');

                if (errorBox) errorBox.innerHTML = '';
                if (successBox) successBox.classList.add('hidden');
                inputs.forEach(el => el.classList.remove('invalid'));

                // Client validation
                let hasClientError = false;
                const emailInput = form.querySelector('input[type="email"], input[name="email"]');
                const nameInput = form.querySelector('input[name="name"]');
                const msgInput = form.querySelector('textarea[name="message"]');

                if (nameInput && nameInput.value.trim().length < 2) {
                    nameInput.classList.add('invalid');
                    hasClientError = true;
                }
                if (emailInput && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value.trim())) {
                    emailInput.classList.add('invalid');
                    hasClientError = true;
                }
                if (msgInput && msgInput.value.trim().length < 3) {
                    msgInput.classList.add('invalid');
                    hasClientError = true;
                }

                if (hasClientError) {
                    if (errorBox) errorBox.innerHTML = 'Prosím vyplňte všechna povinná pole.';
                    const firstInvalid = form.querySelector('.invalid');
                    if (firstInvalid) firstInvalid.focus();
                    return;
                }

                const originalBtnText = submitBtn ? submitBtn.innerHTML : 'Send';
                if (submitBtn) {
                    submitBtn.innerHTML = '<span>Odesílám...</span>';
                    submitBtn.setAttribute('disabled', 'true');
                }

                try {
                    const formData = new FormData(form);
                    const actionUrl = form.getAttribute('action') || '/contact.json';

                    const res = await fetch(actionUrl, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    });

                    const rawText = await res.text();
                    let data = {};
                    try {
                        data = JSON.parse(rawText);
                    } catch (parseErr) {
                        console.error('Non-JSON response from server:', rawText);
                        data = { status: 'error', message: 'Chyba serveru: ' + rawText.substring(0, 100) };
                    }

                    if (res.ok && data.status === 'success') {
                        form.reset();
                        if (errorBox) errorBox.innerHTML = '';

                        // Switch to dedicated success tab pane
                        if (this.tabs && typeof this.tabs.setActivePane === 'function') {
                            this.tabs.setActivePane('success');
                        } else {
                            const successPane = document.querySelector('[data-pane="success"]');
                            const allPanes = document.querySelectorAll('[data-contact-widget] [data-pane]');
                            allPanes.forEach(p => p.removeAttribute('data-active'));
                            if (successPane) successPane.setAttribute('data-active', 'true');
                        }
                    } else {
                        if (data.errors) {
                            for (const [fieldName, err] of Object.entries(data.errors)) {
                                const input = form.querySelector(`[name="${fieldName}"]`);
                                if (input) input.classList.add('invalid');
                            }
                            const firstInvalid = form.querySelector('.invalid');
                            if (firstInvalid) firstInvalid.focus();
                        }
                        if (errorBox) errorBox.innerHTML = data.message || 'Chyba při odesílání formuláře.';
                    }
                } catch (err) {
                    console.error('Contact Form Error:', err);
                    if (errorBox) errorBox.innerHTML = 'Nepodařilo se odeslat zprávu: ' + (err.message || err);
                } finally {
                    if (submitBtn) {
                        submitBtn.innerHTML = originalBtnText;
                        submitBtn.removeAttribute('disabled');
                    }
                }
            });
        });
    }

    initScrollTriggers() {
        const scrollElements = document.querySelectorAll('[data-contact-scroll-toggle]');
        if (scrollElements.length === 0) return;

        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.2
        };

        this.scrollObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !this.state.isOpen) {
                    const targetTab = entry.target.getAttribute('data-contact-scroll-toggle');

                    this.open(targetTab === "true" ? null : targetTab, true);
                    this.scrollObserver.unobserve(entry.target);
                }
            });
        }, observerOptions);

        scrollElements.forEach(el => this.scrollObserver.observe(el));
    }

    open(targetTab, isScrollPop = false) {
        if (this.state.isOpen) return;
        this.state.isOpen = true;
        this.state.isScrollPop = isScrollPop;

        if (isScrollPop) {
            // Set contact-open="pop" to allow background interaction
            this.DOM.html.setAttribute('contact-open', 'pop');
        } else {
            // Set contact-open="true" and completely freeze layout scrolling
            this.DOM.html.setAttribute('contact-open', 'true');
            this.DOM.html.style.overflow = 'hidden';
        }

        this.DOM.dialog.setAttribute('aria-hidden', 'false');

        if (this.tabs) {
            if (targetTab && targetTab !== "true") {
                const index = this.tabs.getTabIndexByPaneValue(targetTab);
                if (index !== -1) {
                    this.tabs.setActive(index, true);
                } else {
                    this.tabs.setActive(0, true);
                }
            } else {
                this.tabs.setActive(0, true);
            }
        }

        if (this.tabs && this.tabs.is_fluid) {
            const activeTab = this.tabs.DOM.tabs[this.tabs.data.active];
            const activePaneValue = activeTab ? (activeTab.dataset.tab || activeTab.dataset.asyncTab) : null;
            const currentPane = this.tabs.DOM.panes.find(p => p.dataset.pane === activePaneValue);
            if (currentPane) {
                setTimeout(() => this.tabs.updateFluidBounds(currentPane), 0);
            }
        }

        document.addEventListener('click', this.handleDocumentClick);
        document.addEventListener('keydown', this.handleKeyDown);
    }

    upgradeToFullOpen(targetTab) {
        this.state.isScrollPop = false;
        this.DOM.html.setAttribute('contact-open', 'true');
        this.DOM.html.style.overflow = 'hidden';

        if (this.tabs) {
            if (targetTab && targetTab !== "true") {
                const index = this.tabs.getTabIndexByPaneValue(targetTab);
                if (index !== -1) this.tabs.setActive(index, true);
            } else {
                this.tabs.setActive(0, true);
            }
        }
    }

    close() {
        if (!this.state.isOpen) return;
        this.state.isOpen = false;
        this.state.isScrollPop = false;

        this.DOM.html.removeAttribute('contact-open');
        this.DOM.html.style.overflow = '';

        this.DOM.dialog.setAttribute('aria-hidden', 'true');

        if (this.tabs) {
            this.tabs.setActive(0, true);
        }

        // Explicitly clear success pane state
        const allPanes = document.querySelectorAll('[data-contact-widget] [data-pane]');
        allPanes.forEach(p => {
            if (p.dataset.pane === 'success') {
                p.removeAttribute('data-active');
            }
        });

        document.removeEventListener('click', this.handleDocumentClick);
        document.removeEventListener('keydown', this.handleKeyDown);
    }

    handleKeyDown(e) {
        if (e.key === 'Escape') this.close();
    }

    handleDocumentClick(e) {
        if (this.DOM.widget && !this.DOM.widget.contains(e.target) && !e.target.closest('[data-contact-toggle]')) {
            this.close();
        }
    }

    destroy() {
        if (this.tabs) this.tabs.destroy();
        if (this.scrollObserver) this.scrollObserver.disconnect();
        document.removeEventListener('click', this.handleDocumentClick);
        document.removeEventListener('keydown', this.handleKeyDown);
    }
}

function initContact() {
    document.querySelector('[data-contact]') ?
        new Contact(document.documentElement)
        : null
}
