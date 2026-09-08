<?php snippet('layout', slots: true) ?>

<?php snippet('organisms/Hero', [
  'headline' => $page->headline()->or($page->title())->value(),
  'intro'    => $page->intro()->value(),
  'button'   => ['label' => 'ZaÄŤĂ­t projekt', 'url' => '#features', 'style' => 'primary']
]) ?>

<?php if ($page->layout_blocks()->isNotEmpty()): ?>
  <div class="blocks-container" id="features">
    <?php foreach ($page->layout_blocks()->toBlocks() as $block): ?>
      <div class="block-item block-<?= $block->type() ?>">
        <?= $block ?>
      </div>
    <?php endforeach ?>
  </div>
<?php endif ?>

<?php endsnippet() ?>
