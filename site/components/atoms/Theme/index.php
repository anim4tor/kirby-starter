<?= css('site/components/atoms/Theme/theme.css') ?>

<div data-scroll data-reveal-image class="fixed inset__top-right grid place__start-end gap__02 z__10" style="--in-delay: 600ms; position: fixed; top: 1rem; right: 1rem; z-index: 1000;">

	<div class="flex gap__01">
		<?php if ($kirby->user()): ?>
			<a href="<?= $page->panel()->url() ?>" target="_blank" id="panel-link-btn" aria-label="Open in Kirby Panel">
				<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
					<path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
					<path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
				</svg>
			</a>

			<button id="theme-toggle-btn" aria-label="Toggle Theme Settings">
				<svg class="icon-settings" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
					<circle cx="12" cy="12" r="3"></circle>
					<path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
				</svg>
				<svg class="icon-close" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
					<line x1="18" y1="6" x2="6" y2="18"></line>
					<line x1="6" y1="6" x2="18" y2="18"></line>
				</svg>
			</button>
		<?php endif; ?>
	</div>

	<div id="theme-panel-body" class="grid__2 gap__1 inner__05 color__invert bg__black/80 is-hidden" style="max-height: 85vh; overflow-y: auto; font-family: sans-serif; padding: 1rem;">
		
		<div class="theme-tab-nav span__2">
			<button class="theme-tab-btn is-active" data-tab-target="tab-typography">Typography</button>
			<button class="theme-tab-btn" data-tab-target="tab-scale">Scale Engine</button>
			<button class="theme-tab-btn" data-tab-target="tab-spacing">Spacing</button>
			<button class="theme-tab-btn" data-tab-target="tab-animations">Animations</button>
			<button class="theme-tab-btn" data-tab-target="tab-colors">Colors & Canvas</button>
			<button class="theme-tab-btn" data-tab-target="tab-images">Images</button>
			<button class="theme-tab-btn" data-tab-target="tab-buttons">Buttons</button>
		</div>

		<div id="tab-typography" class="theme-tab-content grid__2 gap__1 span__2">
			<div class="typo-section-header">Heading Elements</div>
			<div class="grid span__2">
				<label class="ff__body op__4 font__size__small">Heading Family</label>
				<select name="ff-heading" data-theme-setup data-font-select>
					</select>
			</div>
			<div class="theme-panel-row span__2" style="margin-bottom: 0.5rem;">
				<div class="grid">
					<label class="ff__body op__4 font__size__small">Weight</label>
					<input type="number" name="fw-heading" step="100" min="100" max="900" data-theme-setup>
				</div>
				<div class="grid">
					<label class="ff__body op__4 font__size__small">Transform</label>
					<select name="tt-heading" data-theme-setup>
						<option value="none">None</option>
						<option value="uppercase">Uppercase</option>
						<option value="lowercase">Lowercase</option>
					</select>
				</div>
				<div class="grid">
					<label class="ff__body op__4 font__size__small">Tracking</label>
					<input type="text" name="ls-heading" data-theme-setup>
				</div>
			</div>

			<div class="typo-section-header">Body Copy Elements</div>
			<div class="grid span__2">
				<label class="ff__body op__4 font__size__small">Body Family</label>
				<select name="ff-body" data-theme-setup data-font-select>
					</select>
			</div>
			<div class="theme-panel-row span__2" style="margin-bottom: 0.5rem;">
				<div class="grid">
					<label class="ff__body op__4 font__size__small">Weight</label>
					<input type="number" name="fw-body" step="100" min="100" max="900" data-theme-setup>
				</div>
				<div class="grid">
					<label class="ff__body op__4 font__size__small">Transform</label>
					<select name="tt-body" data-theme-setup>
						<option value="none">None</option>
						<option value="uppercase">Uppercase</option>
						<option value="lowercase">Lowercase</option>
					</select>
				</div>
				<div class="grid">
					<label class="ff__body op__4 font__size__small">Tracking</label>
					<input type="text" name="ls-body" data-theme-setup>
				</div>
			</div>

			<div class="typo-section-header">Monospace / Code Elements</div>
			<div class="grid span__2">
				<label class="ff__body op__4 font__size__small">Mono Family</label>
				<select name="ff-mono" data-theme-setup data-font-select>
					</select>
			</div>
		</div>

		<div id="tab-scale" class="theme-tab-content grid__2 gap__1 span__2 is-hidden">
			<div class="grid span__2" style="border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 0.25rem;"><span class="font__size__small op__6 uppercase font-weight:bold;">Heading Hierarchy</span></div>
			
			<div class="grid span__2">
				<label class="ff__body op__4 font__size__small">H-Typescale</label>
				<div class="flex" style="align-items: center; gap: 0.25rem; width: 100%;">
					<select id="ts-select" name="type-scale" data-theme-setup style="flex: 1;">
						<option value="1.618">1.618 – Golden</option>
						<option value="1.414">1.414 – Aug 4th</option>
						<option value="1.333">1.333 – Perf 4th</option>
						<option value="1.250">1.250 – Maj 3rd</option>
						<option value="1.200">1.200 – Min 3rd</option>
						<option value="custom">Custom...</option>
					</select>
					<input type="number" id="ts-input" step="0.001" min="1" max="4" style="width: 80px;" placeholder="1.618">
				</div>
			</div>

			<div class="theme-panel-row span__2">
				<div class="grid">
					<label class="ff__body op__4 font__size__small">H-Start Baseline (Rem)</label>
					<input type="number" name="type-start-rem" step="0.05" min="0.5" max="4" data-theme-setup data-unit="rem">
				</div>
				<div class="grid">
					<label class="ff__body op__4 font__size__small">H-Start Fluid (Vw)</label>
					<input type="number" name="type-start-vw" step="0.05" min="0.5" max="4" data-theme-setup data-unit="vw">
				</div>
			</div>

			<div class="grid span__2">
				<label class="ff__body op__4 font__size__small">H-Line Height</label>
				<input type="number" name="base-line-height" step="0.05" min="0.8" max="2" data-theme-setup>
			</div>

			<div class="grid span__2" style="border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 0.25rem; margin-top: 0.5rem;"><span class="font__size__small op__6 uppercase font-weight:bold;">Body Copy Hierarchy</span></div>
			
			<div class="grid span__2">
				<label class="ff__body op__4 font__size__small">Body Scale</label>
				<div class="flex" style="align-items: center; gap: 0.25rem; width: 100%;">
					<select id="bs-select" name="body-scale" data-theme-setup style="flex: 1;">
						<option value="1.400">1.400 – Default</option>
						<option value="1.222">1.222 – Compact</option>
						<option value="1.125">1.125 – Tight</option>
						<option value="custom">Custom...</option>
					</select>
					<input type="number" id="bs-input" step="0.001" min="1" max="3" style="width: 80px;" placeholder="1.400">
				</div>
			</div>

			<div class="theme-panel-row span__2">
				<div class="grid">
					<label class="ff__body op__4 font__size__small">B-Start Baseline (Rem)</label>
					<input type="number" name="body-start-rem" step="0.001" min="0.1" max="3" data-theme-setup data-unit="rem">
				</div>
				<div class="grid">
					<label class="ff__body op__4 font__size__small">B-Start Fluid (Vw)</label>
					<input type="number" name="body-start-vw" step="0.001" min="0.1" max="3" data-theme-setup data-unit="vw">
				</div>
			</div>

			<div class="grid span__2">
				<label class="ff__body op__4 font__size__small">B-Line Height</label>
				<input type="number" name="base-body-line-height" step="0.05" min="1.0" max="2.5" data-theme-setup>
			</div>
		</div>

		<div id="tab-spacing" class="theme-tab-content grid__2 gap__1 span__2 is-hidden">
			<div class="grid">
				<label class="ff__body op__4 font__size__small">Min Scale</label>
				<input type="number" name="scale-min" step="0.05" min="0.2" max="3" data-theme-setup>
			</div>
			<div class="grid">
				<label class="ff__body op__4 font__size__small">Fluid Scale</label>
				<input type="number" name="scale-fluid" step="0.1" min="0" max="10" data-theme-setup>
			</div>
			<div class="grid span__2">
				<label class="ff__body op__4 font__size__small">Global Scale Modifier</label>
				<input type="number" name="scale" step="0.05" min="0.2" max="3" data-theme-setup>
			</div>
		</div>

		<div id="tab-animations" class="theme-tab-content grid__2 gap__1 span__2 is-hidden">
			<div class="grid">
				<label class="ff__body op__4 font__size__small">Duration</label>
				<input type="text" name="animation-duration" placeholder="800ms" data-theme-setup>
			</div>
			<div class="grid">
				<label class="ff__body op__4 font__size__small">Delay</label>
				<input type="text" name="animation-delay" placeholder="0ms" data-theme-setup>
			</div>
			<div class="grid span__2">
				<label class="ff__body op__4 font__size__small">Stagger Interval</label>
				<input type="text" name="animation-stagger" placeholder="50ms" data-theme-setup>
			</div>
			<div class="grid span__2">
				<label class="ff__body op__4 font__size__small">Timing Curve</label>
				<select name="animation-timing" data-theme-setup>
					<option value="cubic-bezier(0.4, 0, 0.2, 1)">Material Standard (0.4, 0, 0.2, 1)</option>
					<option value="cubic-bezier(0.25, 1, 0.5, 1)">Cubic Out (Smooth)</option>
					<option value="cubic-bezier(0.16, 1, 0.3, 1)">Expo Out (Snappy)</option>
					<option value="ease">Ease</option>
					<option value="linear">Linear</option>
				</select>
			</div>
			<div class="grid">
				<label class="ff__body op__4 font__size__small">Parallax Matrix</label>
				<select name="toggle-parallax" data-theme-setup>
					<option value="1">Enabled</option>
					<option value="0">Disabled</option>
				</select>
			</div>
			<div class="grid">
				<label class="ff__body op__4 font__size__small">Scroll Reveals</label>
				<select name="toggle-reveals" data-theme-setup>
					<option value="1">Enabled</option>
					<option value="0">Disabled</option>
				</select>
			</div>
		</div>

		<div id="tab-colors" class="theme-tab-content grid__2 gap__1 span__2 is-hidden">
			<div class="grid span__2" style="width: 100%;">
				<label class="ff__body op__4 font__size__small">Theme Canvas Mode</label>
				<select id="canvas-theme-selector">
					<option value="default">Default Root</option>
					<option value="light">Light Mode</option>
					<option value="dark">Dark Mode</option>
					<option value="invert">Inverted Mode</option>
					<option value="acc">Accent Mode</option>
				</select>
			</div>

			<div class="grid span__2" style="width: 100%; margin-top: 0.25rem;">
				<label class="ff__body op__4 font__size__small" style="margin-bottom: 0.35rem;">System Colors Palette</label>
				<div id="dynamic-color-grid" class="color-picker-grid">
					</div>
			</div>
		</div>

		<div id="tab-images" class="theme-tab-content grid__2 gap__1 span__2 is-hidden">
		    <div class="grid">
		        <label class="ff__body op__4 font__size__small">Image Radius</label>
		        <input type="number" name="img-radius" step="0.1" min="0" max="10" data-theme-setup>
		    </div>
		    <div class="grid">
		        <label class="ff__body op__4 font__size__small">Global Radius</label>
		        <input type="number" name="radius" step="0.1" min="0" max="10" data-theme-setup>
		    </div>
		</div>

		<div id="tab-buttons" class="theme-tab-content grid__2 gap__1 span__2 is-hidden">
		    <div class="grid">
		        <label class="ff__body op__4 font__size__small">Btn Padding</label>
		        <input type="text" name="btn-padding" placeholder="0.5rem 1rem" data-theme-setup>
		    </div>
		    <div class="grid">
		        <label class="ff__body op__4 font__size__small">Btn Radius</label>
		        <input type="number" name="btn-radius" step="1" min="0" max="50" data-theme-setup>
		    </div>
		    <div class="grid span__2">
		        <label class="ff__body op__4 font__size__small">Btn Border Width</label>
		        <input type="number" name="btn-border" step="1" min="0" max="10" data-theme-setup>
		    </div>
		</div>

		<div class="flex span__2" style="width: 100%; margin-top: 0.75rem; gap: 0.5rem; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 0.75rem; flex-wrap: wrap;">
					
			<form action="<?= $page->url() ?>" method="POST" style="width: 100%; margin: 0; padding: 0;">
				<input type="hidden" name="action" value="sync_theme_fonts">
				
				<button type="submit" style="width: 100%; background: rgba(0, 123, 255, 0.2); color: #007bff; border: 1px solid rgba(0, 123, 255, 0.4); padding: 0.5rem; border-radius: 4px; cursor: pointer; font-family: sans-serif; font-size: 0.75rem; letter-spacing: 0.05em; text-transform: uppercase; font-weight: bold; margin-bottom: 0.25rem; transition: all 0.2s;">
					🔄 Sync Fonts
				</button>
			</form>

			<form id="theme-save-form" action="<?= $page->url() ?>" method="POST" style="flex: 2; margin: 0; padding: 0;">
				<input type="hidden" name="action" value="save-theme">
				<input type="hidden" id="css-tokens-input" name="css_tokens" value="">
				
				<button type="submit" style="width: 100%; background: rgba(40, 167, 69, 0.2); color: #28a745; border: 1px solid rgba(40, 167, 69, 0.4); padding: 0.5rem; border-radius: 4px; cursor: pointer; font-family: sans-serif; font-size: 0.75rem; letter-spacing: 0.05em; text-transform: uppercase; font-weight: bold;">
					💾 Save Config File
				</button>
			</form>

			<button id="theme-reset-btn" type="button" style="flex: 1; background: rgba(237, 19, 89, 0.2); color: #ff5487; border: 1px solid rgba(237, 19, 89, 0.4); padding: 0.5rem; border-radius: 4px; cursor: pointer; font-family: sans-serif; font-size: 0.75rem; letter-spacing: 0.05em; text-transform: uppercase; font-weight: bold;">
				Reset
			</button>
		</div>

	</div>
