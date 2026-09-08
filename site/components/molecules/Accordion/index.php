<?php
$items = $items ?? [];
?>
<div class="accordion">
  <?php foreach ($items as $item): ?>
    <details class="accordion-item">
      <summary class="accordion-header"><?= html($item->title()->value() ?: $item['title']) ?></summary>
      <div class="accordion-body"><?= kirbytext($item->text()->value() ?: $item['text']) ?></div>
    </details>
  <?php endforeach ?>
</div>
