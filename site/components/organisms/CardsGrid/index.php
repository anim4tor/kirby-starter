<?php
$items = $items ?? [];
?>
<section class="cards-grid-section">
  <div class="cards-grid">
    <?php foreach ($items as $card): ?>
      <?php snippet('molecules/Card', $card) ?>
    <?php endforeach ?>
  </div>
</section>
