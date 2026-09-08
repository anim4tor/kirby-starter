<?php
/**
 * Template: Theme Studio & Atoms Living Design System
 */

require_once kirby()->root('snippets') . '/atoms/Theme/generate-fonts.php';

// Process AJAX font sync or theme token save
if (kirby()->request()->is('POST')) {
    if (get('action') === 'save-theme') {
        require_once kirby()->root('snippets') . '/atoms/Theme/save-theme.php';
    } elseif (get('action') === 'sync-fonts') {
        $fonts = generateThemeFonts();
        header('Content-Type: application/json');
        echo json_encode(['status' => 'success', 'fonts' => $fonts]);
        exit;
    }
}

// Discover all available local (in site/assets/fonts) and Google fonts
$availableFonts = generateThemeFonts();
?>

<div class="theme-page" data-scroll style="padding-top: 2rem; padding-bottom: 6rem; width: 100%;">
  <div class="inner-x__10 grid gap__2 mobile:inner-x__1 max-w__1400" style="margin: 0 auto;">
    
    <!-- Top Action & Navigation Bar -->
    <div class="flex justify__between align__center flex__wrap gap__1 mb__3 pb__1 border__bottom" style="border-color: rgba(var(--color-dark), 0.1);" data-scroll>
      <div class="flex align__center gap__1 flex__wrap">
        <a href="<?= url() ?>" class="button border radius" theme="ghost" hover="dark" style="font-size: 13px; padding: 6px 14px;">
          <span>&larr; Zpět na web</span>
        </a>
        <div class="tag radius font__size__small" theme="dark">
          Theme Studio & Living Design System
        </div>
      </div>

      <!-- Quick Canvas Switcher & Save Actions -->
      <div class="flex align__center gap__05 flex__wrap">
        
        <button type="button" onclick="window.syncFonts(this)" class="button border radius flex align__center gap__05" theme="ghost" hover="dark" style="padding: 4px 12px; font-size: 11px;" title="Načíst a synchronizovat fonty ze složky site/assets/fonts">
          <span>🔄 Load fonts</span>
        </button>

        <form id="theme-save-form" action="<?= $page->url() ?>" method="POST" style="margin: 0; display: inline-flex;">
          <input type="hidden" name="action" value="save-theme">
          <input type="hidden" id="css-tokens-input" name="css_tokens" value="">
          <button type="submit" class="button border radius" theme="dark" hover="acc" style="padding: 4px 12px; font-size: 11px; margin-left: 0.5rem;">
            <span>💾 Uložit do CSS tokenů</span>
          </button>
        </form>

        <button id="theme-reset-btn" type="button" class="button border radius" theme="ghost" hover="dark" style="padding: 4px 10px; font-size: 11px;">
          <span>Reset</span>
        </button>

        <a href="<?= $page->panel()->url() ?>" target="_blank" class="button border radius" theme="ghost" hover="dark" style="padding: 4px 10px; font-size: 11px;" title="Otevřít v panelu">
          <span>Panel &nearr;</span>
        </a>
      </div>
    </div>

    <!-- Main Navigation Tabs -->
    <div class="theme-nav-tabs flex gap__05 flex__wrap inner-b__1 border__bottom" style="border-color: rgba(var(--color-dark), 0.1);" data-scroll>
      <button type="button" class="theme-main-tab-btn is-active button border radius flex align__center gap__05" data-target="pane-typography" onclick="window.switchThemeTab('pane-typography', this)" theme="dark">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
          <polyline points="4 7 4 4 20 4 20 7"></polyline>
          <line x1="9" y1="20" x2="15" y2="20"></line>
          <line x1="12" y1="4" x2="12" y2="20"></line>
        </svg>
        <span>Typografie & Škála</span>
      </button>
      <button type="button" class="theme-main-tab-btn button border radius flex align__center gap__05" data-target="pane-colors" onclick="window.switchThemeTab('pane-colors', this)" theme="ghost" hover="dark">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="13.5" cy="6.5" r=".5" fill="currentColor"></circle>
          <circle cx="17.5" cy="10.5" r=".5" fill="currentColor"></circle>
          <circle cx="8.5" cy="7.5" r=".5" fill="currentColor"></circle>
          <circle cx="6.5" cy="12.5" r=".5" fill="currentColor"></circle>
          <path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"></path>
        </svg>
        <span>Barvy & Palety</span>
      </button>
      <button type="button" class="theme-main-tab-btn button border radius flex align__center gap__05" data-target="pane-buttons" onclick="window.switchThemeTab('pane-buttons', this)" theme="ghost" hover="dark">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
          <rect x="1" y="5" width="22" height="14" rx="7" ry="7"></rect>
          <circle cx="8" cy="12" r="3"></circle>
        </svg>
        <span>Tlačítka, Tagy & Linky</span>
      </button>
      <button type="button" class="theme-main-tab-btn button border radius flex align__center gap__05" data-target="pane-surfaces" onclick="window.switchThemeTab('pane-surfaces', this)" theme="ghost" hover="dark">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
          <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
          <polyline points="2 17 12 22 22 17"></polyline>
          <polyline points="2 12 12 17 22 12"></polyline>
        </svg>
        <span>Povrchy, Rádius & Rozestupy</span>
      </button>
      <button type="button" class="theme-main-tab-btn button border radius flex align__center gap__05" data-target="pane-forms" onclick="window.switchThemeTab('pane-forms', this)" theme="ghost" hover="dark">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
          <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
          <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
        </svg>
        <span>Formuláře & Inputy</span>
      </button>
      <button type="button" class="theme-main-tab-btn button border radius flex align__center gap__05" data-target="pane-interactive" onclick="window.switchThemeTab('pane-interactive', this)" theme="ghost" hover="dark">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
          <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
        </svg>
        <span>Animace & Interakce</span>
      </button>
    </div>

    <!-- ========================================================================= -->
    <!-- TAB 1: TYPOGRAFIE & ŠKÁLA -->
    <!-- ========================================================================= -->
    <div id="pane-typography" class="theme-main-pane" data-scroll>
      <div class="theme-studio-layout">
        
        <!-- Controls Sidebar -->
        <div class="theme-studio-controls">
          <div class="flex justify__between align__center">
            <div class="tag radius font__size__small" theme="dark">Nastavení typografie</div>
            <button type="button" onclick="window.syncFonts(this)" class="button border radius flex align__center gap__05" theme="ghost" hover="dark" style="padding: 2px 8px; font-size: 11px;" title="Načíst a synchronizovat fonty ze složky site/assets/fonts">
              <span>🔄 Load fonts</span>
            </button>
          </div>

          <div>
            <label class="font__size__small op__7 block mb__025 font__weight__bold">Heading Font Family</label>
            <select name="ff-heading" data-theme-setup data-font-select>
              <?php foreach ($availableFonts as $f): ?>
                <option value="<?= esc($f) ?>"><?= esc($f) ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="grid__2 gap__05">
            <div>
              <label class="font__size__small op__7 block mb__025 font__weight__bold">H-Weight</label>
              <input type="number" name="fw-heading" step="100" min="100" max="900" data-theme-setup>
            </div>
            <div>
              <label class="font__size__small op__7 block mb__025 font__weight__bold">H-Transform</label>
              <select name="tt-heading" data-theme-setup>
                <option value="none">None</option>
                <option value="uppercase">Uppercase</option>
                <option value="lowercase">Lowercase</option>
              </select>
            </div>
          </div>

          <div>
            <label class="font__size__small op__7 block mb__025 font__weight__bold">Body Font Family</label>
            <select name="ff-body" data-theme-setup data-font-select>
              <?php foreach ($availableFonts as $f): ?>
                <option value="<?= esc($f) ?>"><?= esc($f) ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="grid__2 gap__05">
            <div>
              <label class="font__size__small op__7 block mb__025 font__weight__bold">B-Weight</label>
              <input type="number" name="fw-body" step="100" min="100" max="900" data-theme-setup>
            </div>
            <div>
              <label class="font__size__small op__7 block mb__025 font__weight__bold">B-Transform</label>
              <select name="tt-body" data-theme-setup>
                <option value="none">None</option>
                <option value="uppercase">Uppercase</option>
                <option value="lowercase">Lowercase</option>
              </select>
            </div>
          </div>

          <div>
            <label class="font__size__small op__7 block mb__025 font__weight__bold">Mono / Code Font</label>
            <select name="ff-mono" data-theme-setup data-font-select>
              <?php foreach ($availableFonts as $f): ?>
                <option value="<?= esc($f) ?>"><?= esc($f) ?></option>
              <?php endforeach ?>
            </select>
          </div>

          <div class="border__top pt__1 mt__05" style="border-color: rgba(var(--color-dark), 0.1);">
            <label class="font__size__small op__7 block mb__025 font__weight__bold">Heading Typescale Ratio</label>
            <div class="flex gap__05 mb__05">
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

            <div class="grid__2 gap__05">
              <div>
                <label class="font__size__small op__7 block mb__025">H-Start Rem</label>
                <input type="number" name="type-start-rem" step="0.05" min="0.5" max="4" data-theme-setup data-unit="rem">
              </div>
              <div>
                <label class="font__size__small op__7 block mb__025">H-Start Fluid</label>
                <input type="number" name="type-start-vw" step="0.05" min="0.5" max="4" data-theme-setup data-unit="vw">
              </div>
            </div>
          </div>

          <div class="border__top pt__1 mt__05" style="border-color: rgba(var(--color-dark), 0.1);">
            <label class="font__size__small op__7 block mb__025 font__weight__bold">Body Typescale Ratio</label>
            <div class="flex gap__05 mb__05">
              <select id="bs-select" name="body-scale" data-theme-setup style="flex: 1;">
                <option value="1.400">1.400 – Default</option>
                <option value="1.222">1.222 – Compact</option>
                <option value="1.125">1.125 – Tight</option>
                <option value="custom">Custom...</option>
              </select>
              <input type="number" id="bs-input" step="0.001" min="1" max="3" style="width: 80px;" placeholder="1.400">
            </div>

            <div class="grid__2 gap__05">
              <div>
                <label class="font__size__small op__7 block mb__025">B-Start Rem</label>
                <input type="number" name="body-start-rem" step="0.001" min="0.1" max="3" data-theme-setup data-unit="rem">
              </div>
              <div>
                <label class="font__size__small op__7 block mb__025">B-Start Fluid</label>
                <input type="number" name="body-start-vw" step="0.001" min="0.1" max="3" data-theme-setup data-unit="vw">
              </div>
            </div>
          </div>
        </div>

        <!-- Live Preview Showcase -->
        <div class="theme-studio-preview">
          <div class="border radius inner__2" style="background: rgba(var(--color-dark), 0.02);" data-scroll>
            <div class="tag radius font__size__small mb__1" theme="dark">Živý náhled fluidních nadpisů</div>
            
            <div class="grid gap__1">
              <div class="border__bottom pb__1" style="border-color: rgba(var(--color-dark), 0.1);">
                <span class="font__size__small op__4 font__family__mono">Heading 1 / font__size__1</span>
                <h1 class="font__size__1 font__family__heading font__weight__bold">Hlavní fluidní titulek H1</h1>
              </div>
              <div class="border__bottom pb__1" style="border-color: rgba(var(--color-dark), 0.1);">
                <span class="font__size__small op__4 font__family__mono">Heading 2 / font__size__2</span>
                <h2 class="font__size__2 font__family__heading font__weight__bold">Sekční nadpis druhé úrovně H2</h2>
              </div>
              <div class="border__bottom pb__1" style="border-color: rgba(var(--color-dark), 0.1);">
                <span class="font__size__small op__4 font__family__mono">Heading 3 / font__size__3</span>
                <h3 class="font__size__3 font__family__heading font__weight__bold">Podnadpis kategorie a bloku H3</h3>
              </div>
              <div class="border__bottom pb__1" style="border-color: rgba(var(--color-dark), 0.1);">
                <span class="font__size__small op__4 font__family__mono">Heading 4 / font__size__4</span>
                <h4 class="font__size__4 font__family__heading font__weight__bold">Čtvrtá úroveň nadpisu H4</h4>
              </div>
              <div>
                <span class="font__size__small op__4 font__family__mono">Heading 5 / font__size__5</span>
                <h5 class="font__size__5 font__family__heading font__weight__bold">Drobný nadpis sekce H5</h5>
              </div>
            </div>
          </div>

          <div class="grid__2 mobile:grid__1 gap__2">
            <div class="border radius inner__2" style="background: rgba(var(--color-dark), 0.02);" data-scroll>
              <div class="tag radius font__size__small mb__1" theme="dark">Odstavce & Styl textu</div>
              <p class="font__size__large color__text mb__1" style="line-height: 1.5;">
                <strong>Lead Paragraph (Large):</strong> Úvodní text s vyšším důrazem a větší velikostí pro poutavé perexy.
              </p>
              <p class="font__size__default color__text mb__1" style="line-height: 1.6;">
                <strong>Default Body Text:</strong> Běžný odstavec obsahu. Podporuje <em>kurzívu</em>, <strong>tučné písmo</strong>, <del>přeškrtnutí</del> a <a href="#" class="color__acc font__weight__bold">aktivní inline odkazy</a>.
              </p>
              <p class="font__size__small color__text op__8" style="line-height: 1.4;">
                <strong>Small Text:</strong> Doplňkový text pro popisy, metadata, štítky nebo poznámky pod čarou.
              </p>
            </div>

            <div class="border radius inner__2" style="background: rgba(var(--color-dark), 0.02);" data-scroll>
              <div class="tag radius font__size__small mb__1" theme="dark">Citace & Kód</div>
              <blockquote class="border__left inner-x__1 inner-y__05 mb__15" style="border-left-width: 3px; border-color: var(--color-acc);">
                <p class="font__size__default font__family__heading italic mb__025">
                  „Kvalitní typografické měřítko dává webu přirozený rytmus a čitelnost na všech zařízeních.“
                </p>
                <cite class="font__size__small op__6 block">— Design Tokens Architecture</cite>
              </blockquote>

              <div class="font__family__mono font__size__small inner__1 radius border" style="background: rgba(var(--color-dark), 0.05);">
                <code>const typography = { scale: 'fluid', engine: 'kirby' };</code>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

    <!-- ========================================================================= -->
    <!-- TAB 2: BARVY & PALETY -->
    <!-- ========================================================================= -->
    <div id="pane-colors" class="theme-main-pane" style="display: none;" data-scroll>
      <div class="border radius inner__2" style="background: rgba(var(--color-dark), 0.02);" data-scroll>
        
        <!-- Header & Add Color Action Bar -->
        <div class="flex justify__between align__center flex__wrap gap__1 mb__2 pb__15 border__bottom" style="border-color: rgba(var(--color-dark), 0.1);">
          <div>
            <div class="tag radius font__size__small mb__05" theme="dark">Správa barev & tokenů</div>
            <h2 class="font__size__default font__family__heading font__weight__bold">Barevné tokeny</h2>
            <p class="font__size__small op__7">Upravujte hodnoty existujících barev, přidávejte nové nebo odebírejte nepotřebné tokeny.</p>
          </div>

          <!-- Add Color Bar -->
          <div class="flex align__center gap__05 flex__wrap">
            <input type="text" id="new-color-name" placeholder="Název tokenu (např. brand, info)" style="width: 220px; height: 36px; min-height: 36px; padding: 4px 10px; border-radius: 6px; font-size: 12.5px; background: rgba(var(--color-dark), 0.04); border: 1px solid rgba(var(--color-dark), 0.18);">
            <input type="color" id="new-color-picker" value="#3b82f6" style="width: 40px; height: 36px; min-height: 36px; padding: 0; border: none; cursor: pointer; border-radius: 6px;">
            <button type="button" id="add-color-btn" class="button border radius" theme="dark" hover="acc" style="padding: 6px 14px; font-size: 12px;">
              <span>+ Přidat barvu</span>
            </button>
          </div>
        </div>

        <!-- Color Cards Grid -->
        <div id="dynamic-color-grid" class="grid__3 mobile:grid__1 gap__1"></div>

      </div>
    </div>

    <!-- ========================================================================= -->
    <!-- TAB 3: TLAČÍTKA, TAGY & LINKY -->
    <!-- ========================================================================= -->
    <div id="pane-buttons" class="theme-main-pane" style="display: none;" data-scroll>
      <div class="theme-studio-layout">
        
        <!-- Controls Sidebar -->
        <div class="theme-studio-controls">
          <div class="tag radius font__size__small" theme="dark" style="width: fit-content;">Nastavení tlačítek</div>
          
          <div>
            <label class="font__size__small op__7 block mb__025 font__weight__bold">Vnitřní odsazení (Padding)</label>
            <input type="text" name="btn-padding" placeholder="0.5rem 1rem" data-theme-setup>
          </div>
          <div>
            <label class="font__size__small op__7 block mb__025 font__weight__bold">Zakulacení (Radius px)</label>
            <input type="number" name="btn-radius" step="1" min="0" max="50" data-theme-setup>
          </div>
          <div>
            <label class="font__size__small op__7 block mb__025 font__weight__bold">Tloušťka ohraničení (Border px)</label>
            <input type="number" name="btn-border" step="1" min="0" max="10" data-theme-setup>
          </div>
        </div>

        <!-- Live Preview Showcase -->
        <div class="theme-studio-preview">
          <div class="border radius inner__2" style="background: rgba(var(--color-dark), 0.02);" data-scroll>
            <h3 class="font__size__default font__family__heading font__weight__bold mb__1">Varianty tlačítek (Theme Matrix)</h3>
            <div class="flex gap__1 flex__wrap align__center mb__2">
              <button class="button border radius" theme="dark" hover="acc">
                <span>Theme Dark</span>
              </button>
              <button class="button border radius" theme="light" hover="dark">
                <span>Theme Light</span>
              </button>
              <button class="button border radius" theme="invert" hover="acc">
                <span>Theme Invert</span>
              </button>
              <button class="button border radius" theme="acc" hover="dark">
                <span>Theme Accent</span>
              </button>
              <button class="button border radius" theme="ghost" hover="dark">
                <span>Theme Ghost</span>
              </button>
              <button class="button border radius" disabled>
                <span>Disabled State</span>
              </button>
            </div>

            <h3 class="font__size__default font__family__heading font__weight__bold mb__1">Tlačítka s ikonami a modifikátory</h3>
            <div class="flex gap__1 flex__wrap align__center mb__2">
              <button class="button border radius upper" theme="dark" hover="acc">
                <span>Uppercase Button</span>
              </button>
              
              <button class="button border radius flex align__center gap__05" theme="dark" hover="acc">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
                <span>Zpět</span>
              </button>

              <button class="button border radius flex align__center gap__05" theme="acc" hover="dark">
                <span>Pokračovat</span>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
              </button>

              <button class="button border radius flex align__center justify__center" theme="ghost" hover="dark" style="width: 38px; height: 38px; padding: 0;" aria-label="Hledat">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <circle cx="11" cy="11" r="8"></circle>
                  <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
              </button>
            </div>

            <h3 class="font__size__default font__family__heading font__weight__bold mb__1">Štítky & Tagy (Badges)</h3>
            <div class="flex gap__05 flex__wrap align__center">
              <span class="tag radius font__size__small" theme="dark">Dark Tag</span>
              <span class="tag radius font__size__small" theme="light">Light Tag</span>
              <span class="tag radius font__size__small" theme="acc">Accent Tag</span>
              <span class="tag radius font__size__small" theme="invert">Invert Tag</span>
              <span class="tag radius font__size__small flex align__center gap__025" theme="dark">
                <span style="display: inline-block; width: 6px; height: 6px; border-radius: 50%; background: #10b981;"></span>
                Active Status
              </span>
            </div>
          </div>
        </div>

      </div>
    </div>

    <!-- ========================================================================= -->
    <!-- TAB 4: POVRCHY, RÁDIUS & ROZESTUPY -->
    <!-- ========================================================================= -->
    <div id="pane-surfaces" class="theme-main-pane" style="display: none;" data-scroll>
      <div class="theme-studio-layout">
        
        <!-- Controls Sidebar -->
        <div class="theme-studio-controls">
          <div class="tag radius font__size__small" theme="dark" style="width: fit-content;">Rádius & Rozestupy</div>
          
          <div>
            <label class="font__size__small op__7 block mb__025 font__weight__bold">Global Radius (rem)</label>
            <input type="number" name="radius" step="0.1" min="0" max="10" data-theme-setup>
          </div>
          <div>
            <label class="font__size__small op__7 block mb__025 font__weight__bold">Image Radius (rem)</label>
            <input type="number" name="img-radius" step="0.1" min="0" max="10" data-theme-setup>
          </div>
          <div class="border__top pt__1 mt__05" style="border-color: rgba(var(--color-dark), 0.1);">
            <label class="font__size__small op__7 block mb__025 font__weight__bold">Min Scale</label>
            <input type="number" name="scale-min" step="0.05" min="0.2" max="3" data-theme-setup style="margin-bottom: 0.5rem;">
            
            <label class="font__size__small op__7 block mb__025 font__weight__bold">Fluid Scale</label>
            <input type="number" name="scale-fluid" step="0.1" min="0" max="10" data-theme-setup style="margin-bottom: 0.5rem;">

            <label class="font__size__small op__7 block mb__025 font__weight__bold">Global Scale Modifier</label>
            <input type="number" name="scale" step="0.05" min="0.2" max="3" data-theme-setup>
          </div>
        </div>

        <!-- Live Preview Showcase -->
        <div class="theme-studio-preview">
          <div class="grid gap__1" data-scroll>
            <div class="border radius inner__15" style="background: rgba(var(--color-dark), 0.02);">
              <span class="tag radius font__size__small mb__05" theme="dark">Surface Default</span>
              <h4 class="font__size__default font__family__heading font__weight__bold mb__025">Základní karta</h4>
              <p class="font__size__small color__text op__8">Přebírá <code>--radius</code> a standardní ohraničení.</p>
            </div>

            <div class="border radius inner__15" theme="dark">
              <span class="tag radius font__size__small mb__05" theme="acc">Surface Dark</span>
              <h4 class="font__size__default font__family__heading font__weight__bold mb__025">Tmavá karta</h4>
              <p class="font__size__small op__8">Invertovaný kontrast a tmavý podklad.</p>
            </div>

            <div class="border radius inner__15" theme="acc">
              <span class="tag radius font__size__small mb__05" theme="dark">Surface Accent</span>
              <h4 class="font__size__default font__family__heading font__weight__bold mb__025">Akcentní karta</h4>
              <p class="font__size__small op__9">Výrazný akcentní podklad pro CTA sekce.</p>
            </div>
          </div>

          <div class="border radius inner__2" style="background: rgba(15, 23, 42, 0.85); backdrop-filter: blur(16px); color: #fff; border-color: rgba(255,255,255,0.15);" data-scroll>
            <span class="tag radius font__size__small mb__05" style="background: rgba(255,255,255,0.1); color: #fff;">Glassmorphism Surface</span>
            <h3 class="font__size__default font__family__heading font__weight__bold mb__05">Moderní skleněný povrch</h3>
            <p class="font__size__small op__8 max-w__800" style="line-height: 1.5;">
              Využívá <code>backdrop-filter: blur(16px)</code> a translucentní ohraničení s jemným stínováním pro moderní vrstvené rozhraní.
            </p>
          </div>
        </div>

      </div>
    </div>

    <!-- ========================================================================= -->
    <!-- TAB 5: FORMULÁŘE & INPUTY -->
    <!-- ========================================================================= -->
    <div id="pane-forms" class="theme-main-pane" style="display: none;" data-scroll>
      <div class="theme-studio-layout">
        
        <!-- Controls Sidebar -->
        <div class="theme-studio-controls">
          <div class="tag radius font__size__small" theme="dark" style="width: fit-content;">Nastavení formulářů</div>
          <p class="font__size__small op__7">Vzhled a zakulacení vstupních polí se řídí globálním nastavením <code>--radius</code>.</p>
          
          <div>
            <label class="font__size__small op__7 block mb__025 font__weight__bold">Zakulacení rohů (Radius)</label>
            <input type="number" name="radius" step="0.1" min="0" max="5" data-theme-setup>
          </div>
        </div>

        <!-- Live Preview Showcase -->
        <div class="theme-studio-preview">
          <div class="grid__2 mobile:grid__1 gap__2">
            
            <div class="border radius inner__2" style="background: rgba(var(--color-dark), 0.02);" data-scroll>
              <h3 class="font__size__default font__family__heading font__weight__bold mb__1">Základní textová pole</h3>
              
              <div class="grid gap__1">
                <div>
                  <label class="font__size__small op__7 block mb__025 font__weight__bold">Jméno a příjmení</label>
                  <input type="text" placeholder="Např. Jan Novák">
                </div>
                <div>
                  <label class="font__size__small op__7 block mb__025 font__weight__bold">E-mailová adresa</label>
                  <input type="email" placeholder="jan@example.com">
                </div>
                <div>
                  <label class="font__size__small op__7 block mb__025 font__weight__bold">Výběrové pole (Select)</label>
                  <select>
                    <option>Vyberte možnost...</option>
                    <option>První varianta</option>
                    <option>Druhá varianta</option>
                  </select>
                </div>
                <div>
                  <label class="font__size__small op__7 block mb__025 font__weight__bold">Zpráva (Textarea)</label>
                  <textarea rows="3" placeholder="Napište zprávu..."></textarea>
                </div>
              </div>
            </div>

            <div class="border radius inner__2" style="background: rgba(var(--color-dark), 0.02);" data-scroll>
              <h3 class="font__size__default font__family__heading font__weight__bold mb__1">Zaškrtávací pole & Přepínače</h3>
              
              <div class="grid gap__1">
                <label class="flex align__center gap__05 cursor__pointer">
                  <input type="checkbox" checked style="width: 18px; height: 18px; min-height: 18px; cursor: pointer;">
                  <span class="font__size__small">Aktivní zaškrtávací pole (Checkbox)</span>
                </label>
                <label class="flex align__center gap__05 cursor__pointer">
                  <input type="checkbox" style="width: 18px; height: 18px; min-height: 18px; cursor: pointer;">
                  <span class="font__size__small">Neaktivní checkbox</span>
                </label>
                
                <div class="border__top pt__1 mt__05" style="border-color: rgba(var(--color-dark), 0.1);">
                  <label class="flex align__center gap__05 cursor__pointer mb__05">
                    <input type="radio" name="demo-radio" checked style="width: 18px; height: 18px; min-height: 18px; cursor: pointer;">
                    <span class="font__size__small">Radio možnost A</span>
                  </label>
                  <label class="flex align__center gap__05 cursor__pointer">
                    <input type="radio" name="demo-radio" style="width: 18px; height: 18px; min-height: 18px; cursor: pointer;">
                    <span class="font__size__small">Radio možnost B</span>
                  </label>
                </div>
              </div>
            </div>

          </div>
        </div>

      </div>
    </div>

    <!-- ========================================================================= -->
    <!-- TAB 6: ANIMACE & INTERAKTIVNÍ ATOMY -->
    <!-- ========================================================================= -->
    <div id="pane-interactive" class="theme-main-pane" style="display: none;" data-scroll>
      <div class="theme-studio-layout">
        
        <!-- Controls Sidebar -->
        <div class="theme-studio-controls">
          <div class="tag radius font__size__small" theme="dark" style="width: fit-content;">Nastavení animací</div>
          
          <div>
            <label class="font__size__small op__7 block mb__025 font__weight__bold">Délka animace (Duration)</label>
            <input type="text" name="animation-duration" placeholder="800ms" data-theme-setup>
          </div>
          <div>
            <label class="font__size__small op__7 block mb__025 font__weight__bold">Prodleva (Delay)</label>
            <input type="text" name="animation-delay" placeholder="0ms" data-theme-setup>
          </div>
          <div>
            <label class="font__size__small op__7 block mb__025 font__weight__bold">Časovací křivka (Timing Curve)</label>
            <select name="animation-timing" data-theme-setup>
              <option value="cubic-bezier(0.4, 0, 0.2, 1)">Material Standard (0.4, 0, 0.2, 1)</option>
              <option value="cubic-bezier(0.25, 1, 0.5, 1)">Cubic Out (Smooth)</option>
              <option value="cubic-bezier(0.16, 1, 0.3, 1)">Expo Out (Snappy)</option>
              <option value="ease">Ease</option>
              <option value="linear">Linear</option>
            </select>
          </div>
        </div>

        <!-- Live Preview Showcase -->
        <div class="theme-studio-preview">
          <div class="border radius inner__2" style="background: rgba(var(--color-dark), 0.02);" data-scroll>
            <h3 class="font__size__default font__family__heading font__weight__bold mb__1">Organismus Tabs (Živá ukázka)</h3>
            
            <div class="interactive-tabs-demo grid gap__1">
              <div class="flex gap__05 border__bottom pb__05" style="border-color: rgba(var(--color-dark), 0.1);">
                <button class="demo-tab-btn is-active button border radius" data-demo="tab1" theme="dark">
                  <span>Přehled</span>
                </button>
                <button class="demo-tab-btn button border radius" data-demo="tab2" theme="ghost" hover="dark">
                  <span>Vlastnosti</span>
                </button>
                <button class="demo-tab-btn button border radius" data-demo="tab3" theme="ghost" hover="dark">
                  <span>Dokumentace</span>
                </button>
              </div>

              <div id="demo-tab1" class="demo-pane inner__1">
                <h4 class="font__size__default font__weight__bold mb__025">Obsah první záložky</h4>
                <p class="font__size__small color__text op__8">Komponenta Tabs z U1 zajišťuje plynulé přepínání bez refreshe stránky.</p>
              </div>
              <div id="demo-tab2" class="demo-pane inner__1" style="display: none;">
                <h4 class="font__size__default font__weight__bold mb__025">Vlastnosti komponenty</h4>
                <p class="font__size__small color__text op__8">Podporuje klávesovou navigaci, accessibility atributy a dynamické přepínání stylů.</p>
              </div>
              <div id="demo-tab3" class="demo-pane inner__1" style="display: none;">
                <h4 class="font__size__default font__weight__bold mb__025">Dokumentace použití</h4>
                <p class="font__size__small color__text op__8">Použijte <code>snippet('organisms/Tabs')</code> pro vložení kamkoliv do šablon.</p>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

  </div>