</div>

<script type="text/javascript">
	document.addEventListener('DOMContentLoaded', () => {
		const rootStyles = getComputedStyle(document.documentElement);
		const colorGridContainer = document.getElementById('dynamic-color-grid');
		
		const tsSelect = document.getElementById('ts-select');
		const tsInput = document.getElementById('ts-input');
		const bsSelect = document.getElementById('bs-select');
		const bsInput = document.getElementById('bs-input');
		
		const toggleBtn = document.getElementById('theme-toggle-btn');
		const resetBtn = document.getElementById('theme-reset-btn');
		const copyBtn = document.getElementById('theme-copy-btn');
		const panelBody = document.getElementById('theme-panel-body');
		const canvasSelector = document.getElementById('canvas-theme-selector');

		// --- 0. EXCLUSIVE DESIGN-TOKEN FONT PARSER ENGINE ---
		function discoverAndPopulateFonts() {
			const discoveredFonts = new Set();
			const bannedFonts = ['sans-serif', 'serif', 'monospace', 'inherit', 'initial', 'unset'];

			try {
				Array.from(document.styleSheets).forEach(sheet => {
					try {
						const rules = sheet.cssRules || sheet.rules;
						if (!rules) return;
						
						Array.from(rules).forEach(rule => {
							if (rule.type === CSSRule.FONT_FACE_RULE) {
								let family = rule.style.getPropertyValue('font-family') || rule.style.fontFamily;
								if (family) {
									family = family.trim().replace(/['"]/g, ''); 
									if (family && !family.startsWith('var(') && !bannedFonts.includes(family.toLowerCase())) {
										discoveredFonts.add(family);
									}
								}
							}
							
							if (rule.type === CSSRule.IMPORT_RULE && rule.href) {
								if (rule.href.includes('fonts.googleapis.com')) {
									const urlParams = new URLSearchParams(rule.href.split('?')[1]);
									const families = urlParams.getAll('family');
									families.forEach(f => {
										const name = f.split(':')[0].replace(/_/g, ' ');
										if (name && !name.startsWith('var(') && !bannedFonts.includes(name.toLowerCase())) {
											discoveredFonts.add(name);
										}
									});
								}
							}
						});
					} catch(e) {}
				});
			} catch(e) {}

			const fontDropdowns = document.querySelectorAll('[data-font-select]');
			fontDropdowns.forEach(dropdown => {
				dropdown.innerHTML = ''; 
				discoveredFonts.forEach(fontName => {
					const opt = document.createElement('option');
					opt.value = `'${fontName}'`; 
					opt.textContent = fontName;
					dropdown.appendChild(opt);
				});
			});
		}

		discoverAndPopulateFonts();

		// --- 1. TAB SELECTION CONTROL ENGINE ---
		const tabButtons = document.querySelectorAll('.theme-tab-btn');
		const tabContents = document.querySelectorAll('.theme-tab-content');

		tabButtons.forEach(btn => {
			btn.addEventListener('click', () => {
				const targetTabId = btn.dataset.tabTarget;
				tabButtons.forEach(b => b.classList.remove('is-active'));
				tabContents.forEach(c => c.classList.add('is-hidden'));
				btn.classList.add('is-active');
				document.getElementById(targetTabId).classList.remove('is-hidden');
			});
		});

		// --- 2. DYNAMIC CSS VARIABLE EXTRACTION ENGINE ---
		function getRawThemeDeclarations() {
			const declarations = {
				'spacing' : 'max(calc(var(--scale-min) * 1rem), calc(var(--scale-fluid) * 1vw * var(--scale)))',
				'type-start-rem' : '1.5rem',
				'type-start-vw' : '1.5vw',
				'body-start-rem' : '0.714rem',
				'body-start-vw' : '0.714vw',
				'animation-duration' : '800ms',
				'animation-timing' : 'cubic-bezier(0.4, 0, 0.2, 1)',
				'animation-stagger' : '50ms',
				'animation-delay' : '0ms',
				'toggle-parallax' : '1', // ADDED DEFAULT FALLBACK
				'toggle-reveals' : '1',  // ADDED DEFAULT FALLBACK
				'img-radius' : '8px',
		        'radius' : '4px',
		        'btn-padding' : '0.5rem 1rem',
		        'btn-radius' : '4px',
		        'btn-border' : '1px'
			};

			try {
				Array.from(document.styleSheets).forEach(sheet => {
					try {
						Array.from(sheet.cssRules || sheet.rules).forEach(rule => {
							if (rule.selectorText === ':root') {
								const cssText = rule.cssText;
								const matches = cssText.match(/--[\w-]+:\s*[^;]+;/g);
								if (matches) {
									matches.forEach(match => {
										const parts = match.split(':');
										const propName = parts[0].trim().replace('--', '');
										const propValue = parts[1].replace(';', '').trim();
										declarations[propName] = propValue;
									});
								}
							}
						});
					} catch(e) {}
				});
			} catch(e) {}
			return declarations;
		}

		// --- 3. DYNAMIC GENERATION OF COLOR PICKER CONTROLS ---
		const initialDeclarations = getRawThemeDeclarations();
		Object.keys(initialDeclarations).forEach(token => {
			if (token.startsWith('color-')) {
				const labelName = token.replace('color-', '');
				const stylizedLabel = labelName.charAt(0).toUpperCase() + labelName.slice(1);
				
				const itemMarkup = document.createElement('div');
				itemMarkup.className = 'color-item';
				itemMarkup.innerHTML = `
					<label class="font__size__small op__4">${stylizedLabel}</label>
					<input type="color" name="${token}" data-theme-setup data-is-color>
				`;
				colorGridContainer.appendChild(itemMarkup);
			}
		});

		const themeControls = document.querySelectorAll('[data-theme-setup]');

		// --- 4. PANEL VISIBILITY & ICON STATE ENGINE ---
		toggleBtn.addEventListener('click', () => {
			const isHidden = panelBody.classList.toggle('is-hidden');
			toggleBtn.classList.toggle('is-open', !isHidden);
		});

		// --- 5. THEME CANVAS DOM MODIFIER ---
		canvasSelector.addEventListener('change', () => {
			if (canvasSelector.value === 'default') {
				document.documentElement.removeAttribute('theme');
			} else {
				document.documentElement.setAttribute('theme', canvasSelector.value);
			}
		});

		// --- 6. RENDER SYSTEM VALUES UNTO PANEL ---
		function syncUIWithCSS() {
			const activeStyles = getComputedStyle(document.documentElement);

			themeControls.forEach(control => {
				const propertyName = control.name;
				let cssValue = activeStyles.getPropertyValue(`--${propertyName}`).trim();

				if (!cssValue) return;

				if (control.hasAttribute('data-is-color') && cssValue.startsWith('var(')) {
					const nestedProp = cssValue.replace(/^var\(--/, '').replace(/\)$/, '');
					cssValue = activeStyles.getPropertyValue(`--${nestedProp}`).trim();
				}

				if (control.dataset.unit) {
					cssValue = cssValue.replace(control.dataset.unit, '');
				}

				if (control.hasAttribute('data-is-color')) {
					if (cssValue.length === 4) {
						cssValue = '#' + cssValue[1] + cssValue[1] + cssValue[2] + cssValue[2] + cssValue[3] + cssValue[3];
					}
					control.value = cssValue;
				} else if (control.type === 'number') {
					control.value = cssValue ? parseFloat(cssValue) : '';
				} else if (control.tagName === 'SELECT') {
					const options = Array.from(control.options);
					const matchingOption = options.find(opt => 
						cssValue.toLowerCase().replace(/['"]/g, '') === opt.value.toLowerCase().replace(/['"]/g, '')
					);
					if (matchingOption) {
						control.value = matchingOption.value;
					} else if (propertyName === 'type-scale' || propertyName === 'body-scale') {
						control.value = 'custom';
					}
				} else {
					control.value = cssValue; 
				}
			});

			const activeTS = activeStyles.getPropertyValue('--type-scale').trim();
			if (activeTS) tsInput.value = parseFloat(activeTS);

			const activeBS = activeStyles.getPropertyValue('--body-scale').trim();
			if (activeBS) bsInput.value = parseFloat(activeBS);
		}

		syncUIWithCSS();

		// --- 7. LIVE CHANGES MUTATOR ENGINE ---
		function handleControlInput(event) {
			const element = event.target;
			const propertyName = element.name;
			let rawValue = element.value;
			let valueToApply;

			if (element.hasAttribute('data-is-color')) {
				valueToApply = rawValue;
			} else if (element.type === 'number') {
				const numericValue = rawValue ? parseFloat(rawValue) : 0;
				const unit = element.dataset.unit || '';
				valueToApply = `${numericValue}${unit}`;
			} else {
				valueToApply = rawValue;
			}

			if (element === tsSelect && valueToApply === 'custom') return;
			if (element === bsSelect && valueToApply === 'custom') return;

			if (element === tsSelect) tsInput.value = valueToApply;
			if (element === bsSelect) bsInput.value = valueToApply;

			document.documentElement.style.setProperty(`--${propertyName}`, valueToApply);
		}

		themeControls.forEach(control => {
			control.addEventListener('input', handleControlInput);
			control.addEventListener('change', handleControlInput); // Added to cleanly trap dropdown selections instantly
		});

		// --- 8. TYPESCALE & BODYSCALE MANAGEMENT ---
		tsSelect.addEventListener('change', () => {
			if (tsSelect.value !== 'custom') {
				document.documentElement.style.setProperty('--type-scale', tsSelect.value);
				tsInput.value = tsSelect.value;
			}
		});
		tsInput.addEventListener('input', () => {
			const val = tsInput.value ? parseFloat(tsInput.value) : 1.618;
			const match = Array.from(tsSelect.options).find(opt => parseFloat(opt.value) === val);
			tsSelect.value = match ? match.value : 'custom';
			document.documentElement.style.setProperty('--type-scale', val);
		});

		bsSelect.addEventListener('change', () => {
			if (bsSelect.value !== 'custom') {
				document.documentElement.style.setProperty('--body-scale', bsSelect.value);
				bsInput.value = bsSelect.value;
			}
		});
		bsInput.addEventListener('input', () => {
			const val = bsInput.value ? parseFloat(bsInput.value) : 1.400;
			const match = Array.from(bsSelect.options).find(opt => parseFloat(opt.value) === val);
			bsSelect.value = match ? match.value : 'custom';
			document.documentElement.style.setProperty('--body-scale', val);
		});

		// --- 9. GLOBAL RESET ENGINE ACTION ---
		if (resetBtn) {
			resetBtn.addEventListener('click', () => {
				const rawTokens = getRawThemeDeclarations();
				Object.keys(rawTokens).forEach(tokenName => {
					document.documentElement.style.removeProperty(`--${tokenName}`);
				});
				document.documentElement.style.removeProperty('--type-scale');
				document.documentElement.style.removeProperty('--body-scale');
				canvasSelector.value = 'default';
				document.documentElement.removeAttribute('theme');
				syncUIWithCSS();
			});
		}

		// --- 10. SYNCHRONOUS FORM SUBMIT ENGINE ---
		const saveForm = document.getElementById('theme-save-form');
		const tokensInput = document.getElementById('css-tokens-input');

		if (saveForm && tokensInput) {
			saveForm.addEventListener('submit', (event) => {
				const inlineStyles = document.documentElement.style;
				const rawDeclarations = getRawThemeDeclarations();
				
				const groups = {
					typography: ['ff-heading', 'fw-heading', 'tt-heading', 'ls-heading', 'ff-body', 'fw-body', 'tt-body', 'ls-body', 'ff-mono'],
					scale: ['type-scale', 'type-start-rem', 'type-start-vw', 'base-line-height', 'body-scale', 'body-start-rem', 'body-start-vw', 'base-body-line-height'],
					spacing: ['scale-min', 'scale-fluid', 'scale', 'spacing'],
					animations: ['animation-duration', 'animation-delay', 'animation-stagger', 'animation-timing', 'toggle-parallax', 'toggle-reveals'], // UPDATED GROUP
					images: ['img-radius', 'radius'],
					buttons: ['btn-padding', 'btn-radius', 'btn-border'],
					colors: []
				};

				Object.keys(rawDeclarations).forEach(token => {
					if (token.startsWith('color-')) groups.colors.push(token);
				});

				let cssOutputString = "/**\n * Design Tokens Live Export\n * Saved via Kirby Theme Panel Component\n */\n\n:root {\n";

				function appendGroup(title, tokensList) {
					let clusterContent = "";
					tokensList.forEach(token => {
						let finalValue = inlineStyles.getPropertyValue(`--${token}`).trim();
						if (!finalValue) finalValue = rawDeclarations[token];
						if (finalValue) {
							const paddedToken = `--${token}:`.padEnd(26, ' ');
							clusterContent += `    ${paddedToken} ${finalValue};\n`;
						}
					});
					if (clusterContent) {
						cssOutputString += `    /* ==========================================================================\n`;
						cssOutputString += `       ${title.toUpperCase()} TOKENS\n`;
						cssOutputString += `       ========================================================================== */\n`;
						cssOutputString += clusterContent + "\n";
					}
				}

				appendGroup("Typography Branding Framework", groups.typography);
				appendGroup("Fluid Responsive Scale Engine", groups.scale);
				appendGroup("Layout Padding & Grid Spacing", groups.spacing);
				appendGroup("Global Interactive Animations", groups.animations);
				appendGroup("Active Theme Palette Matrix", groups.colors);
				appendGroup("Image Styling", groups.images);
				appendGroup("Button Components", groups.buttons);

				cssOutputString = cssOutputString.trimEnd() + "\n}";

				// Inject text block cleanly into the form element field for submission
				tokensInput.value = cssOutputString;
			});
		}
	});
</script>