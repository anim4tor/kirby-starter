<?php snippet('layout', slots: true) ?>

<section class="hero">
  <h1><?= $page->headline()->or($page->title())->html() ?></h1>
  <?php if ($page->intro()->isNotEmpty()): ?>
    <p class="intro"><?= $page->intro()->html() ?></p>
  <?php endif ?>
</section>

<?php if ($page->layout_blocks()->isNotEmpty()): ?>
  <div class="blocks-container">
    <?php foreach ($page->layout_blocks()->toBlocks() as $block): ?>
      <div class="block-item block-<?= $block->type() ?>">
        <?= $block ?>
      </div>
    <?php endforeach ?>
  </div>
<?php endif ?>

<?php endsnippet() ?>
