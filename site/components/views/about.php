<?php snippet('layout', slots: true) ?>

<article class="page-article">
  <?php snippet('atoms/Heading', ['level' => 'h1', 'text' => $page->title()->value()]) ?>
  <div class="page-content">
    <?= $page->text()->kt() ?>
  </div>
</article>

<?php endsnippet() ?>
