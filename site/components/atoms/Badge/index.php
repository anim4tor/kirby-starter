<?php
$label = $label ?? ($slot ?? '');
$style = $style ?? 'default';
?>
<span class="badge badge-<?= $style ?>"><?= html($label) ?></span>
