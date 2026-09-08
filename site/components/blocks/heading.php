<?php $level = $block->level()->or('h2')->value(); ?>
<div class="block-heading">
  <<?= $level ?>><?= $block->text()->html() ?></<?= $level ?>>
</div>