</div>

<style>
.theme-studio-layout {
  display: grid;
  grid-template-columns: 320px 1fr;
  gap: 2rem;
  align-items: start;
  width: 100%;
}
@media (max-width: 960px) {
  .theme-studio-layout {
    grid-template-columns: 1fr;
    gap: 1.5rem;
  }
}
.theme-studio-controls {
  position: sticky;
  top: 2rem;
  background: rgba(var(--color-dark), 0.03);
  border: 1px solid rgba(var(--color-dark), 0.1);
  border-radius: var(--radius, 12px);
  padding: 1.25rem;
  display: flex;
  flex-direction: column;
  gap: 0.85rem;
  box-sizing: border-box;
}
.theme-studio-controls input,
.theme-studio-controls select {
  min-height: 36px !important;
  height: 36px;
  padding: 4px 10px !important;
  border-radius: 6px !important;
  font-size: 12.5px !important;
  background: rgba(var(--color-dark), 0.04);
  border: 1px solid rgba(var(--color-dark), 0.18);
  box-sizing: border-box;
  width: 100%;
}
.theme-studio-preview {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
  min-width: 0;
  width: 100%;
}
</style>

<script>
window.updateScrollEngine = function() {
  window.dispatchEvent(new Event('resize'));
  if (window.SCROLL) {
    if (typeof window.SCROLL.start === 'function') window.SCROLL.start();
    if (typeof window.SCROLL.resize === 'function') window.SCROLL.resize();
  }
  if (window.REVEAL && typeof window.REVEAL.refresh === 'function') {
    window.REVEAL.refresh();
  }
};

