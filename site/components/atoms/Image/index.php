<?php
$file = $image ?? ($file ?? false);
if (!$file) return;

$alt     = $alt     ?? ($file->alt()->value() ?: $file->name());
$caption = $caption ?? ($file->caption()->value() ?: false);
$css     = $css     ?? '';
?>
<figure class="figure <?= $css ?>">
  <img src="<?= $file->url() ?>" alt="<?= html($alt) ?>" loading="lazy">
  <?php if ($caption): ?>
    <figcaption><?= html($caption) ?></figcaption>
  <?php endif ?>
</figure>
