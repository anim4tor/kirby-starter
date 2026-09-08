/*

  ASIDE MENU
  
*/

// class Aside {
//     constructor(el) {
//         console.log(' ... init Mobile menu')
//         this.DOM = {
//             control: el,
//             trigger: el.querySelectorAll('[data-aside-toggle]'),
//             close: el.querySelectorAll('[data-aside-close]'),
//             menu: el.querySelectorAll('[data-aside-menu]'),
//             header: el.querySelector('[data-header]')
//         };
//         this.class = {
//             open: 'aside-open',
//             close: 'aside-closing'
//         }
        
//         this.isOpen = false

//         // init/bind events
//         // if(!isMobile) {
//             this.initEvents();
//         // }

//     }

//     open() {
//         this.isOpen = true
//         this.DOM.control.setAttribute(this.class.open, '')
//         // SCROLL.stop();
//     }

//     close() {
//         this.DOM.control.removeAttribute(this.class.open)

//         var _this = this
//         setTimeout(function() {

//         },0)
//         this.isOpen = false
//         // SCROLL.start();

//     }

//     onMenu(e) {
//         var index = Array.from(this.DOM.menu).indexOf(e.target)
//         console.log('On menu enter: ', index)

//         this.DOM.menu.forEach(el => { el.removeAttribute('data-active') })
//         this.DOM.menu.item(index).setAttribute('data-active',true)
//     }

//     initEvents() {
//         this.DOM.trigger.forEach((el) => { 
//             el.addEventListener("click", e => {
//                 console.log('Trigger')
//                 // e.preventDefault()
//                 if(this.isOpen) {
//                     this.close()
//                 } else {
//                     this.open()
//                 }
//             });
//         })

//         this.DOM.close.forEach((el) => { 
//             el.addEventListener("click", e => {
//                 e.preventDefault()
//                 if(this.isOpen) {
//                     this.close()
//                 }
//             });
//         })

//         this.DOM.menu.forEach((el) => { 
//             el.addEventListener("mouseenter", e => {
//                 e.preventDefault()
//                 this.onMenu(e)
//             });
//         })
//     }
// }

// function initAside() {
//     new Aside(document.documentElement)
// }


/*

  ASIDE WIDGET
  
*/

class Aside {
    constructor(el) {
        if (!el) return;

        console.log(' ... init Aside widget')
        
        this.DOM = {
            html: document.documentElement,
            dialog: el.querySelector('[data-aside]'),
            widget: el.querySelector('[data-aside-widget]'),
            triggers: document.querySelectorAll('[data-aside-toggle]'),
            closeBtns: el.querySelectorAll('[data-aside-close]')
        };

        this.state = { isOpen: false };

        this.handleDocumentClick = this.handleDocumentClick.bind(this);
        this.handleKeyDown = this.handleKeyDown.bind(this);
        
        this.init();
    }

    init() {
        this.DOM.triggers.forEach(btn => btn.addEventListener('click', (e) => this.toggle(e)));
        this.DOM.closeBtns.forEach(btn => btn.addEventListener('click', () => this.close()));
    }

    toggle(e) {
        if (e) {
            e.preventDefault();
            e.stopPropagation();
        }
        this.state.isOpen ? this.close() : this.open();
    }

    open() {
        if (this.state.isOpen) return;
        this.state.isOpen = true;

        this.DOM.html.setAttribute('aside-open', 'true');
        this.DOM.html.style.overflow = 'hidden'; // Body scroll lock
        this.DOM.dialog.setAttribute('aria-hidden', 'false');

        document.addEventListener('click', this.handleDocumentClick);
        document.addEventListener('keydown', this.handleKeyDown);
    }

    close() {
        if (!this.state.isOpen) return;
        this.state.isOpen = false;

        this.DOM.html.removeAttribute('aside-open');
        this.DOM.html.style.overflow = ''; 
        this.DOM.dialog.setAttribute('aria-hidden', 'true');

        document.removeEventListener('click', this.handleDocumentClick);
        document.removeEventListener('keydown', this.handleKeyDown);
    }

    handleKeyDown(e) {
        if (e.key === 'Escape') this.close();
    }

    handleDocumentClick(e) {
        // Close if click is outside the widget
        if (this.DOM.widget && !this.DOM.widget.contains(e.target) && !e.target.closest('[data-aside-toggle]')) {
            this.close();
        }
    }
}

function initAside() {
    document.querySelector('[data-aside]') ? 
        new Aside(document.documentElement) 
    : null
}
