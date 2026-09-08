<?php
$text = $text ?? ($slot ?? '');
$css  = $css  ?? '';
?>
<div class="prose <?= $css ?>">
  <?= is_string($text) ? kirbytext($text) : $text ?>
</div>
