<?php snippet('layout', slots: true) ?>

<article class="page-article">
  <h1><?= $page->title()->html() ?></h1>
  <div class="page-content">
    <?= $page->text()->toBlocks() ?>
  </div>
</article>

<?php endsnippet() ?>
