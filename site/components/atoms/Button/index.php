<?php
    // Catch empty strings, unset parameters, or spaces, and force clean fallbacks
    $theme   = (!isset($theme)   || trim($theme)   === '') ? false : $theme;
    $hover   = (!isset($hover)   || trim($hover)   === '') ? false    : $hover; 
    $url     = (!isset($url)     || trim($url)     === '') ? false    : $url;
    $label   = (!isset($label)   || trim($label)   === '') ? false    : $label;
    $css     = (!isset($css)     || trim($css)     === '') ? ''       : $css;
    $node    = (!isset($node)    || trim($node)    === '') ? ''       : $node;
    $icon    = (!isset($icon)    || trim($icon)    === '') ? false    : $icon;
    
    // Counter Sanitization
    $counter = (!isset($counter) || trim((string)$counter) === '') ? false : $counter;
    
    // Clean Animation Boolean Sanitization
    $reveal  = (isset($reveal) && ($reveal === 'true' || $reveal === true)) ? true : false;
    
    // Explicit check for Target field/object setup
    $target  = isset($target) ? (is_string($target) ? ($target === 'true') : $target->toBool()) : false;
?>

<?php if ($url) : ?>
	<a href="<?= $url ?>" <?= $target ? 'target="_blank" rel="noopener"' : null ?> class="button upper <?= $css ?>" <?= $theme ? 'theme="'.$theme.'"' : null ?> <?= $hover ? 'hover="'.$hover.'"' : null ?> <?= $reveal ? 'data-reveal-text' : '' ?> <?= $node ?>>
		<?php if ($label) : ?>
			<span aria-label="<?= $label ?><?= $counter !== false ? ' (' . $counter . ')' : '' ?>">
				<?= $label ?><?= $counter !== false ? ' (' . $counter . ')' : '' ?>
			</span>
		<?php endif ?>
		<?php if ($icon) : ?>
			<span class="icon"><?= svg('public/assets/images/ui/ui_'.$icon.'.svg') ?></span>
		<?php endif ?>
	</a>
<?php else: ?>
	<button class="button upper <?= $css ?>" <?= $node ?> <?= $theme ? 'theme="'.$theme.'"' : null ?> <?= $hover ? 'hover="'.$hover.'"' : null ?> <?= $reveal ? 'data-reveal-text' : '' ?>>
		<?php if ($label) : ?>
			<span aria-label="<?= $label ?><?= $counter !== false ? ' (' . $counter . ')' : '' ?>">
				<?= $label ?><?= $counter !== false ? ' (' . $counter . ')' : '' ?>
			</span>
		<?php endif ?>
		<?php if ($icon) : ?>
			<span class="icon"><?= svg('public/assets/images/ui/ui_'.$icon.'.svg') ?></span>
		<?php endif ?>
	</button>
<?php endif ?>