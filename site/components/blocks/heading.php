<?php $level = $block->level()->or('h2')->value(); ?>
<div class="block-heading inner-t__1">
  <<?= $level ?> class="font__family__heading"><?= $block->text()->html() ?></<?= $level ?>>
</div>
