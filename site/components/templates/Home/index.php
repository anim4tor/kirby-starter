<?php
/**
 * Template: Home
 */
?>
<div class="home-template flex flex__column justify__center" data-scroll-section data-scroll style="min-height: 100vh; min-height: 100dvh;">
  <section class="home-hero grid place__start-start gap__2 inner-x__10 inner-y__4 mobile:inner-y__2 mobile:inner-x__1 width__100">
    
    <div class="home-hero__badge tag radius font__size__small mb__1" theme="dark" style="width: max-content;">
      Kirby Starter
    </div>

    <h1 class="home-hero__headline font__size__1 font__family__heading mb__1" data-reveal-text>
      <?= $page->headline()->or($page->title())->html() ?>
    </h1>

    <?php if ($page->intro()->isNotEmpty()): ?>
      <p class="home-hero__intro font__size__large color__text max-w__800 mb__2" style="max-width: 720px; line-height: 1.5;">
        <?= $page->intro()->html() ?>
      </p>
    <?php endif ?>

    <div class="home-hero__actions flex gap__05 align__center flex__wrap mb__3">
      <a href="<?= url('theme') ?>" class="button border" theme="acc" hover="dark">
        <span aria-label="Customize Theme">Customize Theme</span>
      </a>
      <a href="<?= url('panel') ?>" class="button border" theme="dark" hover="acc">
        <span aria-label="Otevřít Kirby Panel">Otevřít Kirby Panel</span>
      </a>
      <a href="https://getkirby.com/docs" target="_blank" rel="noopener" class="button border" theme="ghost" hover="dark">
        <span aria-label="Dokumentace Kirby">Dokumentace Kirby</span>
      </a>
    </div>

    <!-- Quick Starter Overview Cards -->
    <div class="home-features grid__3 mobile:grid__1 gap__1 mb__3">
      <div class="home-card border radius inner__1 flex flex__row gap__1 align__start" style="background: rgba(var(--color-dark), 0.02);">
        <div class="flex align__center justify__center shrink-0" style="width: 36px; height: 36px; border-radius: 8px; background: rgba(var(--color-dark), 0.05); color: var(--color-dark); flex-shrink: 0;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
            <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
          </svg>
        </div>
        <div class="grid gap__1">
          <h3 class="font__size__default font__family__heading font__weight__bold">Kirby CMS</h3>
          <p class="font__size__small color__text" style="opacity: 0.8; line-height: 1.45;">
            Moderní headless & file-based CMS bez nutnosti databáze, bleskově rychlé a snadno rozšiřitelné.
          </p>
        </div>
      </div>
      <div class="home-card border radius inner__1 flex flex__row gap__1 align__start" style="background: rgba(var(--color-dark), 0.02);">
        <div class="flex align__center justify__center shrink-0" style="width: 36px; height: 36px; border-radius: 8px; background: rgba(var(--color-dark), 0.05); color: var(--color-dark); flex-shrink: 0;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
            <line x1="6" y1="3" x2="6" y2="15"></line>
            <circle cx="18" cy="6" r="3"></circle>
            <circle cx="6" cy="18" r="3"></circle>
            <path d="M18 9a9 9 0 0 1-9 9"></path>
          </svg>
        </div>
        <div class="grid gap__1">
          <h3 class="font__size__default font__family__heading font__weight__bold">Git Content Sync</h3>
          <p class="font__size__small color__text" style="opacity: 0.8; line-height: 1.45;">
            Automatická distribuce a obousměrná synchronizace změn obsahu z administrace přímo do Gitu.
          </p>
        </div>
      </div>
      <div class="home-card border radius inner__1 flex flex__row gap__1 align__start" style="background: rgba(var(--color-dark), 0.02);">
        <div class="flex align__center justify__center shrink-0" style="width: 36px; height: 36px; border-radius: 8px; background: rgba(var(--color-dark), 0.05); color: var(--color-dark); flex-shrink: 0;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
            <line x1="4" y1="21" x2="4" y2="14"></line>
            <line x1="4" y1="10" x2="4" y2="3"></line>
            <line x1="12" y1="21" x2="12" y2="12"></line>
            <line x1="12" y1="8" x2="12" y2="3"></line>
            <line x1="20" y1="21" x2="20" y2="16"></line>
            <line x1="20" y1="12" x2="20" y2="3"></line>
            <line x1="1" y1="14" x2="7" y2="14"></line>
            <line x1="9" y1="8" x2="15" y2="8"></line>
            <line x1="17" y1="16" x2="23" y2="16"></line>
          </svg>
        </div>
        <div class="grid gap__1">
          <h3 class="font__size__default font__family__heading font__weight__bold">Theme Engine</h3>
          <p class="font__size__small color__text" style="opacity: 0.8; line-height: 1.45;">
            Živá konfigurace design tokenů, typografického měřítka, fontů a barevných palet.
          </p>
        </div>
      </div>
    </div>
  </section>
</div>