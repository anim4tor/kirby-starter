<?php
	$size ??= false;
	$url ??= false;
	$label ??= false;
	$css ??= false;
	$icon ??= true;
	$node ??= false;
?>
<?php if ($url) : ?>
	<a href="<?= $url ?>" class="link <?= $size ?> flex align__center gap__03 <?= $css ?>" aria-label="<?= $label ?>" <?= $node ?>>
		<span class=""><?= $label ?></span>
		<?php if ($icon) : ?>
			<span class="icon --open"><?= svg('public/assets/images/ui/ui_arrow-right.svg') ?></span>
		<?php endif ?>
	</a>
<?php else: ?>
	<div class="link <?= $size ?> <?= $css ?>" aria-label="<?= $label ?>"><span class="upper"><?= $label ?></span></div>
<?php endif ?>