window.switchThemeTab = function(targetId, btn) {
  const buttons = document.querySelectorAll('.theme-main-tab-btn');
  buttons.forEach(b => {
    b.classList.remove('is-active');
    b.setAttribute('theme', 'ghost');
  });

  if (btn) {
    btn.classList.add('is-active');
    btn.setAttribute('theme', 'dark');
  } else {
    const match = document.querySelector(`.theme-main-tab-btn[data-target="${targetId}"]`);
    if (match) {
      match.classList.add('is-active');
      match.setAttribute('theme', 'dark');
    }
  }

  const panes = document.querySelectorAll('.theme-main-pane');
  panes.forEach(p => {
    p.style.display = 'none';
  });

  const active = document.getElementById(targetId);
  if (active) {
    active.style.display = 'block';
  }

  setTimeout(window.updateScrollEngine, 50);
};

window.syncFonts = async function(btn) {
  const originalContent = btn ? btn.innerHTML : '';
  if (btn) {
    btn.disabled = true;
    btn.innerHTML = '<span>⏳ Načítám...</span>';
  }

  try {
    const response = await fetch('<?= $page->url() ?>', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: new URLSearchParams({ action: 'sync-fonts' })
    });

    const data = await response.json();
    if (data.status === 'success' && Array.isArray(data.fonts)) {
      document.querySelectorAll('[data-font-select]').forEach(dropdown => {
        const currentVal = dropdown.value;
        dropdown.innerHTML = '';
        data.fonts.forEach(fontName => {
          const opt = document.createElement('option');
          opt.value = fontName;
          opt.textContent = fontName;
          dropdown.appendChild(opt);
        });
        if (currentVal && Array.from(dropdown.options).some(o => o.value === currentVal)) {
          dropdown.value = currentVal;
        }
      });
      if (typeof window.syncUIWithCSS === 'function') {
        window.syncUIWithCSS();
      }
      if (btn) {
        btn.innerHTML = '<span>✓ Načteno!</span>';
        setTimeout(() => {
          btn.innerHTML = originalContent;
          btn.disabled = false;
        }, 2000);
      }
      return;
    }
  } catch (err) {
    console.error('Font sync error:', err);
    if (btn) {
      btn.innerHTML = '<span>✕ Chyba</span>';
      setTimeout(() => {
        btn.innerHTML = originalContent;
        btn.disabled = false;
      }, 2000);
    }
  }
};

