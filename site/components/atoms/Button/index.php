<?php
$url    = (!isset($url)    || trim((string)$url) === '')    ? false : $url;
$label  = (!isset($label)  || trim((string)$label) === '')  ? false : $label;
$type   = $type   ?? 'button';
$style  = $style  ?? 'primary';
$css    = $css    ?? '';
$target = (!empty($target) && ($target === '_blank' || $target === true)) ? 'target="_blank" rel="noopener"' : '';
?>
<?php if ($url): ?>
  <a href="<?= $url ?>" <?= $target ?> class="btn btn-<?= $style ?> <?= $css ?>">
    <?php if ($label): ?><span><?= html($label) ?></span><?php endif ?>
    <?= $slot ?? '' ?>
  </a>
<?php else: ?>
  <button type="<?= $type ?>" class="btn btn-<?= $style ?> <?= $css ?>">
    <?php if ($label): ?><span><?= html($label) ?></span><?php endif ?>
    <?= $slot ?? '' ?>
  </button>
<?php endif ?>
