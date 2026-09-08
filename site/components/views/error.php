<?php snippet('layout', slots: true) ?>

<section class="hero hero-error">
  <h1><?= $page->headline()->or('Chyba 404')->html() ?></h1>
  <p class="intro"><?= $page->text()->html() ?></p>
  <p style="margin-top: 2rem;">
    <a href="<?= $site->url() ?>" class="btn">ZpÄ›t na ĂşvodnĂ­ strĂˇnku</a>
  </p>
</section>

<?php endsnippet() ?>
