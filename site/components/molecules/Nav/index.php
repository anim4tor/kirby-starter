<?php
$items = $items ?? site()->children()->listed();
?>
<nav class="nav-menu">
  <?php foreach ($items as $item): ?>
    <a href="<?= $item->url() ?>" class="nav-link <?= $item->isOpen() ? 'is-active' : '' ?>">
      <?= $item->title()->html() ?>
    </a>
  <?php endforeach ?>
</nav>