function initThemeStudio() {
  // Delegated click handler for demo tabs and canvas switcher
  document.addEventListener('click', (e) => {
    // Demo tabs inside preview
    const demoBtn = e.target.closest('.demo-tab-btn');
    if (demoBtn) {
      e.preventDefault();
      const paneId = 'demo-' + demoBtn.dataset.demo;
      document.querySelectorAll('.demo-tab-btn').forEach(b => {
        b.classList.remove('is-active');
        b.setAttribute('theme', 'ghost');
      });
      document.querySelectorAll('.demo-pane').forEach(p => p.style.display = 'none');

      demoBtn.classList.add('is-active');
      demoBtn.setAttribute('theme', 'dark');
      const targetPane = document.getElementById(paneId);
      if (targetPane) targetPane.style.display = 'block';

      setTimeout(window.updateScrollEngine, 50);
      return;
    }

    // Top Canvas Theme Switcher
    const canvasBtn = e.target.closest('.theme-switch-btn');
    if (canvasBtn) {
      e.preventDefault();
      const mode = canvasBtn.dataset.canvas;
      if (mode === 'default') {
        document.documentElement.removeAttribute('theme');
      } else {
        document.documentElement.setAttribute('theme', mode);
      }
      return;
    }
  });

  // --- THEME LIVE ENGINE ---
  const dynamicColorGrid = document.getElementById('dynamic-color-grid');
  const tsSelect = document.getElementById('ts-select');
  const tsInput = document.getElementById('ts-input');
  const bsSelect = document.getElementById('bs-select');
  const bsInput = document.getElementById('bs-input');
  const resetBtn = document.getElementById('theme-reset-btn');

  function getRawThemeDeclarations() {
    const rawTokens = {};
    Array.from(document.styleSheets).forEach(sheet => {
      try {
        const rules = sheet.cssRules || sheet.rules;
        if (!rules) return;
        Array.from(rules).forEach(rule => {
          if (rule.selectorText === ':root' || rule.selectorText === '[theme]') {
            for (let i = 0; i < rule.style.length; i++) {
              const propName = rule.style[i];
              if (propName.startsWith('--')) {
                const tokenKey = propName.substring(2);
                rawTokens[tokenKey] = rule.style.getPropertyValue(propName).trim();
              }
            }
          }
        });
      } catch(e) {}
    });
    return rawTokens;
  }

  const phpDiscoveredFonts = <?= json_encode(array_values($availableFonts)) ?>;

  function discoverAndPopulateFonts() {
    const discoveredFonts = new Set(phpDiscoveredFonts);
    const bannedFonts = ['sans-serif', 'serif', 'monospace', 'inherit', 'initial', 'unset'];

    try {
      Array.from(document.styleSheets).forEach(sheet => {
        try {
          const rules = sheet.cssRules || sheet.rules;
          if (!rules) return;
          Array.from(rules).forEach(rule => {
            try {
              if (rule.type === CSSRule.FONT_FACE_RULE) {
                let family = rule.style.getPropertyValue('font-family') || rule.style.fontFamily;
                if (family) {
                  family = family.trim().replace(/['"]/g, ''); 
                  if (family && !family.startsWith('var(') && !bannedFonts.includes(family.toLowerCase())) {
                    discoveredFonts.add(family);
                  }
                }
              }
              if (rule.type === CSSRule.IMPORT_RULE && rule.href && rule.href.includes('fonts.googleapis.com')) {
                const urlParams = new URLSearchParams(rule.href.split('?')[1]);
                const families = urlParams.getAll('family');
                families.forEach(f => {
                  const name = f.split(':')[0].replace(/_/g, ' ');
                  if (name && !name.startsWith('var(') && !bannedFonts.includes(name.toLowerCase())) {
                    discoveredFonts.add(name);
                  }
                });
              }
            } catch(e) {}
          });
        } catch(e) {}
      });
    } catch(e) {}

    const fontDropdowns = document.querySelectorAll('[data-font-select]');
    fontDropdowns.forEach(dropdown => {
      const currentVal = dropdown.value;
      dropdown.innerHTML = ''; 
      discoveredFonts.forEach(fontName => {
        const opt = document.createElement('option');
        opt.value = fontName;
        opt.textContent = fontName;
        dropdown.appendChild(opt);
      });
      if (currentVal && Array.from(dropdown.options).some(o => o.value === currentVal)) {
        dropdown.value = currentVal;
      }
    });
  }

  // --- THEME LIVE ENGINE ---
  const newColorNameInput = document.getElementById('new-color-name');
  const newColorPicker = document.getElementById('new-color-picker');
  const addColorBtn = document.getElementById('add-color-btn');
  const deletedColorTokens = new Set();
  const addedColorTokens = new Set();

  function rgbToHex(rgbStr) {
    if (!rgbStr) return '#000000';
    if (rgbStr.startsWith('#')) return rgbStr;
    const match = rgbStr.match(/\d+/g);
    if (!match || match.length < 3) return '#000000';
    const r = parseInt(match[0]).toString(16).padStart(2, '0');
    const g = parseInt(match[1]).toString(16).padStart(2, '0');
    const b = parseInt(match[2]).toString(16).padStart(2, '0');
    return `#${r}${g}${b}`;
  }

  function hexToRgbTuple(hex) {
    hex = hex.replace(/^#/, '');
    if (hex.length === 3) hex = hex.split('').map(c => c + c).join('');
    const num = parseInt(hex, 16);
    return `${(num >> 16) & 255}, ${(num >> 8) & 255}, ${num & 255}`;
  }

  function getAllColorTokens() {
    const rawTokens = getRawThemeDeclarations();
    const tokenSet = new Set();

    // From stylesheet declarations
    Object.keys(rawTokens).forEach(key => {
      if (key.startsWith('color-')) tokenSet.add(key);
    });

    // From inline styles
    for (let i = 0; i < document.documentElement.style.length; i++) {
      const prop = document.documentElement.style[i];
      if (prop.startsWith('--color-')) {
        tokenSet.add(prop.substring(2));
      }
    }

    // From added list
    addedColorTokens.forEach(token => tokenSet.add(token));

    // Remove deleted
    deletedColorTokens.forEach(token => tokenSet.delete(token));

    return Array.from(tokenSet);
  }

  function generateDynamicColorPickers() {
    if (!dynamicColorGrid) return;
    const colorTokens = getAllColorTokens();
    dynamicColorGrid.innerHTML = '';

    if (colorTokens.length === 0) {
      dynamicColorGrid.innerHTML = '<div class="span__3 text__center op__6 font__size__small inner__2">Žádné barvy nejsou definovány. Přidejte novou barvu formulářem výše.</div>';
      return;
    }

    colorTokens.forEach(token => {
      const rawVal = document.documentElement.style.getPropertyValue(`--${token}`).trim() || getRawThemeDeclarations()[token] || '0, 0, 0';
      const initialHex = rgbToHex(rawVal);

      const card = document.createElement('div');
      card.className = 'border radius inner__1 flex justify__between align__center gap__1';
      card.style.background = 'rgba(var(--color-dark), 0.03)';
      card.style.boxSizing = 'border-box';

      // Left: Color picker circle / square
      const swatchWrapper = document.createElement('div');
      swatchWrapper.style.position = 'relative';
      swatchWrapper.style.width = '40px';
      swatchWrapper.style.height = '40px';
      swatchWrapper.style.minWidth = '40px';
      swatchWrapper.style.borderRadius = 'var(--radius, 8px)';
      swatchWrapper.style.overflow = 'hidden';
      swatchWrapper.style.border = '1px solid rgba(var(--color-dark), 0.15)';
      swatchWrapper.style.background = initialHex;

      const colorInput = document.createElement('input');
      colorInput.type = 'color';
      colorInput.value = initialHex;
      colorInput.style.position = 'absolute';
      colorInput.style.inset = '-10px';
      colorInput.style.width = '70px';
      colorInput.style.height = '70px';
      colorInput.style.border = 'none';
      colorInput.style.cursor = 'pointer';
      colorInput.style.opacity = '0';

      swatchWrapper.appendChild(colorInput);

      // Middle: Info & HEX editor
      const infoWrapper = document.createElement('div');
      infoWrapper.style.flex = '1';
      infoWrapper.style.minWidth = '0';

      const tokenLabel = document.createElement('div');
      tokenLabel.className = 'font__size__small font__weight__bold font__family__mono truncate';
      tokenLabel.textContent = `--${token}`;
      tokenLabel.title = `--${token}`;

      const hexInput = document.createElement('input');
      hexInput.type = 'text';
      hexInput.value = initialHex.toUpperCase();
      hexInput.style.width = '84px';
      hexInput.style.height = '26px';
      hexInput.style.minHeight = '26px';
      hexInput.style.padding = '2px 6px';
      hexInput.style.fontSize = '11px';
      hexInput.style.fontFamily = 'monospace';
      hexInput.style.marginTop = '3px';
      hexInput.style.borderRadius = '4px';
      hexInput.style.background = 'rgba(var(--color-dark), 0.05)';
      hexInput.style.border = '1px solid rgba(var(--color-dark), 0.15)';

      const rgbLabel = document.createElement('div');
      rgbLabel.className = 'font__size__small op__5 font__family__mono';
      rgbLabel.style.fontSize = '10px';
      rgbLabel.style.marginTop = '2px';
      rgbLabel.textContent = `rgb(${rawVal})`;

      infoWrapper.appendChild(tokenLabel);
      infoWrapper.appendChild(hexInput);
      infoWrapper.appendChild(rgbLabel);

      // Event for native color input
      colorInput.addEventListener('input', (e) => {
        const hex = e.target.value;
        const rgbValues = hexToRgbTuple(hex);
        document.documentElement.style.setProperty(`--${token}`, rgbValues);
        swatchWrapper.style.background = hex;
        hexInput.value = hex.toUpperCase();
        rgbLabel.textContent = `rgb(${rgbValues})`;
      });

      // Event for manual HEX text input
      hexInput.addEventListener('input', (e) => {
        let hex = e.target.value.trim();
        if (!hex.startsWith('#')) hex = '#' + hex;
        if (/^#[0-9A-Fa-f]{6}$/.test(hex)) {
          const rgbValues = hexToRgbTuple(hex);
          document.documentElement.style.setProperty(`--${token}`, rgbValues);
          swatchWrapper.style.background = hex;
          colorInput.value = hex;
          rgbLabel.textContent = `rgb(${rgbValues})`;
        }
      });

      // Right: Remove Button
      const removeBtn = document.createElement('button');
      removeBtn.type = 'button';
      removeBtn.className = 'button border radius';
      removeBtn.setAttribute('theme', 'ghost');
      removeBtn.setAttribute('hover', 'dark');
      removeBtn.style.padding = '4px 8px';
      removeBtn.style.fontSize = '12px';
      removeBtn.title = `Odebrat --${token}`;
      removeBtn.innerHTML = '<span>✕</span>';

      removeBtn.addEventListener('click', () => {
        if (confirm(`Opravdu chcete odebrat barevný token --${token}?`)) {
          document.documentElement.style.removeProperty(`--${token}`);
          deletedColorTokens.add(token);
          addedColorTokens.delete(token);
          generateDynamicColorPickers();
          setTimeout(window.updateScrollEngine, 50);
        }
      });

      card.appendChild(swatchWrapper);
      card.appendChild(infoWrapper);
      card.appendChild(removeBtn);
      dynamicColorGrid.appendChild(card);
    });
  }

  // Add Color Handler
  if (addColorBtn && newColorNameInput && newColorPicker) {
    const handleAddColor = () => {
      let rawName = newColorNameInput.value.trim().toLowerCase();
      if (!rawName) {
        alert('Zadejte prosím název barvy (např. brand, info, primary).');
        return;
      }
      rawName = rawName.replace(/^--/, '').replace(/^color-/, '').replace(/[^a-z0-9-_]/g, '-');
      const tokenKey = 'color-' + rawName;
      const hex = newColorPicker.value;
      const rgbValues = hexToRgbTuple(hex);

      deletedColorTokens.delete(tokenKey);
      addedColorTokens.add(tokenKey);
      document.documentElement.style.setProperty(`--${tokenKey}`, rgbValues);

      newColorNameInput.value = '';
      generateDynamicColorPickers();
      setTimeout(window.updateScrollEngine, 50);
    };

    addColorBtn.addEventListener('click', handleAddColor);
    newColorNameInput.addEventListener('keydown', (e) => {
      if (e.key === 'Enter') {
        e.preventDefault();
        handleAddColor();
      }
    });
  }

  window.syncUIWithCSS = function() {
    const rawTokens = getRawThemeDeclarations();
    document.querySelectorAll('[data-theme-setup]').forEach(element => {
      const token = element.getAttribute('name');
      if (!token) return;
      let computedVal = getComputedStyle(document.documentElement).getPropertyValue(`--${token}`).trim();
      if (!computedVal) computedVal = rawTokens[token] || '';

      const unit = element.dataset.unit;
      if (unit && computedVal.endsWith(unit)) {
        computedVal = computedVal.replace(unit, '').trim();
      }

      if (element.tagName === 'SELECT') {
        const cleanVal = computedVal.replace(/['"]/g, '').split(',')[0].trim();
        let matched = false;
        Array.from(element.options).forEach(opt => {
          if (opt.value.toLowerCase() === cleanVal.toLowerCase() || opt.value.toLowerCase() === computedVal.toLowerCase()) {
            element.value = opt.value;
            matched = true;
          }
        });
        if (!matched && cleanVal && element.hasAttribute('data-font-select')) {
          const newOpt = document.createElement('option');
          newOpt.value = cleanVal;
          newOpt.textContent = cleanVal;
          element.appendChild(newOpt);
          element.value = cleanVal;
        }
      } else if (element.type === 'number') {
        element.value = parseFloat(computedVal) || '';
      } else {
        element.value = computedVal;
      }
    });

    // Heading scale sync
    if (tsSelect && tsInput) {
      const tsVal = rawTokens['type-scale'] || '1.618';
      tsInput.value = tsVal;
      const match = Array.from(tsSelect.options).find(opt => opt.value === tsVal);
      tsSelect.value = match ? match.value : 'custom';
    }

    // Body scale sync
    if (bsSelect && bsInput) {
      const bsVal = rawTokens['body-scale'] || '1.400';
      bsInput.value = bsVal;
      const match = Array.from(bsSelect.options).find(opt => opt.value === bsVal);
      bsSelect.value = match ? match.value : 'custom';
    }
  };

  discoverAndPopulateFonts();
  generateDynamicColorPickers();
  window.syncUIWithCSS();

  // Generic data-theme-setup listeners
  document.querySelectorAll('[data-theme-setup]').forEach(input => {
    input.addEventListener('input', (e) => {
      const target = e.target;
      const token = target.getAttribute('name');
      if (!token) return;

      let value = target.value;
      const unit = target.dataset.unit;
      if (unit && value && !value.endsWith(unit)) {
        value += unit;
      }

      document.documentElement.style.setProperty(`--${token}`, value);
    });
  });

  // Heading typescale custom select & input
  if (tsSelect && tsInput) {
    tsSelect.addEventListener('change', () => {
      if (tsSelect.value !== 'custom') {
        document.documentElement.style.setProperty('--type-scale', tsSelect.value);
        tsInput.value = tsSelect.value;
      }
    });
    tsInput.addEventListener('input', () => {
      const val = tsInput.value ? parseFloat(tsInput.value) : 1.618;
      document.documentElement.style.setProperty('--type-scale', val);
    });
  }

  // Body scale custom select & input
  if (bsSelect && bsInput) {
    bsSelect.addEventListener('change', () => {
      if (bsSelect.value !== 'custom') {
        document.documentElement.style.setProperty('--body-scale', bsSelect.value);
        bsInput.value = bsSelect.value;
      }
    });
    bsInput.addEventListener('input', () => {
      const val = bsInput.value ? parseFloat(bsInput.value) : 1.400;
      document.documentElement.style.setProperty('--body-scale', val);
    });
  }

  // Reset Button
  if (resetBtn) {
    resetBtn.addEventListener('click', () => {
      const rawTokens = getRawThemeDeclarations();
      Object.keys(rawTokens).forEach(tokenName => {
        document.documentElement.style.removeProperty(`--${tokenName}`);
      });
      document.documentElement.style.removeProperty('--type-scale');
      document.documentElement.style.removeProperty('--body-scale');
      document.documentElement.removeAttribute('theme');
      window.syncUIWithCSS();
      generateDynamicColorPickers();
      setTimeout(window.updateScrollEngine, 50);
    });
  }

  // Save Form Synchronous CSS Payload Exporter
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
        animations: ['animation-duration', 'animation-delay', 'animation-stagger', 'animation-timing', 'toggle-parallax', 'toggle-reveals'],
        images: ['img-radius', 'radius'],
        buttons: ['btn-padding', 'btn-radius', 'btn-border'],
        colors: []
      };

      groups.colors = getAllColorTokens();

      let cssOutputString = "/**\n * Design Tokens Live Export\n * Saved via Kirby Theme Studio\n */\n\n:root {\n";

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
      tokensInput.value = cssOutputString;
    });
  }

  // Trigger initial scroll height calculation & reveal observer
  setTimeout(window.updateScrollEngine, 100);
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initThemeStudio);
} else {
  initThemeStudio();
}
</script>
