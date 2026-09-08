<?php
$title = $title ?? false;
$text  = $text  ?? false;
$link  = $link  ?? false;
$image = $image ?? false;
$badge = $badge ?? false;
?>
<div class="card">
  <?php if ($image): ?>
    <div class="card-media">
      <?php snippet('atoms/Image', ['image' => $image]) ?>
    </div>
  <?php endif ?>
  <div class="card-body">
    <?php if ($badge): ?>
      <?php snippet('atoms/Badge', ['label' => $badge]) ?>
    <?php endif ?>
    <?php if ($title): ?>
      <h3 class="card-title"><?= html($title) ?></h3>
    <?php endif ?>
    <?php if ($text): ?>
      <p class="card-text"><?= html($text) ?></p>
    <?php endif ?>
    <?php if ($link): ?>
      <?php snippet('atoms/Button', ['url' => $link, 'label' => 'VĂ­ce informacĂ­', 'style' => 'outline']) ?>
    <?php endif ?>
  </div>
</div>
